<?php

namespace models;

use core\Model;

class MenuDishes extends Model
{
    protected string $table = 'menu_dishes';
    protected array $allowedColumns = [
        'menu_id',
        'dish_id'
    ];

    #get all menu dishes and sort and separate by menu and make an array of arrays of menu dishes
    // public function getMenuDishesByMenu(): array
    // {
    //     $m = new Menu();
    //     $menus = $m->getMenus();
    //     $m_ids = array();

    //     foreach ($menus as $menu) {
    //         $m_ids[$menu->menu_id] = $this->getMenuDishes($menu->menu_id);
    //     }
    //     return $m_ids;
    // }

    // get all dishes for a menu
    public function getMenuDishes(int $menu_id, int $num = 100, int $offset = 0): array
    {
        $d = new Dish();

        $records = $this->select()->where('menu_id', $menu_id)->limit($num)->offset($offset)->fetchAll();
        $menu_dishes = array();
        foreach ($records as $r) {
            if ($r->menu_id == $menu_id) {
                $menu_dishes[] = $d->getDishById($r->dish_id);
            }
        }
        return $menu_dishes;
    }

    public function addMenuDish($data): void
    {
        $this->insert([
            'menu_id' => $data['menu_id'],
            'dish_id' => $data['dish_id']
        ]);
    }
}

