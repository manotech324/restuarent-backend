<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin_Supervisor\MenuItemRequest;
use App\Services\Admin_SuperVisor\MenuService;

class MenuController extends Controller
{
    protected $service;

    public function __construct(MenuService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(MenuItemRequest $request)
    {
        $menu = $this->service->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Menu item created successfully',
            'menu_item' => $menu
        ]);
    }

    public function show($id)
    {
        $menu = $this->service->find($id);

        if(!$menu) return response()->json(['message'=>'Menu item not found'],404);

        return response()->json($menu);
    }

    public function update(MenuItemRequest $request, $id)
    {
        $menu = $this->service->find($id);
        if(!$menu) return response()->json(['message'=>'Menu item not found'],404);

        $updated = $this->service->update($menu, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Menu item updated successfully',
            'menu_item' => $updated
        ]);
    }

    public function destroy($id)
    {
        $menu = $this->service->find($id);
        if(!$menu) return response()->json(['message'=>'Menu item not found'],404);

        $this->service->delete($menu);

        return response()->json([
            'success' => true,
            'message' => 'Menu item deleted successfully'
        ]);
    }
}
