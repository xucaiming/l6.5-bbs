<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class Policy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    /**
     * 返回 true 是直接通过授权；
     * 返回 false，会拒绝用户所有的授权；
     * 如果返回的是 null，则通过其它的策略方法来决定授权通过与否。
     */
    public function before($user, $ability)
	{
        // 如果用户拥有管理内容的权限的话，即授权通过
        if ($user->can('manage_contents')) {
            return true;
        }
	}
}
