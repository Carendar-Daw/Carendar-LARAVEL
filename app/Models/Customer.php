<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class Customer extends Model
{
    protected $primaryKey = 'cus_id';
    use HasFactory;
    protected $guarded = [];
    protected $cus_id = 'cus_id';
    protected $cus_email = 'cus_email';



    public static function setImage($photo, $customerEmail){
        if($photo){
           $imgName = $customerEmail.'_'.Str::random(20) . '.jpg';
           $imagen = Image::make($photo)->encode('jpg',75);
           $imagen->resize(530,470, function($constraint){
           $constraint->upsize();
           });
           Storage::disk('public')->put("images/avatar/$imgName", $imagen->stream());
           return $imgName;
           }else{
              return false;
           }
    }
    public static function deleteImagen($actual){
           Storage::disk('public')->delete("images/avatar/$actual");
    }

}
