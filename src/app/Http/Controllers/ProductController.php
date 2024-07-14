<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Season;
use App\Http\Requests\RegisterProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        return view('products.register', compact('seasons'));
    }

    public function store(RegisterProductRequest $request)
    {
        $validated = $request->validated();

        // 画像を保存する
        $path = $request->file('image')->store('public/images');
        $imagePath = str_replace('public/', 'storage/', $path);

        $product = Product::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'image' => $imagePath,
            'description' => $validated['description'],
        ]);

        $product->seasons()->sync($request->seasons);

        return redirect()->route('products.index')->with('success', '商品を登録しました');
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

