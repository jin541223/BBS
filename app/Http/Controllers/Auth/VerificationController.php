<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
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
        // 所有控制器内的方法都必须登录后才能访问
        $this->middleware('auth');
        // 设定只有verify动作使用signed中间件进行认证；signed是URL前面认证方式
        $this->middleware('signed')->only('verify');
        // 对verify、resend动作做频率限制
        // throttle中间件是框架提供的访问频率限制功能 如此处表示一分钟不能超过六次
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
}
