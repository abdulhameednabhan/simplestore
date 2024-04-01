<?php
namespace App\Http\Controllers\Api\V1\Products;

use App\Models\Product;
use App\Http\Requests\ProductRequest\ProductStoreRequest;
use App\Http\Requests\ProductRequest\ProductUpdateRequest;
use App\Services\ProductService; 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
   

    public function __construct( )
    {
       
    }

    public function index()
    {
        $products = Product::paginate(10);
        if ($products) {
            return response()->json($products, 200);
        } else {
            return response()->json('no products');
        }
    }

    public function show($id)
    {
        $product = Product::find($id);
        if ($product) {
            return response()->json($product, 200);
        } else {
            return response()->json('product was not found');
        }
    }

    public function store(ProductStoreRequest $request)
    {
        ProductService::storeProduct($request->validated(), $request->file('image'));
        return response()->json('Product added', 201);
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        ProductService::updateProduct($id, $request->validated(), $request->file('image'));
        return response()->json('Product updated', 200);
    }

    public function destroy($id)
    {
        ProductService::deleteProduct($id);
        return response()->json('Product deleted', 200);
    }
}
