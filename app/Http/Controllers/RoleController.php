<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    

}
