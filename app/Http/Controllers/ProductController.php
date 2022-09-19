<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate();
        return ProductResource::collection($products);
    }
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return ProductResource::make($product);
    }
    public function store(Request $request)
    {
        $file = $request->file('image');
        $name = Str::random(10);
        $url = Storage::putFileAs('images', $file, $name.'.'.$file->extension());
        $product = Product::create([
            'title' => $request->input('title'),
            'image' => env('MYY_URL').$url,
            'description' => $request->input('description'),
            'price' => $request->input('price'),
        ]);
        return response($product, Response::HTTP_CREATED);
    }
    public function update(Request $request, $id)
    {

    }
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
