<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\sections;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = products::all();
        // join('sections','sections.id','=','products.section_id')->select('products.*','sections.section_name')->get();
        //
        $sections = sections::all();
        return view('products.products' , compact('sections','products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request,[

            'product_name' => 'required',
            'description' => '',
            'section_id' => 'required'

        ]);
        products::create($data);
        session()->flash('Add','تم اضافة المنج بنجاح');
        return redirect('/products');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(products $products)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = sections::where('section_name','=',$request->section_name)->first()->id;
        $products = products::findOrFail($request->pro_id);
        $products->update([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'section_id' => $id,
            ]);

            session()->flash('edit', 'تم تعديل المنتج بنجاح');
            return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $Products = Products::findOrFail($request->pro_id)->delete();
       // $product = products::find($id)->delete();
       session()->flash('delete','تم حذف المنتج بنجاح');
       return back();
    }
}
