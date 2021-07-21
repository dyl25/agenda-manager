<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ServiceSetting;
use Illuminate\Http\Request;

class ServiceSettingController extends Controller
{
    public function index() {
        return ServiceSetting::all();
    }
}
