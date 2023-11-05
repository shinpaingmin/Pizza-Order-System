<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    // direct category list page
    public function list() {
        $categories = Category::when(request('searchKey'), function($query) {
                        $query->where('category_name', 'like', '%'. request('searchKey') .'%');
                    })
                    ->orderBy('category_name', 'asc')
                    ->paginate(5);
        // $categories->appends(request()->all());
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

        return redirect()->route('category#list')->with(['createSuccess' => 'Added Successfully!']);
    }

    // delete category
    public function delete($id) {
        if($id) {
            Category::where('category_id', $id)->delete();
        }

        return redirect()->route('category#list')->with(['deleteSuccess' => 'Deleted Successfully!']);
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
