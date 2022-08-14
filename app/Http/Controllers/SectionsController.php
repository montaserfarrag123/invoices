<?php

namespace App\Http\Controllers;

use App\Models\sections;
use Illuminate\Http\Request;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = sections::orderby('id','desc')->get();
        return view('sections.section' , compact('sections'));
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
       /// $input=$request->all();
        //طريقة غير الفاليداشن
        // $b_exist = sections::where('section_name', '=' , $input['section_name'])->exists();
        // if($b_exist){
        //     session()->flash('Error','اسم القسم مستخدم مسبقا');
        //     return redirect('/sections');
        // }else{
            $data = $this->validate($request,
            [
               'section_name' => 'required|unique:sections|min:2|max:50',
               'description'  =>  'max:10000'

            ],
            [
                    'section_name.required' => 'اسم القسم مطلوب',
                    'section_name.unique' => 'اسم القسم موجود بالفعل',
                    'section_name.min' => 'من المفترض الا يقل اسم القسم عن حرفين',
                    'section_name.max' => 'من المفترض الا يزيد اسم القسم عن 50 حرف',
            ]
            );
            $data['created_by'] = auth()->user()->name;
            sections::create($data);
            session()->flash('Add','تم اضافة القسم بنجاح');
            return redirect('/sections');

        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function edit(sections $sections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // $id = $request->id;
        // $data = $this->validate($request,
        //     [
        //        'section_name' => 'required|unique:sections,section_name|min:2|max:50,'.$id,
        //        'description'  =>  'max:10000'

        //     ],
        //     [
        //             'section_name.required' => 'اسم القسم مطلوب',
        //             'section_name.unique' => 'اسم القسم موجود بالفعل',
        //             'section_name.min' => 'من المفترض الا يقل اسم القسم عن حرفين',
        //             'section_name.max' => 'من المفترض الا يزيد اسم القسم عن 50 حرف',
        //     ]
        //     );

        //     sections::where('id' , $id)->update($data);
        // return $request;



        // $data = $this->validate($request,[

        //     'section_name' => 'required|min:2|unique:sections,section_name|max:50',
        //     'description' => 'required'
        //  ]);
        //  $id = $request->id;
        //  sections::where('id' , $id)->update($data);
        //  return redirect('/sections');


        $id = $request->id;

        $this->validate($request, [

            'section_name' => 'required|max:255|unique:sections,section_name,'.$id,
            'description' => 'required',
        ],[

            'section_name.required' =>'يرجي ادخال اسم القسم',
            'section_name.unique' =>'اسم القسم مسجل مسبقا',
            'description.required' =>'يرجي ادخال البيان',

        ]);

        $sections = sections::find($id);
        $sections->update([
            'section_name' => $request->section_name,
            'description' => $request->description,
        ]);

        session()->flash('edit','تم تعديل القسم بنجاج');
        return redirect('/sections');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        sections::find($id)->delete();
        session()->flash('delete','تم حذف القسم بنجاج');
        return redirect('/sections');
    }
}
