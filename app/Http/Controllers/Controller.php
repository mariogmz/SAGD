<?php

namespace App\Http\Controllers;

use App\User;
use JWTAuth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getLoggedInEmpleado()
    {
        if (! $user = JWTAuth::parseToken()->authenticate()) {
            return null;
        }
        return $user->morphable;
    }
}
