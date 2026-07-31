<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use App\Models\TicketCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->isTicketLeader(), 403);

        $categories = TicketCategory::withCount('tickets')->orderBy('name')->paginate(15);

        return view('tickets.categories', compact('categories'));
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->isTicketLeader(), 403);

        $data = $request->validate([
            'name' => 'required|string|max:191|unique:ticket_categories,name',
            'description' => 'nullable|string|max:500',
        ]);

        TicketCategory::create($data);

        return back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, TicketCategory $category)
    {
        abort_unless(auth()->user()->isTicketLeader(), 403);

        $data = $request->validate([
            'name' => 'required|string|max:191|unique:ticket_categories,name,'.$category->id,
            'description' => 'nullable|string|max:500',
        ]);

        $category->update($data);

        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(TicketCategory $category)
    {
        abort_unless(auth()->user()->isTicketLeader(), 403);

        $category->delete();

        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}
