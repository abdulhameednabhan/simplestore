<?php
namespace App\Customs\Services;

use App\Models\Product;

class ProductService
{
    public static function storeProduct(array $validatedData, $image)
    {
        $product = new Product();
        $product->name = $validatedData['name'];
        $product->price = $validatedData['price'];
        $product->brand_id = $validatedData['brand_id'];
        $product->category_id = $validatedData['category_id'];
        $product->discount = $validatedData['discount'];
        $product->amount = $validatedData['amount'];
        $product->is_available = $validatedData['is_available'];
        $product->is_trendy = $validatedData['is_trendy'];
        $name = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('/images/product');
        $image->move($destinationPath, $name);
        $product->image = $name;
        $product->save();
    }

    public  static function updateProduct($id, array $validatedData, $image)
    {
        $product = Product::find($id);
        if ($product) {
            $product->name = $validatedData['name'];
            $product->price = $validatedData['price'];
            $product->brand_id = $validatedData['brand_id'];
            $product->category_id = $validatedData['category_id'];
            $product->discount = $validatedData['discount'];
            $product->amount = $validatedData['amount'];
            $product->is_available = $validatedData['is_available'];
            $product->is_trendy = $validatedData['is_trendy'];
            if ($product->image) {
                $oldImagePath = public_path('/images/product/') . $product->image;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/category');
            $image->move($destinationPath, $name);
            $product->image = $name;
            $product->save();
        }
    }

    public static function deleteProduct($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
        }
    }
}