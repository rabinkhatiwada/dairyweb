<?php
namespace App;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Helper{
    public static function getSetting($key){
        //Cache::rememberForever($key,function()use($key){
            $data= DB::table('settings')->where('key',$key)->first('value');
            if($data){
                return $data->value;
            }



            return '';
       // });
    }

    public static function setSetting($key,$value){
        $data=DB::table('settings')->where('key',$key)->first();
        if($data){
            DB::table('settings')->where('key',$key)->update(['value'=>$value]);
        }else{
           $setting=new Setting();
           $setting->key=$key;
           $setting->value=$value;
           $setting->save();
        }
        Cache::forget($key);
    }

    public static function getAboutPageSetting(){
        return (object)[
            'heading1' => self::getSetting('about_heading1') ?? '',
            'paragraph1' => self::getSetting('about_paragraph1') ?? '',
            'image1' => self::getSetting('about_image1') ?? '',
            'heading2' => self::getSetting('about_heading2') ?? '',
            'paragraph2' => self::getSetting('about_paragraph2') ?? '',
            'image2' => self::getSetting('about_image2') ?? '',
            'reasons' => json_decode(self::getSetting('reasons'), true) ?? [],
        ];
    }


    public static function getContactPageSetting(){
        return (object)[
            'heading' => self::getSetting('contact_heading') ?? '',
            'paragraph' => self::getSetting('contact_paragraph') ?? '',
            'location' => self::getSetting('contact_location') ?? '',


        ];
    }






}
