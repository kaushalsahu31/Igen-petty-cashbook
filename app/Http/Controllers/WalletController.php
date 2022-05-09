<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WalletExpense;
use App\Models\Wallet;
use App\Models\Expences;

class WalletController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $data = Wallet::all();
        return $data;
    }
    public function single()
    {
        $data = Wallet::where('user_id',auth()->user()->id)->get();
        return $data;
    }
    public function user($id)
    {
        $data = Wallet::where('user_id',$id)->get();
        return $data;
    }
    public function total()
    {
        $data = WalletExpense::orderBy("id","DESC")->get();
        return $data;
    }
    public function save(Request $request)
    {
        $check=Wallet::where('user_id',$request->user_id)->get();
        
        if(count($check)){
            $check[0]->current_balance = $request->current_balance;
            
            $check[0]->save();
        }else{
            $save = new Wallet;
            $save->user_id = $request->user_id;
            $save->current_balance = $request->current_balance;
            $save->save(); 
            
        }

        $newexpense = new WalletExpense;
        $newexpense->user_id = $request->user_id;
        $newexpense->current_balance = $request->current_balance;
        $newexpense->amount = $request->amount;
        $newexpense->expense_id = $request->expense_id;
        $newexpense->username = $request->username;
        if ($request->expense_id>0){
            $update= Expences::where('id',$request->expense_id)->get();
            $update[0]->status = $request->status;
            $update[0]->save();
        }
 
        $newexpense->save();
        return $newexpense;
    }
    public function reject(Request $request)
    {
        
        $update= Expences::where('id',$request->expense_id)->get();
        $update[0]->status = $request->status;
        $update[0]->reject_comment = $request->reject_comment;
        
        $update[0]->save();
       
        return $update;
    }
    public function delete($id)
    {
        $wallet = (Wallet::find($id));
        $delete = $wallet->delete();
        return $delete;

    } 
}



