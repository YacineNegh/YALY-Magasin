<?php

namespace App\Http\Controllers\PublicStore;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        return view('public.about');
    }

    public function contact(): View
    {
        return view('public.contact');
    }
}
