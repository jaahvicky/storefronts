<?php

namespace App\Http\Controllers\OwnerPortal;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseLaravelController;
use Illuminate\Foundation\Validation\ValidatesRequests;

class BaseController extends BaseLaravelController
{
    use DispatchesJobs, ValidatesRequests;
}

