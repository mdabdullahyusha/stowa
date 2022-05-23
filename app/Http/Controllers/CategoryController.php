<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Subcategory;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }






    function index() {
        $categories = Category::all();
        $categories_count = Category::all()->count();
        $trash_categories = Category::onlyTrashed()->get();
        $trash_categories_count = Category::onlyTrashed()->count();
        return view('admin.category.index',[
            'categories'=>$categories,
            'trash_categories'=>$trash_categories,
            'categories_count'=>$categories_count,
            'trash_categories_count'=>$trash_categories_count,
        ]);
    }

    function insert(CategoryRequest $request) {



        $category_id = Category::insertGetId([
            'category_name' => $request->category_name,
            'added_by' => Auth::id(),
            'created_at' => Carbon::now(),
        ]);
        $category_image = $request->category_image;
        $extension = $category_image->getClientOriginalExtension();
        $category_image_name = $category_id. '.'.$extension;

        Image::make($category_image)->resize(350, 250)->save(public_path('/uploads/category/'.$category_image_name));

        Category::find($category_id)->update([
            'category_image'=>$category_image_name,
        ]);

        return back()->with('success', 'Category Added Success!');
    }

    function delete($category_id){
        Category::find($category_id)->delete();
        return back()->with('delete','Category Deleted!');
    }

    function edit($category_id) {
        $category_info = Category::find($category_id);
        return view('admin.category.edit', compact('category_info'));
    }

    function update(Request $request) {
        Category::find($request->id)->update([
            'category_name'=>$request->category_name,
            'updated_at'=>Carbon::now(),
        ]);

        $delete_path = public_path('/uploads/category/').Category::find($request->id)->category_image;
        unlink($delete_path);

        $category_image = $request->category_image;
        $extension = $category_image->getClientOriginalExtension();
        $category_image_name = $request->id. '.'.$extension;

        Image::make($category_image)->resize(350, 250)->save(public_path('/uploads/category/'.$category_image_name));

        Category::find($request->id)->update([
            'category_image'=>$category_image_name,
        ]);
        return redirect('/category')->with('success', 'Category Update Success');
    }

    function restore($category_id) {
        Category::onlyTrashed()->find($category_id)->restore();
        return back();
    }

    function force_delete($category_id) {
        $subcategories = Subcategory::where('category_id' , $category_id)->get();
        foreach($subcategories as $sub) {
            Subcategory::find($sub->id)->delete();
        }
        $delete_path = public_path('/uploads/category/').Category::onlyTrashed()->find($category_id)->category_image;
        unlink($delete_path);
        Category::onlyTrashed()->find($category_id)->forceDelete();
        return back();
    }

    function mark_del(Request $request) {
        foreach($request->mark as $mark) {
            Category::find($mark)->delete();
        }
        return back();

    }

    function mark_restore(Request $request) {
        if($request->del == 1 ) {
            foreach($request->markt as $markt) {
                Category::onlyTrashed()->find($markt)->restore();
            }
            return back();
        }
        else {
            foreach($request->markt as $markt) {
                Category::onlyTrashed()->find($markt)->forceDelete();
            }
            return back();
        }
    }

}
