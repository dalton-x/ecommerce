<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class APIController extends Controller
{
    public function products()
    {
        $products = Product::all();
        return response()->json($products);
    }
    public function product($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    public function login(Request $request)
    {
        // On utilise les fonctions de Laravel pour authentifier l'utilisateur
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Si cela fonctionne, on génère puis retourne un token (ainsi que le nom du token)
            $token = Auth::user()->createToken('LaravelSanctumAuth')->plainTextToken;

            return response()->json([
                "token" => $token,
                "name" => "LaravelSanctumAuth"
            ]);
        } else {
            // Si cela ne fonctionne pas, on retourne une erreur
            return abort(401);
        }
    }

    public function test() {
        // On retourne simplement les informations correspondant à l'utilisateur connecté
        return response()->json(Auth::user());
        }

    public function createProduct(Request $request){
        // if ($request->hasFile('image')) {
            // changement du nom de l'image par un hash unique
            // $image = $request->image->hashName();
            //  Déplacement de l'image dans le dossier public/product
            // $request->file('image')->move(public_path('images'),$image);
            $name = $request->input('name');
            $description = $request->input('description');
            $price = $request->input('price');
            $image = $request->input('image');
            $user_id = $request->input('user_id');
            $vat = $request->input('vat');
            // $user_id = Auth::user()->id;
            $product = Product::create(['name' => $name, 'description' => $description,'image' => $image, 'price' => $price, 'vat' => $vat,'user_id' => $user_id]);
            // $product = Product::create(['name' => $name, 'description' => $description, 'price' => $price, 'vat' => $vat, 'image' => $image, 'user_id' => $user_id]);
            $product->save();
            return response()->json($product);
        // }else{
            // return "error";
        // }
    }
}
