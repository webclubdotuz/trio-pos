<?php

namespace App\Filters;

class CustomerFilter extends QueryBuilder
{
    public function fullname($fullname)
    {
        $this->builder->where('fullname', 'like', "%$fullname%");
    }

    public function phone($phone)
    {
        $this->builder->where('phone', 'like', "%$phone%");
    }

}
