<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\ServiceSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(StoreBookingRequest $request) {
        
        $service = ServiceSetting::find($request->service_id);

        if(!$service->isMomentInPeriod($request->moment)) {
            return new JsonResponse('La date de la réservation n\'est pas correcte.', 422);
        }

        if(!$service->isRemainingPlaces($request->moment)) {
            return new JsonResponse('Il n\'y a plus de places disponibles pour cette horaire.', 422);
        }

        $booking = Booking::create($request->validated());

        return $booking;
    }
}
