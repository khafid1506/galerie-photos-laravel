<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//On importe le modèle ImageGallery
use App\ImageGallery;

class ImageGalleryController extends Controller
{
    /**
    *
    *@return \Illuminate\Http\Response
    */

    public function index()
    {
    	//Affichage de la galerie d'images
        $images = ImageGallery::get();
    	return view('image-gallery', compact('images'));
    }

    /**
    * Upload image function
    *
    *@return \Illuminate\Http\Response
    */
    public function upload(Request $request)
    {
    	/* 
        Validation et stockage des photos.
        Infos ici : https://laravel.com/docs/5.5/validation

        As you can see, we simply pass the desired validation rules into the validate method. Again, if the validation fails, the proper response will automatically be generated. If the validation passes, our controller will continue executing normally.

        */
        $this->validate($request, [
    		'title' => 'required',
    		'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    	]);

    	//La validation précédente est OK, on passe au code suivant
        $input['image'] = time().'.'.$request->image->getClientOriginalExtension();

        $request->image->move(public_path('images'), $input['image']);

        $input['title'] = $request->title;
        ImageGallery::create($input);

    	return back()
    		->with('success','Image Uploaded successfully.');
    }

    /**
     * Remove Image function
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	ImageGallery::find($id)->delete();
    	return back()
    		->with('success','Image removed successfully.');	
    }
}
