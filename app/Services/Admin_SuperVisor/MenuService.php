<?php

namespace App\Services\Admin_SuperVisor;

use App\Models\Auth_SuperVisor\MenuItem;
use App\Models\Auth_SuperVisor\MenuItemVariant;
use App\Models\Auth_SuperVisor\MenuItemAddon;

class MenuService
{
    public function list()
    {
        return MenuItem::with(['variants','addons','category'])->get();
    }

    public function create(array $data)
    {
        $variants = $data['variants'] ?? [];
        $addons = $data['addons'] ?? [];

        $menu = MenuItem::create($data);

        foreach ($variants as $v) {
            $menu->variants()->create($v);
        }

        foreach ($addons as $a) {
            $menu->addons()->create($a);
        }

        return $menu->load(['variants','addons','category']);
    }

    public function find($id): ?MenuItem
    {
        return MenuItem::with(['variants','addons','category'])->find($id);
    }

    public function update(MenuItem $menu, array $data)
    {
        $menu->update($data);

        if(isset($data['variants'])){
            $menu->variants()->delete();
            foreach($data['variants'] as $v){
                $menu->variants()->create($v);
            }
        }

        if(isset($data['addons'])){
            $menu->addons()->delete();
            foreach($data['addons'] as $a){
                $menu->addons()->create($a);
            }
        }

        return $menu->load(['variants','addons','category']);
    }

    public function delete(MenuItem $menu)
    {
        return $menu->delete();
    }
}
