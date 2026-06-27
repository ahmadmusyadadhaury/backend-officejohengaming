<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\PajakApprovalRequestMail;
use App\Models\Notification;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehiclePajakRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VehiclePajakRequestController extends Controller
{
    public function store(Request $request, Vehicle $vehicle)
    {
        $data = $request->validate([
            'jenis' => 'required|in:tahunan,5_tahunan',
            'nominal' => 'required|numeric|min:0',
            'bukti_bayar' => 'required|image|mimes:jpeg,png|max:2048',
        ]);

        $data['vehicle_id'] = $vehicle->id;
        $data['requested_by'] = auth()->id();
        $data['status'] = 'pending';
        $data['bukti_bayar'] = $request->file('bukti_bayar')->store('vehicle-pajak-bukti', 'public');

        $pajakRequest = VehiclePajakRequest::create($data);

        $jenisLabel = $data['jenis'] === 'tahunan' ? 'Pajak Tahunan' : 'Pajak 5 Tahunan';
        $message = "Pengajuan pembayaran {$jenisLabel} {$vehicle->nama_kendaraan} ({$vehicle->plat_nomor}) menunggu approval.";

        $approvers = User::whereIn('role', ['head_of_store', 'gm', 'hr', 'admin'])->get();

        foreach ($approvers as $approver) {
            Notification::send($approver->id, 'activity', 'Pengajuan Pajak Kendaraan', $message, 'https://office.johengaming.store/');

            if ($approver->email) {
                Mail::to($approver->email)->send(new PajakApprovalRequestMail(
                    $pajakRequest,
                    $vehicle,
                    auth()->user(),
                ));
            }
        }

        return redirect()->route('admin.vehicles.index')->with('success', 'Pengajuan pembayaran pajak berhasil dikirim.');
    }

    public function pending()
    {
        $requests = VehiclePajakRequest::with(['vehicle', 'requester'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn ($r) => [
                'id' => $r->id,
                'vehicle_id' => $r->vehicle_id,
                'vehicle_name' => $r->vehicle->nama_kendaraan,
                'plat_nomor' => $r->vehicle->plat_nomor,
                'requester_name' => $r->requester->name,
                'jenis' => $r->jenis,
                'nominal' => (int) $r->nominal,
                'bukti_url' => $r->bukti_bayar ? asset('storage/'.$r->bukti_bayar) : null,
                'created_at' => $r->created_at->format('d/m/Y H:i'),
            ]);

        return response()->json($requests);
    }

    public function approve($id)
    {
        $pajakRequest = VehiclePajakRequest::with('vehicle')->findOrFail($id);

        if ($pajakRequest->status !== 'pending') {
            return response()->json(['error' => 'Request sudah diproses.'], 422);
        }

        $vehicle = $pajakRequest->vehicle;

        if ($pajakRequest->jenis === 'tahunan') {
            $vehicle->pajak_tahunan = now()->addYear();
        } else {
            $vehicle->pajak_5_tahun = now()->addYear();
        }
        $vehicle->save();

        $pajakRequest->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        $jenisLabel = $pajakRequest->jenis === 'tahunan' ? 'Pajak Tahunan' : 'Pajak 5 Tahunan';
        $message = "Pengajuan pembayaran {$jenisLabel} {$vehicle->nama_kendaraan} telah disetujui oleh ".auth()->user()->name.'.';

        Notification::send($pajakRequest->requested_by, 'activity', 'Pajak Disetujui', $message, route('admin.vehicles.index'));

        return response()->json(['success' => true]);
    }

    public function reject(Request $request, $id)
    {
        $data = $request->validate([
            'notes' => 'required|string|max:1000',
        ]);

        $pajakRequest = VehiclePajakRequest::with('vehicle')->findOrFail($id);

        if ($pajakRequest->status !== 'pending') {
            return response()->json(['error' => 'Request sudah diproses.'], 422);
        }

        $pajakRequest->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'notes' => $data['notes'],
        ]);

        $jenisLabel = $pajakRequest->jenis === 'tahunan' ? 'Pajak Tahunan' : 'Pajak 5 Tahunan';
        $message = "Pengajuan pembayaran {$jenisLabel} {$pajakRequest->vehicle->nama_kendaraan} ditolak. Alasan: {$data['notes']}";

        Notification::send($pajakRequest->requested_by, 'activity', 'Pajak Ditolak', $message, route('admin.vehicles.index'));

        return response()->json(['success' => true]);
    }
}
