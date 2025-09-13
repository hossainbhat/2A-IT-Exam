<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    const IMAGE_PATH = 'uploads/photo/';
    public function index(Request $request)
    {
        return view('admin.setting.index');
    }


    public function profile(Request $request)
    {
        if ($request->isMethod('post')) {
            $user = auth()->user()->id;
            $data = [
                'name'=>$request->name,
                'address'=>$request->address,
                'email'=>$request->email,
            ];
            if ($request->hasFile('image')) {
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $fileName = time() . '_' . rand(111, 99999) . '.' . $extension;
                    $image_tmp->move(self::IMAGE_PATH, $fileName);
                    $data['image'] = $fileName;
                }
            }
           
            // dd($data);
            User::where(['id'=>auth()->user()->id])->update($data);
        }
        return view('admin.setting.profile');
    }

    public function chkPassword(Request $request)
    {
        $data = $request->all();
        // echo "<pre>"; print_r($data);
        if (Hash::check($data['current_pwd'], auth()->user()->password)) {
            echo "true";
            die;
        } else {
            echo "false";
            die;
        }
    }

    //update password
    public function updatePassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            if (Hash::check($data['current_pwd'], auth()->user()->password)) {

                if ($data['new_pwd'] == $data['confirm_pwd']) {
                    User::where('id', auth()->user()->id)->update(['password' => bcrypt($data['new_pwd'])]);
                    return sendSuccess('updated Successfully!');
                } else {
                    return sendError("new Password & confirm password not match!");
                }
            } else {
                return sendError("Incorrect Current Password!");
            }
            return redirect()->back();
        }
    }
}
