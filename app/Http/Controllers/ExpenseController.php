<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExpenseController extends Controller
{


public function store(Request $request)
{
    $user = auth()->user();

    $validatedData = $request->validate([
        'title'       => 'required|string|max:255',
        'amount'      => 'required|numeric|min:0',
        'category_id' => 'required|integer|exists:categories,id',
        'note'        => 'nullable|string',
        'date'        => 'required|date_format:Y-m-d',
    ]); 

    try {
        $expense = $user->expenses()->create($validatedData);

       return $this->apiResponse(
            true,
            'Expense created successfully',
            $expense,
            201
        );

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Database Error',
            'error'   => config('app.debug') ? $e->getMessage() : 'Something went wrong'
        ], 500);
    }
}
}
