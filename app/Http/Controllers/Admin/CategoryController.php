<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {   
        $category = Category::all();
        return view('admin.category.index', compact('category'));
    }

    public function add()
    {
        return view('admin.category.add');
    }

    public function insert(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [

                'name'=>' required|string | max:191',
                'slug'=>' required |string | max:191',
                'description'=>' required|string | max:191',
                'meta_title'=>' required |string | max:191',
                'meta_keywords'=>' required |string | max:191',
                'meta_descrip'=>' required |string | max:191',
                'image'=>['required'],
    
            ], [
                'name.required' => 'Vui lòng nhập Name',
                'slug.required' => 'Vui lòng nhập Slug',
                'description.required' => 'Vui lòng nhập Description',
                'meta_title.required' => 'Vui lòng nhập Meta Title',
                'meta_keywords.required' => 'Vui lòng nhập Meta Keywords',
                'meta_descrip.required' => 'Vui lòng nhập Meta Descrip',
                'image.required' => 'Vui lòng nhập File image',
    
            ]);
            
            if ($validator->fails()) {
                return redirect('add-category')->withErrors($validator)->withInput();
            }else{
                
                $category = new Category();
                if($request->hasFile('image')){
                    $file = $request->file('image');
                    $ext = $file->getClientOriginalExtension();
                    $filename = time().'.'.$ext;
                    $file->move('assets/uploads/category/',$filename);
                    $category->image = $filename;
                }
                $category->name = $request->input('name');
                $category->slug = $request->input('slug');
                $category->description = $request->input('description');
                $category->status = $request->input('status') == TRUE ? '1':'0';
                $category->popular = $request->input('popular') == TRUE ? '1':'0';
                $category->meta_title = $request->input('meta_title');
                $category->meta_keywords = $request->input('meta_keywords');
                $category->meta_descrip = $request->input('meta_descrip');
                $category->save();
    
                return redirect('categories')->with('status',"Category Added Successfully");
            }
        } catch (\Exception $e) {
            return response()->view('layouts.404', ['error' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.category.edit', compact('category'));
        
    }

    public function update(Request $request, $id)
    {
        try {
            $category = Category::find($id);
            if($request->hasFile('image')){
    
                $path = 'assets/uploads/category/'.$category->image;
                if (File::exists($path))
                {
                    File::delete($path);
                }
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = time().'.'.$ext;
                $file->move('assets/uploads/category/',$filename);
                $category->image = $filename;
            }
            $category->name = $request->input('name');
            $category->slug = $request->input('slug');
            $category->description = $request->input('description');
            $category->status = $request->input('status') == TRUE ? '1':'0';
            $category->popular = $request->input('popular') == TRUE ? '1':'0';
            $category->meta_title = $request->input('meta_title');
            $category->meta_keywords = $request->input('meta_keywords');
            $category->meta_descrip = $request->input('meta_descrip');
            $category->update();
            return redirect('categories')->with('status', "Category Updated Successfully");

        } catch (\Exception $e) {
            return response()->view('layouts.404', ['error' => $e->getMessage()], 500);
        }

    }

    public function destroy($id)
    {
        try {
            $category = Category::find($id);
            if($category->image){
    
                $path = 'assets/uploads/category/'.$category->image;
                if (File::exists($path))
                {
                    File::delete($path);
                }
            }
            $category->delete();
            return redirect('categories')->with('status', "Category Delete Successfully");
        } catch (\Exception $e) {
            return response()->view('layouts.404', ['error' => $e->getMessage()], 500);
        }
    }
}
?>