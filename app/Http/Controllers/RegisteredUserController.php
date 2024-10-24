<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    //
    public function create()
    {
        return view('auth/register');
    }

    public function store(Request $request)
    {
        $userAttributes = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);


        $employerAttributes = $request->validate([
            'employer' => ['required'],
            'logo' => ['required', File::types(['png', 'svg', 'jpg', 'webp'])],
        ]);


        $user = User::create($userAttributes);

        // See available storage options in /app/config/filesystems.php (currently "local", "public", "s3")
        // Select one of these and update FILESYSTEM_DISK in /.env to your preference
        // we want logos to be accessible publicly so we will update /.env to reflect that by setting
        // FILESYSTEM_DISK=public.  It is set to "local" by default.
        // Now uploaded logos will be saved to /storage/app/public/logos, given the code below
        // Then we will create a sym link from there to the /public folder so that the files are publicly acessible from there.
        // Run "php artisan storage:link" to create the symlinks.
        $logoPath = $request->logo->store('logos'); // this handles the saving of the image


        $user->employer()->create([
            "name" => $employerAttributes["employer"],
            "logo" => $logoPath
        ]);


        Auth::login($user);

        return redirect('/');
    }
}
