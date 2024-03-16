<?php

namespace App\Filters;

class ExpenseFilter extends QueryBuilder
{

    public function start_date($value = null)
    {
        $this->builder->where('created_at', '>=', $value . ' 00:00:00');
    }

    public function end_date($value = null)
    {
        $this->builder->where('created_at', '<=', $value . ' 23:59:59');
    }

    public function expense_category_id($value = null)
    {
        $this->builder->where('expense_category_id', $value);
    }

    public function warehouse_id($value = null)
    {
        $this->builder->where('warehouse_id', $value);
    }

}
