<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Home action: redirects to the main ICS Merch Reservation page
     */
    public function index()
    {
        return redirect()->route('home');
    }
}
