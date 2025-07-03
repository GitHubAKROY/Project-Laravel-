<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller {
    public function __construct() {
        date_default_timezone_set(get_timezone());
    }

    public function index() {
        $alert_col = 'col-lg-8 offset-lg-2';
        $profile   = User::find(Auth::User()->id);
        return view('profile.profile_view', compact('profile', 'alert_col'));
    }

    public function membership_details(Request $request) {
        $alert_col = 'col-lg-8 offset-lg-2';
        $auth      = auth()->user();
        return view('profile.membership_details', compact('auth', 'alert_col'));
    }

    public function show_notification($tenant, $id) {
        if (auth()->user()->user_type == 'customer') {
            $notification = auth()->user()->member->notifications()->find($id);
        } else {
            $notification = auth()->user()->notifications()->find($id);
        }

        if ($notification && request()->ajax()) {
            $notification->markAsRead();
            return new Response('<div class="mx-2 p-3 border rounded local-notification">' . $notification->data['message'] . '</div>');
        }
        return back();
    }

    public function notification_mark_as_read($tenant, $id) {
        if (auth()->user()->user_type == 'customer') {
            $notification = auth()->user()->member->notifications()->find($id);
        } else {
            $notification = auth()->user()->notifications()->find($id);
        }
        
        if ($notification) {
            $notification->markAsRead();
        }
    }

    public function edit() {
        $alert_col = 'col-lg-10 offset-lg-1';
        $profile   = User::find(Auth::User()->id);
        return view('profile.profile_edit', compact('profile', 'alert_col'));
    }

    public function update(Request $request) {
        $this->validate($request, [
            'name'            => 'required',
            'email'           => [
                'required',
                Rule::unique('users')->ignore(Auth::User()->id),
            ],
            'profile_picture' => 'nullable|image|max:5120',
            'country_code'    => [
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->filled('mobile') && empty($value)) {
                        $fail('The country code is required when mobile is provided.');
                    }
                },
            ],
        ]);

        DB::beginTransaction();

        $profile        = Auth::user();
        $profile->name  = $request->name;
        $profile->email = $request->email;

        if ($request->hasFile('profile_picture')) {
            $image     = $request->file('profile_picture');
            $file_name = "profile_" . time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->crop(300, 300)->save(base_path('public/uploads/profile/') . $file_name);
            $profile->profile_picture = $file_name;
        }

        $profile->country_code = $request->input('country_code');
        $profile->mobile       = $request->input('mobile');
        $profile->city         = $request->input('city');
        $profile->state        = $request->input('state');
        $profile->zip          = $request->input('zip');
        $profile->address      = $request->input('address');

        $profile->save();

        DB::commit();

        $isAadminRoute = auth()->user()->user_type == 'superadmin' ? 'admin.' : '';

        return redirect()->route($isAadminRoute . 'profile.index')->with('success', _lang('Updated successfully'));
    }

    /**
     * Show the form for change_password the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function change_password() {
        $alert_col = 'col-lg-6 offset-lg-3';
        $user_type = auth()->user()->user_type;
        return view('profile.change_password', compact('alert_col'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_password(Request $request) {
        $user = auth()->user();

        $this->validate($request, [
            'oldpassword' => $user->password != null ? 'required' : 'nullable',
            'password'    => 'required|string|min:6|confirmed',
        ]);

        if ($user->password == null) {
            $user->password = Hash::make($request->password);
            $user->save();
            return back()->with('success', _lang('Password has been changed'));
        }

        if (Hash::check($request->oldpassword, $user->password)) {
            $user->password = Hash::make($request->password);
            $user->save();
        } else {
            return back()->with('error', _lang('Old Password did not match !'));
        }

        return back()->with('success', _lang('Password has been changed'));
    }

    public function job_profile() {
        $employee = auth()->user()->employee;
        return view('backend.employee.job-profile', compact('employee'));
    }

}
