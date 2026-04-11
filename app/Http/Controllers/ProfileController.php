<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;


class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function updateExtra(Request $request): RedirectResponse
    {
        $request->validate([
            'nid_number'      => 'nullable|string|max:20',
            'mobile_number'   => 'nullable|string|max:15',
            'optional_mobile' => 'nullable|string|max:15',
            'address'         => 'nullable|string|max:255',
            'profile_photo'   => 'nullable|image|max:2048',
        ]);

        $user = $request->user();

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profiles', 'public');
            $user->profile_photo = $path;
        }

        $user->nid_number      = $request->nid_number;
        $user->mobile_number   = $request->mobile_number;
        $user->optional_mobile = $request->optional_mobile;
        $user->address         = $request->address;
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'extra-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}