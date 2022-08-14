<?php

namespace App\Http\Controllers;
use App\Models\invoices;
use Illuminate\Http\Request;
use App\Models\sections;

class costomer_reportsController extends Controller
{
    public function index(){
        $sections = sections::all();
        return view('reports.customers_report',compact('sections'));
    }

    public function Search_customers(Request $request){

       //في حالة البحث بدون تاريخ
        if($request->Section && $request->product && $request->start_at =='' && $request->end_at == ''){
           $invoices = invoices::select('*')->where('section_id',$request->Section)->where('product',$request->product)->get();
            $sections = sections::all();
            $start_at = $request->start_at;
            return view('reports.customers_report',compact('sections','start_at'))->withDetails($invoices);
        }else{
                 //في حالة البحث بتاريخ
            $start_at = date($request->start_at);
            $end_at = date($request->end_at);
            $invoices = invoices::whereBetween('invoice_Date',[$start_at,$end_at])->where('section_id',$request->Section)->where('product',$request->product)->get();
            $sections = sections::all();
            return view('reports.customers_report',compact('sections','start_at','end_at'))->withDetails($invoices);
        }



    }

}
