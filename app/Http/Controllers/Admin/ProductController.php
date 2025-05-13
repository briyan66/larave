<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'name'  => 'required|string|max:255',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'sku'   => 'required|string|max:255|unique:products,sku', // INI WAJIB ADA
    ]);

    $validated['slug'] = Str::slug($validated['name']);

    Product::create($validated); // INI WAJIB include 'sku' dari validasi

    return redirect()->route('admin.products.index')->with('success', 'Product created.');
}


    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'sku'   => 'required|string|max:255|unique:products,sku,' . $product->id, // tambahan
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }
}
