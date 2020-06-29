<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Image;

class ProfilesController extends Controller
{
    /**
     * Show the application dashboard.
     * @username: given in the route (url, second param, see web.php)
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($username)
    {
        // dd($username);
        $user = \App\User::where('username', $username)->first();        
        if (!$user) abort(404);

        return view('profiles/index', [
            'user' => $user
        ]);
    }

    public function edit() {


        if ( !Auth::check() ) {
            abort(404);
        }


        return view('profiles/edit', [
            'user' => Auth::user()
        ]);

    }

    public function update(Request $request) {

        if (!Auth::check())
            abort(404);

        $dataUser = $request->validate([            
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255'],
            'username'  => ['required', 'string', 'max:255'],
            // 'password'  => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $dataProfile = $request->validate([
            'image'    => 'image' ,
            'title'      => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'url'      => ['required', 'url', 'max:255'],            
        ]);

        // treatment of special data: password (not! we finally removed it)
        if (!empty($dataUser['password']))
            $dataUser['password'] = Hash::make($dataUser['password']);
        
        // treatment of special data: image
        if ($image = request('image')) :
            $imagePath = request('image')->store('profile', 'public'); // 'public' could be 's3' if we use Amazon
            $resizedImage = Image::make( public_path("storage/{$imagePath}") )->fit(600, 600);
            $resizedImage->save();
            $dataProfile['image'] = 'profile/' . $resizedImage->basename;
        endif;

        $currentUser = Auth::user();
        $currentUser->update($dataUser);
        $currentUser->profile()->update($dataProfile);

        return redirect('/profile/' . $currentUser->username);
    }


    public function isFollowedByCurrentUser() {
        if (!Auth::check()) return false;

        return auth()->user()->following()->where('profiles.id', auth()->user()->id)->exists();
    }

    /// AJAX. Instead of creating an Ajax Controller, we do it here in Home.
    // public function ajaxRequest() {
    //     return view('ajaxRequest');
    // }
    public function ajaxRequestFollow(Request $request) {
        $data = $request->all();
        // processing the data. We make follow/ unfollow.
        $profile_id = $data['profile_id'];
        // make current user follow this profile
        $attached_dettached = auth()->user()->following()->toggle($profile_id); // Attached means Follow has bet set up
        $attached = !empty($attached_dettached['attached']); // if not attached then dettached. Dettached means Unfollow
        return response()->json( [
            'success' => 'Got Simple Ajax Request.',
            'is_followed' => $attached,
        ]);
    }
}
