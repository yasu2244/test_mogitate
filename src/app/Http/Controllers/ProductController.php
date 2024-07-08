<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Season;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(6);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $seasons = Season::all();
        return view('products.create', compact('seasons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|image',
            'description' => 'required',
        ]);

        $path = $request->file('image')->store('public/images');
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->image = str_replace('public/', 'storage/', $path);
        $product->description = $request->description;
        $product->save();

        $product->seasons()->sync($request->seasons);

        return redirect()->route('products');
    }

    public function show($productId)
    {
        $product = Product::findOrFail($productId);
        return view('products.show', compact('product'));
    }

    public function edit($product_id)
    {
        $product = Product::findOrFail($product_id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $product_id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
        ]);

        $product = Product::findOrFail($product_id);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/images');
            $product->image = str_replace('public/', 'storage/', $path);
        }

        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();

        return redirect()->route('products.show', $product_id);
    }

    public function destroy($product_id)
    {
        $product = Product::findOrFail($product_id);
        $product->delete();
        return redirect()->route('products');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'LIKE', "%$query%")->paginate(6);
        return view('products.index', compact('products'));
    }
}

