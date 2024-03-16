<?php

namespace App\Filters;

class InstallmentPaymentFilter extends QueryBuilder
{

    public function id($id)
    {
        $this->builder->whereHas('shopOrder', function ($query) use ($id) {
            $query->where('id', $id);
        });
    }


    public function fullname($fullname)
    {
        // dd($fullname);
        $this->builder->whereHas('shopOrder', function ($query) use ($fullname) {
            $query->whereHas('customer', function ($query) use ($fullname) {
                $query->where('fullname', 'like', "%$fullname%");
            });
        });
    }

    public function phone($phone)
    {
        $this->builder->whereHas('shopOrder', function ($query) use ($phone) {
            $query->whereHas('customer', function ($query) use ($phone) {
                $query->where('phone', 'like', "%$phone%");
            });
        });
    }

    public function start_date($start_date)
    {
        $this->builder->where('date', '>=', $start_date);
    }

    public function end_date($end_date)
    {
        $this->builder->where('date', '<=', $end_date);
    }



}

?>
