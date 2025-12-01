<?php

namespace App\Services\Admin;

use App\Models\Admin\Branch;

class BranchService
{
    public function list()
    {
        return Branch::all();
    }

    public function create(array $data)
    {
        return Branch::create($data);
    }

    public function find($id): ?Branch
    {
        return Branch::find($id);
    }

    public function update(Branch $branch, array $data)
    {
        $branch->update($data);
        return $branch;
    }

    public function delete(Branch $branch)
    {
        return $branch->delete();
    }
}
