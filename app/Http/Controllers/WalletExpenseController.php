<?php

namespace App\Http\Controllers;
use App\Models\WalletExpense;
use Illuminate\Http\Request;

class WalletExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $data = WalletExpense::orderBy('id', 'DESC')->get();
        return $data;
    }
    public function save(Request $request)
    {
        $save = new WalletExpense;
        $save->user_id = $request->user_id;
        
        $save->current_balance = $request->current_balance;
        $save->amount = $request->amount;
        $save->expense_id = $request->expense_id;
 
        $save->save();
 
        return $save;
 
    }
    public function delete($id)
    {
        $wallet = (WalletExpense::find($id));
        $delete = $wallet->delete();
        return $delete;

    }
}
