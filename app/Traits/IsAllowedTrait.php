<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait IsAllowedTrait
{
    function ensureIsAllowed($model)
    {
        $user = Auth::guard('web')->user();
        if ($user->getRoleNames()[0] == 'manager' && $user->id != $model->created_by) {
            return [
                'isAllowed' => false,
                'user' => $user
            ];
        }
        return [
            'isAllowed' => true,
            'user' => $user,
            'model' => $model
        ];
    }
}
