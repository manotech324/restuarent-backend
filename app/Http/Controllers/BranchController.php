<?php

namespace App\Http\Controllers;

use App\Services\Admin\BranchService;
use App\Http\Requests\Admin\BrachRequest;

class BranchController extends Controller
{
    protected $service;

    public function __construct(BranchService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(BrachRequest $request)
    {
        $branch = $this->service->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Branch created successfully',
            'branch'  => $branch,
        ]);
    }

    public function show($id)
    {
        $branch = $this->service->find($id);

        if (!$branch) {
            return response()->json(['message' => 'Branch not found'], 404);
        }

        return response()->json($branch);
    }

    public function update(BrachRequest $request, $id)
    {
        $branch = $this->service->find($id);

        if (!$branch) {
            return response()->json(['message' => 'Branch not found'], 404);
        }

        $updated = $this->service->update($branch, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Branch updated successfully',
            'branch'  => $updated,
        ]);
    }

    public function destroy($id)
    {
        $branch = $this->service->find($id);

        if (!$branch) {
            return response()->json(['message' => 'Branch not found'], 404);
        }

        $this->service->delete($branch);

        return response()->json([
            'success' => true,
            'message' => 'Branch deleted successfully',
        ]);
    }
}
