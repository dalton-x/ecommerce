<?php

namespace App\Libs;

use App\Models\Category;

class Common
{

    public static function withVAT($price, $vat_rate) {
        return $price + $price * $vat_rate / 100;
    }

    public static function computeVAT($price, $vat_rate) {
        return $price * $vat_rate / 100;
    }

    public static function getProductsByCategoryId($id_cat){
        echo $id_cat;
        return $id_cat;
    }
    public static function getAllCAtegories(){
        $categories = Category::all();
        return $categories;
    }

}
