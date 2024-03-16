<?php

namespace App\Filters;

class ProductFilter extends QueryBuilder
{

    public function id($id)
    {
        $this->builder->where('id', $id);
    }


    public function name($name)
    {
        $this->builder->where('name', 'like', "%$name%");
    }

    public function barcode($barcode)
    {
        $this->builder->where('barcode', 'like', "%$barcode%");
    }

    public function quantity($quantity)
    {
        $this->builder->where('quantity', '>', 0);
    }

}
