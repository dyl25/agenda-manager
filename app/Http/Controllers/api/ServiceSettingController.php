<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Models\ServiceSetting;
use App\Models\ServiceSettingsTimes;
use Illuminate\Http\Request;

class ServiceSettingController extends Controller
{
    public function index() {
        return ServiceSetting::all();
    }

    public function store(StoreServiceRequest $request) {

        $service = new ServiceSetting();

        $service->name = $request->name;
        $service->places = $request->places;
        $service->duration = str_replace(':', '',$request->duration);
        $service->price = $request->price;

        foreach($request->days as $day) {
            $service->{$day} = 1;
        }

        $service->save();

        $serviceTimes = new ServiceSettingsTimes();

        $serviceTimes->service_id = $service->id;
        
        foreach($request->hours as $hours) {
            $serviceTimes->start_time = str_replace(':', '', $hours['startTime']);
            $serviceTimes->end_time = str_replace(':', '', $hours['endTime']);
        }

        $serviceTimes->save();

        return $service;
    }
}
