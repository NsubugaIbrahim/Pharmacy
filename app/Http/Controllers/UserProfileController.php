<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class UserProfileController extends Controller
{
    public function show()
    {
        return view('profile.index');
    }

    public function update(Request $request)
    {
        $attributes = $request->validate([
            'username' => ['required', 'max:255', 'min:2'],
            'firstname' => ['max:100'],
            'lastname' => ['max:100'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore(auth()->user()->id)],
            'address' => ['max:100'],
            'city' => ['max:100'],
            'country' => ['max:100'],
            'postal' => ['max:100'],
            'about' => ['max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg|max:2048'],
        ]);
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('img/users', 'public');
            $attributes['image'] = $imagePath;
        } else {
            $attributes['image'] = auth()->user()->image;
        }
    
        auth()->user()->update($attributes);
    
        return back()->with('success', 'Profile successfully updated');
    }
    
}
