<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SimCard;
use Illuminate\Http\Request;

class SimCardController extends Controller
{
    public function index()
    {
        $cards = SimCard::orderBy('created_at', 'desc')->get();

        $stats = [
            'total' => $cards->count(),
            'nomor_aktif' => $cards->where('status_kartu', true)->count(),
            'nonaktif' => $cards->where('status_kartu', false)->count(),
        ];

        $cardsJson = $cards->values()->map(function ($c) {
            return [
                'id' => $c->id,
                'nomor_sim_card' => $c->nomor_sim_card,
                'pic' => $c->pic,
                'jabatan' => $c->jabatan,
                'masa_aktif' => $c->masa_aktif?->format('d/m/Y'),
                'masa_tenggang' => $c->masa_tenggang?->format('d/m/Y'),
                'status_kartu' => $c->status_kartu,
                'keperluan' => $c->keperluan,
            ];
        });

        return view('admin.sim-cards.index', [
            'cards' => $cards,
            'cardsJson' => $cardsJson,
            'stats' => $stats,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nomor_sim_card' => 'required|string|max:50',
            'pic' => 'required|string|max:255',
            'jabatan' => 'required|in:Chief Executive Officer (CEO),General Manager (GM),Head of Store,Admin Master,HR,Koordinator,Karyawan',
            'masa_aktif' => 'required|date',
            'masa_tenggang' => 'required|date',
            'status_kartu' => 'boolean',
            'keperluan' => 'nullable|string',
        ]);

        $data['status_kartu'] = $request->boolean('status_kartu');

        SimCard::create($data);

        return redirect()->route('admin.sim-cards.index')->with('success', 'SIM Card berhasil ditambahkan.');
    }

    public function update(Request $request, SimCard $simCard)
    {
        $data = $request->validate([
            'nomor_sim_card' => 'required|string|max:50',
            'pic' => 'required|string|max:255',
            'jabatan' => 'required|in:Chief Executive Officer (CEO),General Manager (GM),Head of Store,Admin Master,HR,Koordinator,Karyawan',
            'masa_aktif' => 'required|date',
            'masa_tenggang' => 'required|date',
            'status_kartu' => 'boolean',
            'keperluan' => 'nullable|string',
        ]);

        $data['status_kartu'] = $request->boolean('status_kartu');

        $simCard->update($data);

        return redirect()->route('admin.sim-cards.index')->with('success', 'SIM Card berhasil diperbarui.');
    }

    public function destroy(SimCard $simCard)
    {
        $simCard->delete();

        return redirect()->route('admin.sim-cards.index')->with('success', 'SIM Card berhasil dihapus.');
    }
}
