<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Character;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function index($id)
    {
        $user = User::find($id);
        if ($user) {
            $login_user_id = $user->id;
        } else {
            $login_user_id = "";
        }
        $character = Character::where('user_id', $id)->select('image_file', 'id')->orderBy('id', 'desc')->get();

        return view('profile', ['user' => $user, 'character' => $character, 'login_user_id' => $login_user_id]);
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('profile_edit',['user' => $user]);
    }

    public function update(UserRequest $request, $id, User $user)
    {
        $user = User::find($id);
        $user->name = request('name');
        $user->content = request('content');
        if (request('user_image'))
        {
            $uploadImg = $user->user_image = $request->file('user_image');
            $extension = $request->file('user_image')->getClientOriginalExtension();
            $filename = $request->file('user_image')->getClientOriginalName();
            $resize_image = Image::make($uploadImg)->fit(250, 250,  function ($constraint) {
                $constraint->upsize();
            })->encode($extension);
            $path = Storage::disk('s3')->put('/user/'.$filename, (string)$resize_image, 'public');
            $user->user_image = Storage::disk('s3')->url('user/'.$filename);
        } 
        $user->save();
        return redirect()->route('user.detail', ['id' => $user->id]);
    }

}
