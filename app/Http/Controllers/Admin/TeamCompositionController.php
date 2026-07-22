<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamComposition;
use Illuminate\Http\Request;

class TeamCompositionController extends Controller
{
    public function index()
    {
        $compositions = TeamComposition::orderBy('sort_order')->get();

        return view('admin.team-compositions.index', compact('compositions'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'max_count' => 'required|array',
            'max_count.*' => 'required|integer|min:0',
        ]);

        foreach ($request->max_count as $id => $value) {
            TeamComposition::where('id', $id)->update(['max_count' => $value]);
        }

        return redirect()->route('admin.team-compositions.index')->with('success', 'Komposisi tim berhasil diperbarui.');
    }
}
