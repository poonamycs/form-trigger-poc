<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\Batch;
use Carbon\Carbon; 

class FormController extends Controller
{
    public function index()
    {
        $admins = Admin::all();
        $batches = Batch::all();
        $time_slot = Batch::where('id',2)->first(); //here 2 is batch id when user will login then have to select batch
        $to = Carbon::createFromFormat('H:s:i', $time_slot->start_time);
        $from = Carbon::createFromFormat('H:s:i', $time_slot->end_time);
        $diff_in_hours = $to->diffInHours($from);
        return view('/form-popup')->with(['admins'=>$admins,'batches'=>$batches,'diff_in_hours'=>$diff_in_hours]);
    }
    public function form()
    {
        return view('welcome');
    }
    public function form_submit(Request $request)
    {
        // print_r($request->all());die();
        $user = User::where('email',$request->email)->first();
        if($user != null)
        {
            $msg = "Email Already Taken";
            return $msg;
        }
        else
        {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone_number = $request->phone;
            $user->password = $request->password;
            $user->status = 0;
            $user->save();
            return $user->id;
        }
    }
    public function statuschange(Request $request)
    {
        $id = $request->id;
        $user = User::where('id',$id)->first();
        $user->status = 1;
        $user->update();
        return redirect()->back();
    }
    public function form_popup(Request $request)
    {
        $hobby = Array();
        
        if($request->id > 0)
        {
            $admins = Admin::where('id',$request->id)->first();
            $admins->name = $request->full_name;
            $admins->gender = $request->gender;
            $hobby = [$request->hobby1 , $request->hobby2];
            $admins->hobby =json_encode($hobby);
            $admins->batch_id = $request->batch;
            // $admins->user_time_slot = $request->user_time_slot_id;
            $admins->update();
            return redirect()->back();
        }
        $admins = new Admin();
        $admins->name = $request->full_name;
        $admins->gender = $request->gender;
        $hobby = [$request->hobby1 , $request->hobby2];
        $admins->hobby =json_encode($hobby);
        $admins->batch_id = $request->batch;
        $admins->user_time_slot = $request->user_time_slot_id;
        $admins->save();
        return redirect()->back();
    }
    public function mail_send()
    {
        return 1;
    }
    public function alot_time_slot(Request $request)
    {
        $admin = new Admin();
        $admin->user_time_slot = $request->user_time_slot_id;
        $admin->save();
        return redirect()->back();
    }
}
