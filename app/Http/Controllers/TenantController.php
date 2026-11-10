<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index()
    {
        return "Welcome to the Tenant Dashboard!";
    }
}