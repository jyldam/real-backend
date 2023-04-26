<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function index()
    {
        return response('Index');
    }
}
