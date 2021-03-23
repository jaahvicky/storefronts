<?php

namespace App\Http\Controllers\BackOffice;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseLaravelController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class BaseController extends BaseLaravelController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

 
}

