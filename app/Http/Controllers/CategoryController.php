<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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

    // create new category function
    public function create(Request $request) {
        $this->categoryValidation($request);
        $data = $this->requestCategoryData($request);

        Category::create($data);

        return redirect()->route('category#list')->with(['createSuccess' => 'Added Successfully!']);
    }

    // delete category function
    public function delete($id) {
        if($id) {
            Category::where('id', $id)->delete();
        }

        return redirect()->route('category#list')->with(['deleteSuccess' => 'Deleted Successfully!']);
    }
    // direct edit page
    public function editPage($id) {
        $category = Category::where('id', $id)->first();
        return view('admin.category.edit', compact('category'));
    }

    // update category function
    public function update($id, Request $request) {
        // dd($request->all());
        $this->categoryValidation($request, $id);
        $data = $this->requestCategoryData($request);

        Category::where('id', $id)->update($data);
        return redirect()->route('category#list')->with(['updateSuccess' => 'Updated Successfully!']);
    }

    // category validation
    private function categoryValidation($request, $id = "") {
        Validator::make($request->all(), [
            'categoryName' => 'required|min:4|unique:categories,category_name,' . $id
        ])->validate();
    }

    // prepare category data to insert into db
    private function requestCategoryData($request) {
        return [
            'category_name' => $request->categoryName,
            'updated_at' => Carbon::now()
        ];
    }


}
