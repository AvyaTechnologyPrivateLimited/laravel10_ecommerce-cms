<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\{
    Product, User, Category, Color, Size, Tag
};

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::with(['category', 'colors', 'sizes', 'tags'])->get();
        return Inertia::render('Admin/Product/Index', [
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Product/Create', [
            'status_options' => config('constants.status'),
            'categories' => Category::get(),
            'colors' => Color::MultiSelect()->get(),
            'sizes' => Size::MultiSelect()->get(),
            'tags' => Tag::MultiSelect()->get()
        ]);
    }

    private function rules()
    {
        return $rules = [
            'title' => ['required'],
            'price' => ['required', 'numeric'],
            'category_id' => ['required','exists:categories,id'],
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = $this->rules();

        if($request->hasFile('file'))
        {
            $rules['file'] = ['image'];
        }

        $msg = [
            'category_id' => 'Please select category'
        ];

        Validator::make($request->all(),$rules, $msg)->validate();

        $ar = ['New Arival', 'Hot Product', 'Limited Edition', 'Hot Deal'];

        $data = [
            'title' => $request->title,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'features' => $request->features,
            'product_details' => $request->product_details,
            'price' => $request->price,
            'status' => $request->status,
            'badge' => \Arr::random(array: $ar)
        ];

        if($request->hasFile('file'))
        {
            $data['image'] = $this->fileUpload($request);
        }
   
        $product = Product::create($data);

        $product->colors()->sync(array_column($request->colors, 'value'));
        $product->sizes()->sync(array_column($request->sizes, 'value'));
        $product->tags()->sync(array_column($request->tags, 'value'));
    
        return redirect()->route('admin.product.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return Inertia::render('Admin/Product/Edit', [
            'status_options' => config('constants.status'),
            'categories' => Category::get(),
            'colors' => Color::MultiSelect()->get(),
            'sizes' => Size::MultiSelect()->get(),
            'tags' => Tag::MultiSelect()->get(),
            'product' => [
                'id' => $product->id,
                'category_id' => $product->category_id,
                'description' => $product->description,
                'features' => $product->features,
                'product_details' => $product->product_details,
                'title' => $product->title,
                'slug' => $product->slug,
                'price' => $product->price,
                'image' => $product->image,
                'status' => $product->status,
                'colors' => $product->colorMultiSelect,
                'sizes' => $product->sizeMultiSelect,
                'tags' => $product->tagMultiSelect
            ]
        ]);
    }

    private function fileUpload($request) {
        $fileName = Str::slug($request->title).'-'.time().'.'.$request->file->extension();  
        $request->file->move(public_path('uploads'), $fileName);
        return $fileName;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $rules = $this->rules();

        if($request->hasFile('file'))
        {
            $rules['file'] = ['image'];
        }

        Validator::make($request->all(),$rules)->validate();

        $ar = ['New Arival', 'Hot Product', 'Limited Edition', 'Hot Deal'];

        $data = [
            'category_id' => $request->category_id,
            'description' => $request->description,
            'features' => $request->features,
            'product_details' => $request->product_details,
            'title' => $request->title,
            'price' => $request->price,
            'status' => $request->status
        ];

        if(empty($product->badge))
            $data['badge'] = \Arr::random(array: $ar);

        if($request->hasFile('file'))
        {
            $data['image'] = $this->fileUpload($request);
        }

        $product->update($data);

        $product->colors()->sync(array_column($request->colors, 'value'));
        $product->sizes()->sync(array_column($request->sizes, 'value'));
        $product->tags()->sync(array_column($request->tags, 'value'));
    
        return redirect()->route('admin.product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return Redirect::back()->with('success', 'Product deleted.');
    }
}
