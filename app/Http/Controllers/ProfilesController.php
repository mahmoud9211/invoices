<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
class ProfilesController extends Controller
{
    public function index ()

    {
        return view ('profiles.index');
    }

    public function edit_page ()

    {
        return view ('profiles.edit');
    }

    public function update (Request $request, User $user)

    {
        $validation = $request->validate([
             'name' => 'required',
             'email' => 'required',Rule::unique('users')->ignore('id'),
        ]);

        if($request->photo)
        {
            if($user->profile_photo_path !== null)
            {
                Storage::disk('public_path')->delete('/user_images/'.$user->profile_photo_path);

                image::make($request->photo)->resize(200,300)->save(public_path('uploads/user_images/'.$request->photo->hashName()));

            }else{
                image::make($request->photo)->resize(200,300)->save(public_path('uploads/user_images/'.$request->photo->hashName()));


            }

            $user->update([
               'name' => $request->name,
               'email' => $request->email,
               'profile_photo_path' => $request->photo->hashName()
            ]);


     $msg = ([
        'message' =>'تم التعديل بنجاح',
        'alert-type' => 'success'
    ]);
    return redirect()->route('profile.index')->with($msg);

        }else{

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
             ]);

             $msg = ([
                'message' =>'تم الاضافة بنجاح',
                'alert-type' => 'success'
            ]);
            return redirect()->route('profile.index')->with($msg);

        }
       
    }

    public function password_page()
    {
        return view ('profiles.change_password');
    }

    public function password_change (Request $request , User $user)
    {
        $validation = $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed'
        ]);

        if(Hash::check($request->old_password,$user->password))
        {
            if(Hash::check($request->password,$user->password))
            {
                $msg = ([
                    'message' => 'كلمة السر الجديده لا يمكن ان تكون متطابقه مع كلمة السر القديمه',
                    'alert-type' => 'error'
                ]);
                return redirect()->back()->with($msg);
                 
            }else{

                $user->update([
                  'password' =>Hash::make($request->password)
             
                ]);


                $msg = ([
                    'message' => 'تم تغيير كلمة السر بنجاح',
                    'alert-type' => 'success'
                ]);

                return redirect()->to('/dashboard')->with($msg);




            }

        }else{
            $msg = ([
                'message' => 'كلمة السر الحاليه غير صحيحه',
                'alert-type' => 'error'
            ]);
            return redirect()->back()->with($msg);
        }

    }
}
