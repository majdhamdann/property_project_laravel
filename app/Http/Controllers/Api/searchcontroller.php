<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use App\Models\Category;
use App\Models\Property;
use App\Models\City;
use Illuminate\Support\Facades\DB;

class searchcontroller extends Controller
{
//post-> http://127.0.0.1:8000/api/customer/reviews
public function store(ReviewRequest $request)
{
        $review = new Review();
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->property_id = $request->property_id;
        $review->save();

        return response()->json(['message' => 'تم إضافة التقييم بنجاح'], 200);
}
//get-> http://127.0.0.1:8000/api/customer/show_review/1
public function show_review($id)
{
    $review=Review::query()->where('Property_id',$id)->get(['rating','comment']);
    return response()->json(['message' => $review], 200);
}
//get-> http://127.0.0.1:8000/api/customer/search_location/L
public function search_location($location){
        $properties = Property::whereHas('cities', function ($query) use ($location) {
            $query->where('governoraty', 'LIKE', "%{$location}%")
                ->orWhere('country', 'LIKE', "%{$location}%")
                ->orWhere('city', 'LIKE', "%{$location}%");
        })->get();

    return response()->json($properties);
}
//get-> http://127.0.0.1:8000/api/customer/typeproperty/1
public function indexByCategory($Category_id)
{
    $properties = Property::where('Category_id', $Category_id)
    ->join('images', 'properties.id', '=', 'images.property_id')
     ->select('properties.id', 'properties.direction','properties.available'
     ,'properties.space','properties.description',
     'properties.purpose', DB::raw('GROUP_CONCAT(images.images) AS images'))
     ->groupBy('properties.id','properties.direction',
     'properties.space','properties.description','properties.available', 'properties.purpose')
     ->get();
    return response()->json($properties);
}

}
