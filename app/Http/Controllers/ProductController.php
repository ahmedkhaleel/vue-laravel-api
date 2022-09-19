<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use App\Http\Requests\ProductCreateRequest;
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
    public function store(ProductCreateRequest $request)
    {

       $product = Product::create($request->only(['title', 'description','image','price']));

        return response($product, Response::HTTP_CREATED);
    }
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->only(['title', 'description','image','price']));
        return response($product, Response::HTTP_ACCEPTED);

    }
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
