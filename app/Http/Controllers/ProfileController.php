<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\JamInfo;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $user = $request->user();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'_'.Str::random(10).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);

            // hadchi optionnel: 7yd l image l9dima
            if ($user->image && file_exists(public_path('images/'.$user->image))) {
                unlink(public_path('images/'.$user->image));
            }

            $user->image = $imageName;
        }
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
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

    public function viewPageInfoController() {
        // $information = JamInfo::where('user_id', auth()->id())->get();
        // return view('pages.jammiyaInformation', ['information' => $information]);

        $information = JamInfo::where('user_id', auth()->id())->first();
        return view('pages.jammiyaInformation', compact('information'));

    }

    public function insertInfoJaam(Request $request) {
        // $request->validate([
        //     'description' => 'nullable|string',
        // ]);

        $userInfo = New JamInfo();
        $userInfo->description = $request->input('description');
        $userInfo->contact = $request->input('contuct');
        $userInfo->user_id = Auth::id();
        $userInfo->save();

        return redirect()->route('jammiya')->with('success', 'Information updated successfully.');
    }

    public function updateInfo(Request $request) {
        // $request->validate([
        //     'description' => 'nullable|string',
        //     'contact' => 'nullable|string',
        // ]);

        $userInfo = JamInfo::where('user_id', Auth::id())->first();

            $userInfo->description = $request->input('description');
            $userInfo->contact = $request->input('contuct');
            $userInfo->user_id = Auth::id();
            $userInfo->save();
            return redirect()->route('jammiya')->with('success', 'Information updated successfully.');
    }

    public function changeView() {
        $user = Auth::user();
        if ($user->role == 1) {
            return redirect()->route('jammiya');
        } else {
            return view('pages.client');
        }
    }
}
