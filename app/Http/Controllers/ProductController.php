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
            // changement du nom de l'image par un hash unique
            $image = $request->image->hashName();
            //  Déplacement de l'image dans le dossier public/product
            $request->file('image')->move(public_path('images'),$image);
            $name = $request->input('name');
            $description = $request->input('description');
            $price = $request->input('price');
            $vat = $request->input('vat');
            $product = Product::create(['name' => $name, 'description' => $description, 'price' => $price, 'vat' => $vat, 'image' => $image]);
            $product->save();
            return redirect("/");
        }else{
            return "error";
        }
    }

    public function updateForm($id){
        $product = Product::find($id);
        if ($product != null) {
            return view("product.update")->with('product',$product);
        }else{
            return redirect("/");
        }
    }

    public function postUpdateForm($id,ProductRequest $request){

        $product = Product::find($id);

        if ($request->hasFile('image')) {
            $name = $request->input('name');
            $description = $request->input('description');
            $price = $request->input('price');
            $vat = $request->input('vat');
            // get old_name to delete
            $old_image = $product->image;
            // dd(public_path("images\\".$old_image));
            // dd(public_path("images")."\\".$old_image);
            unlink(public_path("images")."\\".$old_image);
            // Add new image
            $image = $request->image->hashName();
            $request->file('image')->move(public_path('images'),$image);
            $product->name = $name;
            $product->description = $description;
            $product->price = $price;
            $product->vat = $vat;
            $product->image = $image;
            $product->save();
            return redirect("/");
        }else{
            $name = $request->input('name');
            $description = $request->input('description');
            $price = $request->input('price');
            $vat = $request->input('vat');
            $product->name = $name;
            $product->description = $description;
            $product->price = $price;
            $product->vat = $vat;
            $product->save();
            return redirect("/");
        }
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
