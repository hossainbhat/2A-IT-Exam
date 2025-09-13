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
    const CV_IMAGE_PATH = 'uploads/cv/';
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $contact = new Contact();
            $limit = 10;
            $offset = 0;
            $search = [];
            $where = [];
            $with = [];
            $join = [];
            $orderBy = [];

            if ($request->input('length')) {
                $limit = $request->input('length');
            }

            if ($request->input('order')[0]['column'] != 0) {
                $column_name = $request->input('columns')[$request->input('order')[0]['column']]['name'];
                $sort = $request->input('order')[0]['dir'];
                $orderBy[$column_name] = $sort;
            }

            if ($request->input('start')) {
                $offset = $request->input('start');
            }

            if ($request->input('search') && $request->input('search')['value'] != "") {
                $search['title'] = $request->input('search')['value'];
            }

            if ($request->input('where')) {
                $where = $request->input('where');
            }


            $contact = $contact->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
            return response()->json($contact);
        }
        return view('admin.setting.index');
    }

    public function destroy(Contact $contact)
    {
        try {
            $contact->delete();
            return sendMessage('Successfully Delete');
        } catch (\Exception $e) {
            return sendError($e->getMessage());
        }
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
