<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Naux\Mail\SendCloudTemplate;
use Mail;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'confirmation_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function owns($model)
    {
        return $this->id === $model->user_id;
    }
    
    /*
     * 这个方法负责发送邮件 并且覆盖 trait注入的methdos
     */
    public function sendPasswordResetNotification($token)
    {
        /*
                 * $data变量：参数1：给定url路径并且传入token
                 *            参数2：用户name
                 */
        $data = ['url' => url('password/reset', $token)];
        /*
         * $template变量：是SendCloudTemplate类的实例化对象 类默认传入参数，模板名字、 $data
         */
        $template = new SendCloudTemplate('JoyBoy_reset', $data);

        /*
         * Mail::raw传递template并回调函数，回调函数内，from方法写入发送邮箱的邮箱号，并备注title
         *       to方法传入用户注册的邮箱地址
         */
        Mail::raw($template, function ($message) {
            $message->from('714671404@qq.com', 'JoyBoy');

            $message->to($this->email);
        });
    }
}
