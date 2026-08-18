<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamComposition;
use Illuminate\Http\Request;

class TeamCompositionController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.teams.index');
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

    public function updateSingle(Request $request, TeamComposition $teamComposition)
    {
        $request->validate([
            'max_count' => 'required|integer|min:0',
        ]);

        $teamComposition->update(['max_count' => $request->max_count]);

        return redirect()->route('admin.team-compositions.index')->with('success', 'Komposisi ' . $teamComposition->label . ' berhasil diperbarui.');
    }

    public function destroy(TeamComposition $teamComposition)
    {
        $label = $teamComposition->label;
        $teamComposition->delete();

        return redirect()->route('admin.team-compositions.index')->with('success', 'Komposisi ' . $label . ' berhasil dihapus.');
    }
}
