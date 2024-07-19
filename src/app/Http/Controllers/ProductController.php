<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Season;
use App\Http\Requests\RegisterProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        return $this->search($request);
    }

    public function create()
    {
        $seasons = Season::all();
        return view('products.register', compact('seasons'));
    }

    public function store(RegisterProductRequest $request)
    {
        $validated = $request->validated();

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
        $seasons = Season::all();
        return view('products.show', compact('product', 'seasons'));
    }

    public function edit($product_id)
    {
        $product = Product::findOrFail($product_id);
        return view('products.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, $product_id)
    {
        $product = Product::findOrFail($product_id);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/images');
            $product->image = str_replace('public/', 'storage/', $path);
        }

        $product->name = $validated['name'];
        $product->price = $validated['price'];
        $product->description = $validated['description'];
        $product->save();

        $product->seasons()->sync($request->seasons);

        return redirect()->route('products.show', $product_id)->with('success', '商品を更新しました');
    }

    public function destroy($product_id)
    {
        $product = Product::findOrFail($product_id);
        $product->delete();
        return redirect()->route('products.index');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $sort = $request->input('sort');
        $products = Product::query();

        if ($query) {
            $products = $products->where('name', 'LIKE', '%' . $query . '%');
        }

        if ($sort) {
            $products = $products->orderBy('price', $sort);
        }

        $products = $products->paginate(6);

        if ($request->ajax()) {
            $products->transform(function($product) {
                $product->image = asset($product->image);
                return $product;
            });

            return response()->json([
                'products' => $products->items(),
                'pagination' => (string) $products->links()
            ]);
        }

        return view('products.index', [
            'products' => $products
        ]);
    }

}


