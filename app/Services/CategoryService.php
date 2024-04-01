<?php

namespace App\Customs\Services;

use App\Models\Category;
use Illuminate\Http\UploadedFile;

class CategoryService
{
    public static function storeCategoryWithImage($name, UploadedFile $image)
    {
        $name = $image->getClientOriginalName();                    
        $destinationPath = public_path('/images/category');
        $image->move($destinationPath, $name);

        $category = new Category;
        $category->name = $name;
        $category->image = $destinationPath;

        $category->save();

        return $category;
    }

    public static function updateCategoryWithImage(Category $category, $name, UploadedFile $image = null)
    {
        $category->name = $name;

        if ($image) {
            if ($category->image) {
                $oldImagePath = public_path('/images/category/') . $category->image;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/category');
            $image->move($destinationPath, $name);
            $category->image = $name;
        }

        $category->save();

        return $category;
    }

    public static function deleteCategoryWithImage(Category $category)
    {
        if ($category->image) {
            $imagePath = public_path('/images/category/') . $category->image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $category->delete();
    }
}
