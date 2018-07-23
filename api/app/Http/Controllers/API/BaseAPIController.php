<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

abstract class BaseAPIController extends Controller
{
    public function __construct()
    {
        $this->middleware('api.per_page_limit')->only(['index']);
    }
}
