<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferDetailRequest;
use App\Models\Offer;
use App\Models\OfferDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class OfferDetailController extends Controller
{
    //Add Detail To Offer Function
    public function addDetail(Offer $offer, OfferDetailRequest $offerDetailRequest)
    {
        // if ($offerDetailRequest->file('image')) {
        //     $path = $offerDetailRequest->file('image')->storePublicly('OfferImage', 'public');
        // }

        $days = $offerDetailRequest->days;

        foreach ($days as &$day) {
            if (File::isFile($day['image'])) {
                $time = time();
                Storage::put('public/OfferDetailsImage/' . $time . '.' . pathinfo($day['image'], PATHINFO_EXTENSION), file_get_contents($day['image']));
                
                $day['image'] = 'storage/OfferDetailsImage/'. $time . '.' . pathinfo($day['image'], PATHINFO_EXTENSION);
            }
        }

        $details = OfferDetail::create([
            'offer_id' => $offer->offer_id,
            'days' => json_encode($days),
            'price' => $offerDetailRequest->price,
        ]);
        $array = json_decode($details->days);
        $data = [
            'days'=>$array,
        ];
        $merge = array_merge($details->toArray(), $data);
        return success($merge, null, 201);
    }
}