<?php 

namespace App\Repository;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategoryRepository{

    public function getCategory() {
        return Category::with([])   
            ->get();
    }

    public function findCategory($id) {
        return Category::find($id);
    }

    public function saveCategory($request) {
        try {
            $validator = \Validator::make($request->all() ,[
                "name"      => "required|unique:categories",
                "is_active" => "required",
                "main_image"     => "required|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
            ]);
            
            if($validator->fails()) {
                return responseCustom("Err Validation :" . implode(" - ", $validator->messages()->all()));
            }

            $pathFile = "public/images";
            if($request->hasFile("main_image")) {
                $image      = $request->file("main_image");
                $fileName   = time() . "-" . $image->getClientOriginalExtension();
                $pathFile   = Storage::putFile('public/images', $image);
            }

            $category               = new Category();
            $category->name         = $request->get('name');
            $category->slug         = $this->createSlug($request->get('name'));
            $category->is_active    = $request->get("is_active");
            $category->main_image   = $pathFile;
            $category->save();

            return responseCustom("Success to save category!", true);
        } catch (\Exception $e) {
            return responseCustom("Err CR-SC : " . $e->getMessage());
        }
    }

    public function updateCategory($request, $id) {
        try {
            $category = $this->findCategory($id);
            if(!$category) {
                return responseCustom("Category Not Found!");
            }

            $validator = \Validator::make($request->all() ,[
                "name"      => "required|unique:categories,id," .$id,
                "is_active" => "required",
            ]);
            
            if($validator->fails()) {
                return responseCustom("Err Validation :" . implode(" - ", $validator->messages()->all()));
            }

            if($request->hasFile("main_image")) {
                $validator = \Validator::make($request->all(), [
                    "main_image"     => "required|image|mimes:jpeg,png,jpg,gif,svg|max:2048"
                ]);

                if($validator->fails()) {
                    return responseCustom("Err Validation :" . implode(" - ", $validator->messages()->all()));
                }    
                if(Storage::exists($category->main_image)) {
                    Storage::delete($category->main_image);
                }
                $pathFile = "public/images";
                if($request->hasFile("main_image")) {
                    $image      = $request->file("main_image");
                    $fileName   = time() . "-" . $image->getClientOriginalExtension();
                    $pathFile   = Storage::putFile('public/images/category', $image);
                }
                $category->main_image = $pathFile;
            }

            $category->name         = $request->get('name');
            $category->slug         = $this->createSlug($request->get('name'));
            $category->is_active    = $request->get("is_active");
            $category->save();

            return responseCustom("Success to save category!", true);
        } catch (\Exception $e) {
            return responseCustom("Err CR-SC : " . $e->getMessage());
        }
    }

    public function createSlug($str, $delimiter = "-") {
        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
        return $slug;
    }

    public function destroyData($id) {
        try {
            $category = $this->findCategory($id);
            if(!$category) {
                return responseCustom("Category not found!");
            }
            if(Storage::exists($category->main_image)) {
                Storage::delete($category->main_image);
            }
            $category->delete();

            return responseCustom("Success To delete category!", true);
        } catch (\Exception $e) {
            return responseCustom("Err (e) : " . $e->getMessage());
        }
    }
}