<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Http\Resources\UserResource;
use App\Models\UseCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function me()
    {


        $numcase=UseCase::where('user_id',Auth::user()->id)->count();
        return response()->json([
            'status' => true,
            'message' => 'User data retrieved successfully',
            'data' =>new SettingResource(Auth::user()),
            'case count'=>$numcase,
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $validatedData = $request->validate([
            'first_name'    => ['required', 'string', 'max:255'],
            'last_name'     => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone_number'  => ['required', 'numeric', 'digits:11'],
            'national_id'   => ['required', 'numeric','digits:14', Rule::unique('users')->ignore($user->id)],
            'date_of_birth' => ['required', 'date'],
            'image'         => ['nullable', 'image' ,'max:2048'],
        ]);

        $user->name = $validatedData['first_name'] . ' ' . $validatedData['last_name'];
        $user->email = $validatedData['email'];
        $user->phone_number = $validatedData['phone_number'];
        $user->national_id = $validatedData['national_id'];
        $user->date_of_birth = $validatedData['date_of_birth'];

        if ($request->hasFile('image')) {
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
            $user->image = $request->file('image')->store('profile_images', 'public');
        }
        $user->save();
        return response()->json([
            'status'  => true,
            'message' => 'Profile updated successfully',
            'user' => new UserResource( $user ),
        ], 200);
    }
}
