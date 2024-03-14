<?php
use App\Models\User;

use NumberToWords\NumberToWords;

function hasRoles($roles = ['admin'], $id = null)
{
    $id = $id ?? auth()->user()->id;

    foreach ($roles as $role) {
        if (User::find($id)->hasRole($role)) {
            return true;
        }
    }

}


function getUsers($roles = ['admin'])
{
    return User::whereHas('roles', function ($query) use ($roles) {
        $query->whereIn('slug', $roles);
    })->get();
}

function getAllUsers()
{
    return User::orderBy('fullname')->get();
}

function df($date, $format = 'd.m.Y')
{
    return \Carbon\Carbon::parse($date)->format($format);
}

// number format
function nf($number, $decimals = 0, $dec_point = '.', $thousands_sep = ',')
{

    if (is_null($number)) {
        return 0;
    }

    return number_format($number, $decimals, $dec_point, $thousands_sep);
}


function getExpenseCategories()
{
    return \App\Models\ExpenseCategory::orderBy('name')->get();
}

//getRolls
function getRolls()
{
    return \App\Models\Roll::orderBy('name')->get();
}

function monthName($month)
{
    $mm = [
        '1' => 'январь',
        '2' => 'февраль',
        '3' => 'март',
        '4' => 'апрель',
        '5' => 'май',
        '6' => 'июнь',
        '7' => 'июль',
        '8' => 'август',
        '9' => 'сентябрь',
        '10' => 'октябрь',
        '11' => 'ноябрь',
        '12' => 'декабрь',
    ];

    // 03 == 3
    $month = (int) $month;

    return $mm[$month];
}

function getCategories()
{
    return \App\Models\Category::orderBy('name')->get();
}

function getProducts()
{
    return \App\Models\Product::orderBy('name')->get();
}

function getBrands()
{
    return \App\Models\Brand::orderBy('name')->get();
}

function getCustomers()
{
    return \App\Models\Customer::orderBy('created_at', 'desc')->get();
}

function getSuppliers()
{
    return \App\Models\Supplier::orderBy('full_name')->get();
}

function getWarehouses()
{
    return \App\Models\Warehouse::orderBy('name')->get();
}

function getWarehouse($id)
{
    return \App\Models\Warehouse::find($id);
}

// generate Barcode
function generateBarcode()
{
    $barcode = mt_rand(10000000, 99999999);

    if (\App\Models\Product::where('code', $barcode)->exists()) {
        return generateBarcode();
    }

    return $barcode;
}

function getCurrencyRate()
{
    $currency = \App\Models\Setting::where('key', 'currency')->first();
    if($currency)
    {
        return $currency->value;
    }

    return 1;

}

// payment_method
function getPaymentMethods()
{
    return \App\Models\PaymentMethod::get();
}

function getInstallmentMonths()
{
    return \App\Models\InstallmentMonths::get();
}

// numberToWords
function numberToWords($lang, $number)
{
    $word = NumberToWords::transformNumber($lang, $number);
    return $word;
}

?>
