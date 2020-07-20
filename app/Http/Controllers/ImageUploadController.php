<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\imageUpload;
use File;

class ImageUploadController extends Controller
{

    public function index()
    {
        $images = imageUpload::orderBy('updated_at','desc')->get();
        return view('gallery',compact('images'));
    }
    //storing image to file and database
    public function storeImage(Request $request)
    {
        if($request->file('file')){

            $img = $request->file('file');

            //here we are geeting imageid alogn with an image
            $imageid = $request->imageid;

            $imageName = strtotime(now()).rand(11111,99999).'.'.$img->getClientOriginalExtension();
            $original_name = $img->getClientOriginalName();

            if(!is_dir(public_path() . '/uploads/images/')){
                mkdir(public_path() . '/uploads/images/', 0777, true);
            }

            $request->file('file')->move(public_path() . '/uploads/images/', $imageName);
            $path = 'uploads/images/'. $imageName;
            // we are updating our image column with the help of user id
            $image = imageUpload::find($imageid);
            $image->update(['image' => $path]);

            // imageid

            return response()->json(['status'=>"success",'imgdata'=>$original_name,'imageid'=>$imageid]);
        }
    }

    //Creating Database row with image title and image space
    public function storeData(Request $request)
    {
        try {
			$image = new imageUpload;
            $image->title = $request->image_title;
            $image->save();
            $image_id = $image->id; // this give us the last inserted record id
		}
		catch (\Exception $e) {
			return response()->json(['status'=>'exception', 'msg'=>$e->getMessage()]);
		}
		return response()->json(['status'=>"success", 'image_id'=>$image_id]);
    }

    //deleting image
    public function deleteImage(imageUpload $image)
    {
        $image_path = $image->image;
        if(File::exists($image_path)) {
            File::delete($image_path);
            $image->delete(); //delete from database
            $images = imageUpload::orderBy('updated_at','desc')->get();
            return view('gallery',compact('images'));
        }
        $images = imageUpload::orderBy('updated_at','desc')->get();
        return view('gallery',compact('images'));
    }
}
