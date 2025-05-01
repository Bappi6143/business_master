<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ExpenseController extends Controller
{
    public function index()
    {
        $categories = ExpenseCategory::orderBy('id', 'desc')->get(); // Get all expense categories
        $expenses = Expense::with('category')->latest()->get();  // Get all expenses with category data

        return view('backend.expense.index', compact('categories', 'expenses'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'expense_category_id' => 'required|exists:expense_categories,id',
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'details' => 'nullable|string',
        ]);

        // Capitalize the first letter of details if it exists
        $details = $request->has('details') ? Str::ucfirst($request->details) : null;

        Expense::create([
            'expense_category_id' => $request->expense_category_id,
            'date' => $request->date,
            'amount' => $request->amount,
            'details' => $details,
        ]);

        return back()->with('success', 'Expense added successfully!');
    }

    public function destroy(Expense $expense)
    {
        $category = $expense->category;

        // Delete the expense
        $expense->delete();

        // Check if the category has no more expenses, then delete it
        if ($category && $category->expenses()->count() === 0) {
            $category->delete();
        }

        return back()->with('success', 'Expense and its category deleted.');
    }
}
