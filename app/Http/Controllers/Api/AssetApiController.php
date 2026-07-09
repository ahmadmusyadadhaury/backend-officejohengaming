<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Http\Request;

class AssetApiController extends Controller
{
    public function index()
    {
        return response()->json(Asset::orderBy('created_at', 'desc')->get()->map(fn ($a) => [
            'id' => $a->id,
            'name' => $a->name,
            'description' => $a->description,
            'quantity' => (int) $a->quantity,
            'is_active' => $a->is_active,
            'expire_date' => $a->expire_date?->format('Y-m-d'),
            'created_at' => $a->created_at->format('Y-m-d H:i:s'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'is_active' => 'nullable|boolean',
            'expire_date' => 'nullable|date',
        ]);

        $data['is_active'] ??= true;
        $asset = Asset::create($data);

        return response()->json([
            'message' => 'Asset created successfully',
            'asset' => $asset->fresh()->only(['id', 'name', 'description', 'quantity', 'is_active', 'expire_date']),
        ], 201);
    }

    public function update(Request $request, Asset $asset)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'sometimes|required|integer|min:1',
            'is_active' => 'nullable|boolean',
            'expire_date' => 'nullable|date',
        ]);

        $asset->update($data);

        return response()->json([
            'message' => 'Asset updated successfully',
            'asset' => $asset->fresh()->only(['id', 'name', 'description', 'quantity', 'is_active', 'expire_date']),
        ]);
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();

        return response()->json(['message' => 'Asset deleted successfully']);
    }
}
