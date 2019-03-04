<?php

namespace App\Models;


class ProductImage extends BaseModel
{
    protected $table = 'product_images';
    protected $fillable = ['key', 'title_tr', 'title_en', 'main_image', 'publish', 'new_tab', 'position', 'publish_at', 'publish_until', 'created_by', 'updated_by'];
    public static $rules = array(
    );
    public static $updaterules = array(
    );

    public static $fields = array('key', 'title_tr', 'title_en');
    public static $imageFields = array(
        ["name" => "main_image", "width" => 1200, "height" => 800, 'crop' => true, 'naming' => 'title_tr', 'diff' => ''] //1.5
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
        "publish_at",
        "publish_until"
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
        });
    }
}