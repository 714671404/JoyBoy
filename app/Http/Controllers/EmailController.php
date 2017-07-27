<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    /*
     * varify方法是在邮箱出发url以后判断用户是否合法注册，
     * 是否存在不存在返回首页存在修改confirmation_token
     * iscative这两个字段，使用户邮箱状态修改为以激活
     * 最终跳转页面
     */
    public function varify($token)
    {
        $user = User::where('confirmation_token', $token)->first();

        if (is_null($user)) {
            return redirect('/');
        }

        $user->confirmation_token = str_random(40);
        $user->is_active = 1;
        $user->save();

        \Auth::login($user);

        return redirect('/home');
    }
}
