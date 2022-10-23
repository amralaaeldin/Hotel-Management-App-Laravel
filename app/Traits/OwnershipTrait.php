<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait OwnershipTrait
{
    function ensureIsOwner($model)
    {
        $user = Auth::guard('web')->user();
        if ($user->getRoleNames()[0] == 'manager' && $user->id != $model->created_by) {
            return [false, $user];
        }
        return [
            'isOwner' => true, 
            'user' => $user, 
            'model' => $model];
    }
}
