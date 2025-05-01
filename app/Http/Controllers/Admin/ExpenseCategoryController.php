<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Expense;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        $categories = ExpenseCategory::orderBy('id', 'desc')->get();
        $expenses = Expense::with('category')->latest()->get();
        return view('backend.expense.index', compact('categories', 'expenses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:expense_categories,name',
            'status' => 'required|boolean',
        ]);

        // Capitalize the first letter of the name
        $name = Str::ucfirst(strtolower($request->name));

        if (auth()->check() && auth()->user()->tenant) {
            // If tenant user, insert to tenant database
            ExpenseCategory::on('tenant')->create([
                'name' => $name,
                'status' => $request->status,
            ]);
        } else {
            // For admin user, insert to main database
            ExpenseCategory::create([
                'name' => $name,
                'status' => $request->status,
            ]);
        }

        return back()->with('success', 'Expense category added successfully!');
    }



    public function destroy(ExpenseCategory $expenseCategory)
    {
        // Check if the category has associated expenses
        if ($expenseCategory->expenses()->count() > 0) {
            return back()->with('error', 'Category cannot be deleted because it has associated expenses.');
        }

        // Proceed with category delete
        $expenseCategory->delete();

        return back()->with('success', 'Expense category deleted!');
    }
}
