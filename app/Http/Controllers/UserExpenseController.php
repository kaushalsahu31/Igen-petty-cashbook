<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expences;

class UserExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index($id)
    {
        $data = Expences::where('user_id',$id)->orderBy('id', 'DESC')->get();
        return $data;
    }
    public function allexp()
    {
        $data = Expences::orderBy('id', 'DESC')->get();
        return $data;
    }
    public function save(Request $request)
    {
         
        $validatedData = $request->validate([
         'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
 
        ]);
        $imgpath= $request->file('image')->store('public/images');
        $imgpath=str_replace("public","storage",$imgpath);
        $save = new Expences;
        $save->user_id = $request->user_id;
        $save->user_name = $request->user_name;
        $save->expense_name = $request->expense_name;
        $save->date = $request->date;
        $save->expense_amount = $request->expense_amount;
        $save->img_name = $request->file('image')->getClientOriginalName();
        $save->img_path = $imgpath;
 
        $save->save();
 
        return $save;
 
    }
    public function delete($id)
    {
        $expences = (Expences::find($id));
        $delete = $expences->delete();
        return $delete;

    }
}
