<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Profile extends Controller
{
    public function admin_profil()
    {
        return view('admin.profil');
    }

    public function user_profil()
    {
        return view('user.profil');
    }

    public function update_profil(Request $request)
    {
        $id = Auth::user()->id;

        if ($request->photo) {
            $imageName = time() . '.' . $request->photo->extension();

            $request->photo->move(public_path('img'), $imageName);
            $user = User::find(Auth::user()->id)->update($request->all());

            $user2 = User::find($id)->update([
                "password" => Hash::make($request->password),
                "photo" => "/img/" . $imageName
            ]);

            if ($user && $user2) {
                return redirect()->back()->with("status", "success")->with(
                    'message',
                    'Berhasil Mengubah Profil'
                );
            }
            return redirect()->back()->with("status", "danger")->with('message', 'Gagal Mengubah Profil');
        }
        $user = User::find(Auth::user()->id)->update($request->all());
        $user2 = User::find($id)->update([
            "password" => Hash::make($request->password)
        ]);

        if ($user && $user2) {
            return redirect()->back()->with("status", "success")->with(
                'message',
                'Berhasil Mengubah Profil'
            );
        }
        return redirect()->back()->with("status", "danger")->with('message', 'Gagal Mengubah Profil');
    }
}