<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Route;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function PermissionCheck()
    {
        if (empty(getRoleCheck(Route::getCurrentRoute()->getName())) || getRoleCheck(Route::getCurrentRoute()->getName())->status == 2) {
            return false;
        } else {
            return true;
        }
    }
}
