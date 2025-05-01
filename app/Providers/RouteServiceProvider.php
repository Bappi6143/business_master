<?php

namespace App\Providers;

use App\Models\SubCategory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Customer;
use App\Models\DeliveryCharge;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Variant;
use App\Models\VariantValue;

class RouteServiceProvider extends ServiceProvider
{
    private function bindTenantModel(string $param, string $modelClass)
{
    Route::bind($param, function ($value) use ($modelClass) {
        if (Auth::check() && Auth::user()->tenant) {
            config(['database.connections.tenant.database' => Auth::user()->tenant->database_name]);
            DB::purge('tenant');
            DB::reconnect('tenant');

            return $modelClass::on('tenant')->findOrFail($value);
        }

        return $modelClass::findOrFail($value);
    });
}

    public function boot()
    {
        $this->bindTenantModel('category', Category::class);
        $this->bindTenantModel('subcategory', SubCategory::class);
        $this->bindTenantModel('variant', Variant::class);
        $this->bindTenantModel('variantValue', VariantValue::class);
        $this->bindTenantModel('delivery_charge', DeliveryCharge::class);
        $this->bindTenantModel('customer', Customer::class); 
        $this->bindTenantModel('expense_category', ExpenseCategory::class);
$this->bindTenantModel('expense', Expense::class);



    }
}
