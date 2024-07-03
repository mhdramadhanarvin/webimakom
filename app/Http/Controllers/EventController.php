<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventSubmitValidation;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index($link_registration): View
    {
        $event = Event::where('link_registration', $link_registration)->firstOrFail();
        if ($event == false) abort(404);

        return view('event', compact('event'));
    }

    public function submit(EventSubmitValidation $request)
    {
        dd($request->all());
    }
}
