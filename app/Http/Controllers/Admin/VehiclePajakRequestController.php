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
use Illuminate\Support\Facades\Storage;

class VehiclePajakRequestController extends Controller
{
    public function store(Request $request, Vehicle $vehicle)
    {
        $data = $request->validate([
            'jenis' => 'required|in:tahunan,5_tahunan',
            'nominal' => 'required|numeric|min:0|max:9999999999999.99',
            'bukti_bayar' => 'required|image|mimes:jpeg,png|max:200',
        ]);

        $data['vehicle_id'] = $vehicle->id;
        $data['requested_by'] = auth()->id();
        $data['status'] = 'pending';
        $path = $request->file('bukti_bayar')->store('vehicle-pajak-bukti', 'public');
        $this->compressBukti($path);
        $data['bukti_bayar'] = $path;

        $pajakRequest = VehiclePajakRequest::create($data);

        $jenisLabel = $data['jenis'] === 'tahunan' ? 'Pajak Tahunan' : 'Pajak 5 Tahunan';
        $message = "Pengajuan pembayaran {$jenisLabel} {$vehicle->nama_kendaraan} ({$vehicle->plat_nomor}) menunggu approval.";

        $approvers = User::whereIn('role', ['head_of_store', 'gm', 'hr', 'admin', 'ceo'])->get();

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
                'bukti_url' => $r->bukti_bayar ? route('files.show', $r->bukti_bayar) : null,
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

        if ($pajakRequest->requested_by === auth()->id()) {
            return response()->json(['error' => 'Anda tidak dapat menyetujui pengajuan sendiri.'], 422);
        }

        $vehicle = $pajakRequest->vehicle;
        $oneYearFromNow = now()->addYear();

        if ($pajakRequest->jenis === 'tahunan') {
            $vehicle->pajak_tahunan = $vehicle->pajak_tahunan?->max($oneYearFromNow) ?? $oneYearFromNow;
        } else {
            $vehicle->pajak_5_tahun = $vehicle->pajak_5_tahun?->max($oneYearFromNow) ?? $oneYearFromNow;
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

        if ($pajakRequest->requested_by === auth()->id()) {
            return response()->json(['error' => 'Anda tidak dapat menolak pengajuan sendiri.'], 422);
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

    private function compressBukti(string $path): void
    {
        $fullPath = Storage::disk('public')->path($path);
        if (! file_exists($fullPath)) {
            return;
        }

        $info = getimagesize($fullPath);
        if (! $info) {
            return;
        }

        [$width, $height] = $info;
        $maxWidth = 1200;

        if ($width <= $maxWidth && filesize($fullPath) <= 204800) {
            return;
        }

        if ($width > $maxWidth) {
            $ratio = $maxWidth / $width;
            $newWidth = $maxWidth;
            $newHeight = (int) ($height * $ratio);
        } else {
            $newWidth = $width;
            $newHeight = $height;
        }

        $src = match ($info['mime']) {
            'image/jpeg' => @imagecreatefromjpeg($fullPath),
            'image/png' => @imagecreatefrompng($fullPath),
            default => null,
        };

        if (! $src) {
            return;
        }

        $dst = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagejpeg($dst, $fullPath, 70);
        imagedestroy($src);
        imagedestroy($dst);
    }
}
