<?php

namespace App\Http\Controllers;

use App\Administrator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    public function edit($id)
    {
        $admin = Administrator::findOrFail($id);

        if(Auth::guard('admin')->check() && $admin->isNot(Auth::user()))
        {
            abort('404');
        }

        $data = [
            'admin' => $admin
        ];

        return View::make('admins.createOrUpdate')->with($data);
    }

    public function update(Request $request, $id)
    {
        $admin = Administrator::findOrFail($id);

        if(Auth::guard('admin')->check() && $admin->isNot(Auth::user()))
        {
            abort('404');
        }

        $inputs = $request->all();

        $validation = Administrator::getValidation($inputs, $admin);

        if ($validation->fails())
        {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $hashedPassword = $admin->password;
        $oldPassword = $inputs['oldPassword'];
        $newPassword = $inputs['password'];

        if(Hash::check($oldPassword, $hashedPassword))
        {
            if (Hash::check($newPassword, $hashedPassword))
            {
                return redirect()->back()->with('error', 'new password can not be the old password !');
            }
        }
        else
        {
            return redirect()->back()->with('error', 'old password doesnt match !');
        }

        // avoid forced email changes
        $inputs['email'] = $admin->email;

        $admin = Administrator::updateOne($admin, $inputs);

        return redirect()->back()->with('success', 'Item successfully edited!');
    }
}
