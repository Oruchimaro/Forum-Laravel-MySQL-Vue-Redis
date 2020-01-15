<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class UserAvatarController extends Controller
{
    public function store()
    {
        request()->validate(['avatar' => 'required|image']);

        auth()->user()->update([
            'avatar_path' => request()->file('avatar')->store('avatars', 'public')
        ]); //if u need the name $file->hashName() will give it to u

        return back();
    }
}
