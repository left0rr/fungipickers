<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthAdminRequest;
use App\Models\History;
use App\Models\Mushroom;
use App\Models\Negative;
use App\Models\Plan;
use App\Models\Positive;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Container\Attributes\Authenticated;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    /**
     * Admin Dashboard
     */
    ///
    public function index()
    {
        $negatives=Negative::all();
        $positives=Positive::all();
        $mushrooms=Mushroom::all();
        $histories=History::all();
        $users=User::all();
        $plans=Plan::all();
        $subscriptions=Subscription::all();

        return view('admin.dashboard')->with([
            'negatives'=>$negatives,
            'positives'=>$positives,
            'mushrooms'=>$mushrooms,
            'histories'=>$histories,
            'users'=>$users,
            'plans'=>$plans,
            'subscriptions'=>$subscriptions,
        ]);
    }
    /**
     * display login form
     */
    public function login(){
        if(auth()->guard('admin')->check()){
            return redirect()->route('admin.index');
        }
        return view('admin.login');
    }
    /**
     * login admin
     */
    public function auth(AuthAdminRequest $request)
    {
        if ($request->validated()) {
            if (auth()->guard('admin')->attempt([
                'email' => $request->email,
                'password' => $request->password,
            ])) {
                $request->session()->regenerate();
                return redirect()->route('admin.index');

            }else{
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                    'password' => ['The provided credentials are incorrect.'],
                ]);
            }
        }
    }
    /**
     * Logout
     */
    public function logout(){
        auth()->guard('admin')->logout();
        return redirect()->route('admin.login');

    }
}
