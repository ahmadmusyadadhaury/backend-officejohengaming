<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index() { return view('admin.teams.index', ['teams' => Team::withCount('members')->paginate(15)]); }
    public function create() { return view('admin.teams.create'); }
    public function store(Request $request) {
        $request->validate(['name' => 'required|string|max:255']);
        Team::create($request->only('name', 'description') + ['is_active' => true]);
        return redirect()->route('admin.teams.index')->with('success', 'Tim berhasil ditambahkan.');
    }
    public function edit(Team $team) { return view('admin.teams.edit', compact('team')); }
    public function update(Request $request, Team $team) {
        $request->validate(['name' => 'required|string|max:255']);
        $team->update($request->only('name', 'description', 'is_active'));
        return redirect()->route('admin.teams.index')->with('success', 'Tim berhasil diperbarui.');
    }
    public function destroy(Team $team) {
        $team->delete();
        return redirect()->route('admin.teams.index')->with('success', 'Tim berhasil dihapus.');
    }
}
