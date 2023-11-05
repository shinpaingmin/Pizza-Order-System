<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    // direct category list page
    public function list() {
        $categories = Category::orderBy('category_name', 'asc')->get();
        // $success = "Added Successfully!";
        return view('admin.category.list', compact('categories'));
    }

    // direct create page
    public function createPage() {
        return view('admin.category.create');
    }

    // create new category
    public function create(Request $request) {
        $this->categoryValidation($request);
        $data = $this->requestCategoryData($request);

        Category::create($data);

        return redirect()->route('category#list');
    }

    // delete category
    public function delete($id) {
        if($id) {
            Category::where('category_id', $id)->delete();
        }
        // $success = "Deleted Successfully!";
        return redirect()->route('category#list');
    }

    // category validation
    private function categoryValidation($request) {
        Validator::make($request->all(), [
            'categoryName' => 'required|unique:categories,category_name'
        ])->validate();
    }

    // prepare category data to insert into db
    private function requestCategoryData($request) {
        return [
            'category_name' => $request->categoryName
        ];
    }


}
