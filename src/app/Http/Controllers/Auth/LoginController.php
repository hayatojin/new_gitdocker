<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Googleのアカウント選択画面へリダイレクト
    public function redirectToProvider(string $provider)
    {
        // Socialiteのdriverメソッドに、外部のサービス名を渡し、リダイレクト
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(Request $request, string $provider)
    {
        // Googleからユーザー情報を取得
        $providerUser = Socialite::driver($provider)->stateless()->user();

        // Googleから取得したユーザー情報から、メールアドレスを取り出し、そのメアドがusersテーブルにあるか調べる
        $user = User::where('email', $providerUser->getEmail())->first();

        // 本サービスのusersテーブルに、Googleから取得したメールアドレスがあれば、ログインレスポンスを返す
        if ($user) {
            $this->guard()->login($user, true);
            return $this->sendLoginResponse($request);
        }

        return redirect()->route('register.{provider}', [
            'provider' => $provider,
            'email' => $providerUser->getEmail(),
            'token' => $providerUser->token,
        ]); 
    }       
}
