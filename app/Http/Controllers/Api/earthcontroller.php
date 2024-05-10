<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Property;
use App\Models\Image;
use Illuminate\Support\Facades\DB;

class earthcontroller extends Controller
{
//post-> http://127.0.0.1:8000/api/customer/create
public function createproperty(Request $request)
{
        //validation
    $request->validate([
            'name' => 'required|string',
            'number' => 'required|string',
            "direction"=>"required",
            "purpose"=>"required",
            "description"=>"required",
            "price"=>"required",
            "space"=>"required",
            "Category_id"=>'required|exists:categories,id',
            'city_id' => 'required|exists:cities,id',
            'available'=>"required",
         ]);

        //create and save
        $property = new Property();
        $property ->auth_id= auth()->user()->id;
        $property ->direction= $request->direction;
        $property ->name= $request->name;
        $property ->number= $request->number;
        $property ->purpose= $request->purpose;
        $property ->description= $request->description;
        $property ->price= $request->price;
        $property ->space= $request->space;
        $property ->Category_id= $request->Category_id;
        $property ->city_id= $request->city_id;
        $property ->available= $request->available;
        $property ->save();
       
        return response()->json(['message' => 'تمت إضافة العقار بنجاح']);
}


public function addphoto(Request $request){
    $request->validate([
        'name' => 'required|string',
        'path' => 'required|string',
        'images' => 'required|array',
        "property_id"=>'required|exists:properties,id',
       'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
    ]);
    $storedImages = [];
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('public/storage/images');
            $storedImages[] = $path;
        }
    }
    $record = new Image();
  
    $record->name = $request->name;
    $record->path = $request->path;
    $record->property_id = $request->property_id;
    $record->images = $storedImages;
    $images = Image::pluck('images')->toArray();
    $record->save();
    return response()->json(['message' => 'تمت إضافة  صورةالعقار بنجاح']);

  
}
 /*public function store_image(Request $request){
   $validate= $request->validate([
        'name' => 'required|string',
        'path' => 'required|string',
        'images' => 'required|array',
        'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
    ]);
    $storedImages = [];
    
    if ($request->hasFile('images')) {
        foreach ($validate['images'] as $image) {
            $storedImage =$image->file('images')->store('storage/app/public/images');
           // $storedImage =$request->images->store('public/images'); // المسار الذي ترغب في تخزين الصور فيه
            $storedImages[] = $storedImage;
        }
    }
    $record = new Image;
    $record->name = $request->name->getClientOriginalName();
    $record->path = $request->path;
    $record->images = $storedImages;
    $record->images = json_encode(['description' => 'وصف الصورة']);
    $record->save();

}*/
//get-> http://127.0.0.1:8000/api/customer/list
public function listproperty()
    { 
    
    $properties = DB::table('properties')
    ->join('images', 'properties.id', '=', 'images.property_id')
    ->select('properties.id', 'properties.direction','properties.available'
    ,'properties.space','properties.description',
    'properties.purpose', DB::raw('GROUP_CONCAT(images.images) AS images'))
    ->groupBy('properties.id','properties.direction',
    'properties.space','properties.description','properties.available', 'properties.purpose')
    ->get();

    return response()->json([
       "status" => 1,
       "message" => "هذه هي العقارات الموجودة",
       "data" => $properties
      ]);
}
//get->http://127.0.0.1:8000/api/customer/single-property/5
public function single_property($id){
        $properties = DB::table('properties')
        ->where('properties.id','=',$id)->get(['direction','purpose','description','price','space','Category_id','city_id']);

        return response()->json([
            "status"=>1,
            "messege"=>"this is the property found",
            "data"=>$properties
         ]);
}
//post-> http://127.0.0.1:8000/api/customer/update-property/8
public function update_property(Request $request,$id){
    $auth_id= auth()->user()->id;
    if(Property::where([
       "auth_id"=>$auth_id,
       "id"=>$id
     ])->exists()){
       $property=Property::find($id);
       $property->price=isset($request->price)?$request->price:$property->price;
       $property->available=isset($request->available)?$request->available:$property->available;
       $property->save();
       return response()->json([
        "status"=>1,
        "messege"=>"the update successfully"
      ]);
     }
     else
     {
        return response()->json([
            "status"=>0,
            "messege"=>"this property do not exists"
          ]);

     }
}
 //delete-> http://127.0.0.1:8000/api/customer/delet-property/3
public function delete_property($propertyId){
    $auth_id= auth()->user()->id;
    if(Property::where([
       "auth_id"=>$auth_id,
       "id"=>$propertyId
     ])->exists()){
        Image::where('property_id', $propertyId)->delete();
        Property::where('id', $propertyId)->delete();
       return response()->json(['message' => 'تم حذف العقار والصور المرافقة بنجاح']);

     }
     else
     {
        return response()->json([
            "status"=>0,
            "messege"=>"this property do not exists"
          ]);

     }
    

    
   
}
}
