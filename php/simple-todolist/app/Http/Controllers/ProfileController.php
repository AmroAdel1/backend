<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    // Show settings page
    public function index()
    {
        return view('profile.index');
    }

    // Update profile information
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $user->update($validated);

        return back()->with('success', 'Profile updated successfully!');
    }

    // Update password
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],   // Rules\Password::defaults()
        ]);

        $user = Auth::user();

        // Update password
        $user->update([
            'password' => Hash::make($validated['password'])
        ]);

        return back()->with('success', 'Password updated successfully!');
    }

    // Upload/Remove avatar
    public function updateAvatar(Request $request)
    {
        $user = Auth::user();

        // Remove avatar
        if ($request->has('remove_avatar')) {           // get avatar input name for remove
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
                $user->update(['avatar' => null]);
            }
            return back()->with('success', 'Avatar removed successfully!');
        }

        // Check if cropped image data exists
        if ($request->has('cropped_image')) {          // get cropped image input name
            // Decode base64 image
            $imageData = $request->input('cropped_image');
            $imageData = str_replace('data:image/png;base64,', '', $imageData);
            $imageData = str_replace(' ', '+', $imageData);
            $imageData = base64_decode($imageData);

            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Save new avatar
            $filename = 'avatar_' . $user->id . '_' . time() . '.png';
            Storage::disk('public')->put('avatars/' . $filename, $imageData);

            $user->update(['avatar' => 'avatars/' . $filename]);

            return back()->with('success', 'Avatar updated successfully!');
        }

        // Fallback to regular upload
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');       // get avatar input name
        $user->update(['avatar' => $path]);

        return back()->with('success', 'Avatar updated successfully!');
    }

    // Delete account
    public function destroy(Request $request)
    {
        $user = Auth::user();

        // Delete avatar if exists
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Delete all user's todos
        $user->todos()->delete();

        // Logout user
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Delete user
        $user->delete();

        return redirect()->route('auth.login')
            ->with('success', 'Your account has been deleted successfully.');
    }
}



/*
    asset() ==> generates publicly accessible URL for app static assets(images, CSS, and JS files).
Key Features
Points to the public directory: It automatically prepends the base URL of your application to the given path, assuming the assets are stored within the public directory (or a symlinked location like public/storage).
Environment Agnostic: This helper is particularly useful because it dynamically adjusts the generated URL based on your application's configuration (specifically the APP_URL or ASSET_URL environment variables). This prevents broken links when deploying an application from a local environment to a live server, or when moving assets to a Content Delivery Network (CDN).
Protocol Aware: By default, it uses the same URL scheme (HTTP or HTTPS) as the current request, or you can explicitly force HTTPS using the second optional parameter.
Usage Example
In your Blade templates, you would use the asset() function like this:
For a CSS file in public/css/style.css:
blade
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
For an image in public/img/logo.png:
blade
<img src="{{ asset('img/logo.png') }}" alt="Logo">
For a JavaScript file in public/js/app.js:
blade
<script src="{{ asset('js/app.js') }}"></script>

Comparison with Other Helpers
Function 	Purpose
asset($path)	Generates a URL for files in the public directory (CSS, JS, images).
url($path)	Generates a fully qualified URL to a given path within the application.
route($name)	Generates a URL to a named application route.
Storage::url($path)	Generates a URL for dynamically uploaded files (e.g., user avatars) often stored in storage/app/public and symlinked to the public directory.
*/
