<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{  
    use HasFactory;
    // Proviens que du formulaire
    protected $fillable = [
        'id','image','name','description','price','vat','user_id'
    ];
}
