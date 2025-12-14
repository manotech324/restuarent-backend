<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Auth_SuperVisor\Table;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TableController extends Controller
{
    /**
     * List all tables
     */
    public function index(): JsonResponse
    {
        $tables = Table::all();
        return response()->json([
            'success' => true,
            'tables' => $tables
        ]);
    }

    /**
     * Store a new table
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|unique:tables,name'
        ]);

        $table = Table::create([
            'name' => $request->name
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Table created successfully',
            'table' => $table
        ]);
    }

    /**
     * Show a single table
     */
    public function show(Table $table): JsonResponse
    {
        return response()->json([
            'success' => true,
            'table' => $table
        ]);
    }

    /**
     * Update a table
     */
    public function update(Request $request, Table $table): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|unique:tables,name,' . $table->id
        ]);

        $table->update([
            'name' => $request->name
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Table updated successfully',
            'table' => $table
        ]);
    }

    /**
     * Delete a table
     */
    public function destroy(Table $table): JsonResponse
    {
        $table->delete();

        return response()->json([
            'success' => true,
            'message' => 'Table deleted successfully'
        ]);
    }
}
