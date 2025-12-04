<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

class FAQController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth', except: ['index']),
        ];
    }

    // Testing Changes to main (remove comment later)
    /**
     * Show the application dashboard.
     */
    public function index(): View
    {
        return view('pages.FAQ');
    }
}
