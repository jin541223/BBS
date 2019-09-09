<?php

namespace App\Models;

use Auth;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmailContract
{
    use MustVerifyEmailTrait;

    use Notifiable {
        notify as laravelNotify;}/**
     * The attributes that are mass assignable.
     * 防止用户随意修改模型数据，只有在此属性中定义的字段，才允许修改，否则会被忽略
     * @var array
     */protected $fillable = [
        'name', 'phone', 'email', 'password', 'introduction', 'avatar', 'weixin_openid', 'weixin_unionid',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    function topics()
    {
        return $this->hasMany(Topic::class);
    }

    function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    function replies()
    {
        return $this->hasMany(Reply::class);
    }

    function notify($instance)
    {
        // 校验要通知的用户是否为本人
        if ($this->id == Auth::id()) {
            return;
        }

        if (method_exists($instance, 'toDatabase')) {
            $this->increment('notification_count');
        }

        $this->laravelNotify($instance);
    }

    function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }
}
