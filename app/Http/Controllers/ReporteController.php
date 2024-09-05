<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReporteController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('permission:reporte');
    }

    public function index()
    {
        return view('reporte.index');
    }
}
