<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name'   => ['required', 'string', 'max:255'],
            'email'  => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'avatar' => ['nullable', 'file'],
        ]);

        if ($request->hasFile('avatar')) {
            // Mirror the blog-image convention (public/assets/images/...) so we
            // don't rely on the storage symlink which SiteGround blocks.
            $destDir = public_path('assets/images/avatars');
            if (!is_dir($destDir)) {
                @mkdir($destDir, 0755, true);
            }

            // Remove previous avatar if it lives under assets/images/avatars
            if ($user->avatar_path && str_starts_with($user->avatar_path, 'assets/images/avatars/')) {
                $old = public_path($user->avatar_path);
                if (is_file($old)) {
                    @unlink($old);
                }
            }

            $file = $request->file('avatar');
            $ext = $file->getClientOriginalExtension() ?: 'png';
            $filename = time() . '_' . Str::random(20) . '.' . $ext;
            $file->move($destDir, $filename);

            $data['avatar_path'] = 'assets/images/avatars/' . $filename;
        }

        unset($data['avatar']);
        $user->update($data);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password updated successfully.');
    }

    public function updateContact(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'phone'           => ['nullable', 'string', 'max:32'],
            'secondary_phone' => ['nullable', 'string', 'max:32'],
            'secondary_email' => ['nullable', 'email', 'max:255'],
        ]);

        $user->update($data);

        return back()->with('success', 'Contact info updated successfully.');
    }
}
