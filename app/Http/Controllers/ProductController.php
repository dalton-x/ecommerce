<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Libs\Common;
use App\Models\Product;
use App\Models\ProductManager;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function viewAll()
    {
        $products = Product::get();
        return view("product.products")
            ->with("products", $products);
    }

    public function detail($id)
    {
        $product = Product::find($id);
        return view("product.detail")
            ->with("product", $product);
    }

    public function createForm()
    {
        return view("product.create");
    }

    public function postForm(ProductRequest $request)
    {
        // Récupere toutes les données du formulaire
        // dd($request->all());
        // Récupere uniquement l'input selectionné
        // dd($request->input('name'));

        // Vérification si le fichier image est bien présent
        if ($request->hasFile('image')) {
            //  Déplacement de l'image dans le dossier public/product
            $request->file('image')->store('product');
            // changement du nom de l'image par un hash unique
            $image = $request->image->hashName();
            $name = $request->input('name');
            $description = $request->input('description');
            $price = $request->input('price');
            $vat = $request->input('vat');
            $product = Product::create(['name' => $name, 'description' => $description, 'price' => $price, 'vat' => $vat, 'image' => $image]);
            $product->save();
            return "Nouveau produit enregistré";
        }else{
            return "error";
        }
    }

    public function updateForm($id){
        $product = Product::find($id);
        return view("product.update")->with('product',$product);
    }

    public function postUpdateForm($id,ProductRequest $request){

        $product = Product::find($id);

        $name = $request->input('name');
        $description = $request->input('description');
        $price = $request->input('price');
        $vat = $request->input('vat');
        $image = "coucou.png";
        $product->name = $name;
        $product->description = $description;
        $product->price = $price;
        $product->vat = $vat;
        $product->image = $image;
        $product->save();
        return "Produit ".$name." a été mis à jour";

    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::find($id);
        $cart = $request->session()->get('cart', []);

        if ($product !== null) {
            $found = false;
            foreach ($cart as $line) {
                if ($line->id == $id) {
                    $line->quantity++;
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $product->quantity = 1;
                array_push($cart, $product);
            }
            $request->session()->put('cart', $cart);
            return redirect(url('/cart'));
        } else {
            return view("error")
                ->with("code", 404)
                ->with("message", "Ce produit n'existe pas");
        }
    }


    public function viewCart(Request $request)
    {
        $cart = $request->session()->get('cart', []);

        $total = 0;
        $vat = 0;
        foreach ($cart as $product) {
            $total = $product->quantity * $product->price;
            $vat = Common::computeVAT($total, $product->vat);
        }
        return view("cart.index")
            ->with('total', $total)
            ->with('vat', $vat);
    }
}
