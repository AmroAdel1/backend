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
            'password' => ['required', 'confirmed', Password::min(8)],
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
        if ($request->has('remove_avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
                $user->update(['avatar' => null]);
            }
            return back()->with('success', 'Avatar removed successfully!');
        }

        // Check if cropped image data exists
        if ($request->has('cropped_image')) {
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

        $path = $request->file('avatar')->store('avatars', 'public');
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
