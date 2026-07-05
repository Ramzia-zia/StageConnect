<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompanyDashboardController extends Controller
{
    //
        public function index()
    {
        return view('dashboards.company'); // Remplace 'student' par 'company' ou 'admin' pour les autres
    }
}
