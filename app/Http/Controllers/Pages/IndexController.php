<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Place;
use Illuminate\Http\Request;

/**
 * Class IndexController
 * @package App\Http\Controllers\Pages
 */
class IndexController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $places = Place::all();

        return view('welcome', compact('places'));
    }
}
