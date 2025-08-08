<?php

namespace App\Http\Controllers;

use App\Models\Items;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    public function index()
    {
        try {
            return Items::with('department')->get();
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            return Items::create($request->only('name', 'quantity', 'description', 'department_id'));
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $item = Items::with('department')->find($id);
            if (!$item) {
                return response()->json(['message' => 'Item not found'], 404);
            }
            return $item;
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $item = Items::find($id);
            if (!$item) {
                return response()->json(['message' => 'Item not found'], 404);
            }
            $item->update($request->only('name', 'quantity', 'description', 'department_id'));
            return ['message' => 'Item updated'];
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $item = Items::find($id);
            if (!$item) {
                return response()->json(['message' => 'Item not found'], 404);
            }
            $item->delete();
            return ['message' => 'Item deleted'];
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
