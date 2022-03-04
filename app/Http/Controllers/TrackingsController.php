<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrackingRequest;
use App\Models\Tracking;
use App\Services\TrackingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class TrackingsController extends Controller
{

    /**
     * @var TrackingService
     */
    protected $service;

    public function __construct(TrackingService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $trackings = Tracking::all();

        return Inertia::render('Trackings', [
            'trackings' => $trackings
        ]);
    }

    public function store(StoreTrackingRequest $request)
    {
        $this->service->store($request->code);
        return Redirect::route('tracking.index');
    }

    public function update()
    {
        $this->service->update();
        return Redirect::route('tracking.index');
    }




}
