<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.product.index', compact('products'));
    }

    public function add()
    {
        $category = Category::all();

        return view('admin.product.add', compact('category'));
    }

    public function insert(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [

                'cate_id'=>' required',
                'name'=>' required|string | max:191',
                'slug'=>' required |string | max:191',
                'small_description'=>' required|string | max:191',
                'description'=>' required|string | max:191',
                'original_price'=>' required| numeric',
                'selling_price'=>' required| numeric',
                'qty'=>' required | numeric',
                'tax'=>' required |string',
                'meta_title'=>' required |string | max:191',
                'meta_keywords'=>' required |string | max:191',
                'meta_description'=>' required |string | max:191',
                'image'=>['required'],
    
            ], [
                'cate_id.required' => 'Vui lòng chọn Category',
                'name.required' => 'Vui lòng nhập Name',
                'slug.required' => 'Vui lòng nhập Slug',
                'small_description.required' => 'Vui lòng nhập Small Description',
                'description.required' => 'Vui lòng nhập Description',
                'original_price.required' => 'Vui lòng nhập original price',
                'original_price.numeric' => 'Original price Phải là số',

                'selling_price.required' => 'Vui lòng nhập selling price',
                'selling_price.numeric' => 'Selling price Phải là số',

                'qty.required' => 'Vui lòng nhập qty',
                'qty.numeric' => 'Qty Phải là số',

                'tax.required' => 'Vui lòng nhập tax',
                'meta_title.required' => 'Vui lòng nhập Meta Title',
                'meta_keywords.required' => 'Vui lòng nhập Meta Keywords',
                'meta_description.required' => 'Vui lòng nhập Meta Description',
                'image.required' => 'Vui lòng nhập File image',
    
            ]);
            
            if ($validator->fails()) {
                return redirect('add-products')->withErrors($validator)->withInput();
            }else{
                
                $products = new Product();
                if($request->hasFile('image')){

                    $file = $request->file('image');
                    $ext = $file->getClientOriginalExtension();
                    $filename = time().'.'.$ext;
                    $file->move('assets/uploads/products/',$filename);
                    $products->image = $filename;
                }
                $products->cate_id = $request->input('cate_id');
                $products->name = $request->input('name');
                $products->slug = $request->input('slug');
                $products->small_description = $request->input('small_description');
                $products->description = $request->input('description');
                $products->original_price = $request->input('original_price');
                $products->selling_price = $request->input('selling_price');
                $products->qty = $request->input('qty');
                $products->tax = $request->input('tax');
                $products->status = $request->input('status') == true ? '1' : '0';
                $products->trending = $request->input('trending') == true ? '1' : '0';
                $products->meta_title = $request->input('meta_title');
                $products->meta_keywords = $request->input('meta_keywords');
                $products->meta_description = $request->input('meta_description');
                $products->save();
                return redirect('products')->with('status',"Product Added Successfully");
            }
        } catch (Exception $e) {
            return response()->view('layouts.404', ['error' => $e->getMessage()], 500);
        }
    }

    public function edit($id){
        $products = Product::find($id);
        return view('admin.product.edit', compact('products'));
    }

    public function update(Request $request, $id){
        try {
            $products = Product::find($id);
            if($request->hasFile('image')){

                $path = 'assets/uploads/products/'.$products->item;
                if (File::exists($path))
                {
                    File::delete($path);
                }
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = time().'.'.$ext;
                $file->move('assets/uploads/products/',$filename);
                $products->image = $filename;
            }
            $products->name = $request->input('name');
            $products->slug = $request->input('slug');
            $products->small_description = $request->input('small_description');
            $products->description = $request->input('description');
            $products->original_price = $request->input('original_price');
            $products->selling_price = $request->input('selling_price');
            $products->qty = $request->input('qty');
            $products->tax = $request->input('tax');
            $products->status = $request->input('status') == true ? '1' : '0';
            $products->trending = $request->input('trending') == true ? '1' : '0';
            $products->meta_title = $request->input('meta_title');
            $products->meta_keywords = $request->input('meta_keywords');
            $products->meta_description = $request->input('meta_description');
            $products->update();
            return redirect('products')->with('status',"Products Updated Successfully");
            
        } catch (\Exception $e) {
            return response()->view('layouts.404', ['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id){
        try {
            $products = Product::find($id);
            $path = 'assets/uploads/products/'.$products->image;
            if (File::exists($path))
            {
                File::delete($path);
            }
            $products->delete();
            return redirect('products')->with('status',"Product delete Successfully");

        } catch (\Exception $e) {
            return response()->view('layouts.404', ['error' => $e->getMessage()], 500);
        }
    }
}
?>
