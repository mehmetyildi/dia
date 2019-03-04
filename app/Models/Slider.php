<?php

namespace App\Models;


class Slider extends BaseModel
{
    protected $table = 'sliders';
    protected $fillable = ['title_tr', 'title_en', 'main_image', 'caption_tr', 'caption_en', 'link',  'publish', 'new_tab', 'position', 'publish_at', 'publish_until', 'created_by', 'updated_by'];
    public static $rules = array(
    );
    public static $updaterules = array(
    );

    public static $fields = array('title_tr', 'title_en', 'link', 'caption_en','caption_tr');
    public static $imageFields = array(
        ["name" => "main_image", "width" => 700, "height" => 500, 'crop' => true, 'naming' => 'title_tr', 'diff' => 'tr'] ,//1.4
    );
    public static $imageFieldNames = array(
        "main_image"
    );
    public static $docFields = array(
    );
    public static $booleanFields = array(
        "publish",
        "new_tab"
    );
    public static $dateFields = array(
        "publish_until",
        "publish_at"
    );
    public static $urlFields = array(
    );

    public static function boot(){
        parent::boot();
        static::creating(function($model)
        {
            if($model->publish_at == null){
                $model->publish_at = todayWithFormat('Y-m-d');
            }
            if($model->title_en == null){
                $model->title_en = $model->title_tr;
            }
            if($model->caption_en == null){
                $model->caption_en = $model->caption_tr;
            }
        });
    }
}