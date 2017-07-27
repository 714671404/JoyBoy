<?php

namespace App\Http\Controllers\Auth;

use Mail;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Naux\Mail\SendCloudTemplate;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        /*
         * 创建用户是，默认头像路径
         * 默认设置token 并出发方法sendVarifyEmailTo方法发送邮件提示激活
         */
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'confirmation_token' => str_random(40),
            'avatar' => '/images/avatar/001.jpg',
            'password' => bcrypt($data['password']),
        ]);

        $this->sendVarifyEmailTo($user);

        return $user;
    }
    /*
     * 发送激活邮件
     */
    private function sendVarifyEmailTo($user)
    {
        /*
         * $data变量：参数1：给定url路径并且传入token
         *            参数2：用户name
         */
        $data = [
            'url' => route('email.varify', ['token' => $user->confirmation_token]),
            'name' => $user->name
        ];
        /*
         * $template变量：是SendCloudTemplate类的实例化对象 类默认传入参数，模板名字、 $data
         */
        $template = new SendCloudTemplate('JoyBoy', $data);

        /*
         * Mail::raw传递template并回调函数，回调函数内，from方法写入发送邮箱的邮箱号，并备注title
         *       to方法传入用户注册的邮箱地址
         */
        Mail::raw($template, function ($message) use ($user) {
            $message->from('714671404@qq.com', 'JoyBoy');

            $message->to($user->email);
        });
    }
}
