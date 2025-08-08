<?php

namespace App\Http\Controllers;

use App\Models\Departments;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    public function index()
    {
        try {
            return Departments::all();
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            return Departments::create($request->only('nome'));
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $department = Departments::find($id);
            if (!$department) {
                return response()->json(['message' => 'Department not found'], 404);
            }
            return $department;
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $department = Departments::find($id);
            if (!$department) {
                return response()->json(['message' => 'Department not found'], 404);
            }
            $department->update($request->only('nome'));
            return ['message' => 'Department updated'];
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $department = Departments::find($id);
            if (!$department) {
                return response()->json(['message' => 'Department not found'], 404);
            }
            $department->delete();
            return ['message' => 'Department deleted'];
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
