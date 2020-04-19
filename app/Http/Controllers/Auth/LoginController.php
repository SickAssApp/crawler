<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Auth;
use Exception;
use App\User;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
   
    public function handleGoogleCallback()
    {
        try {
  
            $user = Socialite::driver('google')->user();
   
            $finduser = User::where('google_id', $user->id)->first();
   
            if($finduser){
   
                Auth::login($finduser);
  
                return redirect('/login');
   
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => 'google',
                    'google_id'=> $user->id
                ]);
  
                Auth::login($newUser);
   
                return redirect()->to('/');
            }
  
        } catch (Exception $e) {
            Log::error($e);

            return redirect('auth/google');
        }
    }

}
