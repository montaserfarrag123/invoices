<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Models\invoices;
use App\Models\user;
use App\Models\invoices_details;
use App\Models\invoices_attachments;
use App\Models\sections;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Notifications\Addinvoice;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = invoices::get();
        return view('invoices.invoices',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = sections::get();
        return view('invoices.add_invoices', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$this->validate($request,[
        
            'invoice_number'=>'required',
            'invoice_Date'=>'required',
            'Due_date'=>'required',
            'product'=>'required',
            'Amount_collection'=>'required',
            'Amount_Commission'=>'required',
            'Discount'=>'required',
            'Value_VAT'=>'required',
            'Rate_VAT'=>'required',
            'Total'=>'required',
        ]);
            $op= invoices::create([ 'invoice_number'=>$request->invoice_number,
            'invoice_Date'=>$request->invoice_Date,
            'Due_date'=>$request->Due_date,
            'product'=>$request->product,
            'section_id'=>$request->Section,
            'Amount_collection'=>$request->Amount_collection,
            'Amount_Commission'=>$request->Amount_Commission,
            'Discount'=>$request->Discount,
            'Value_VAT'=>$request->Value_VAT,
            'Rate_VAT'=>$request->Rate_VAT,
            'Total'=>$request->Total,
            'Status'=>'غير مدفوعه',
            'Value_Status'=>2,
            'note'=>$request->note,

       
        ]);

        $invoice_id = invoices::latest()->first()->id;
        invoices_details::create([

                'Id_invoices'=> $invoice_id,
                'invoices_number' => $request->invoice_number,
                'product' => $request->product,
                'section' => $request->Section,
                'status' => 'غير مدفوعة',
                'value_status' => 2,
                'notes' => $request->note,
                'user' => (Auth::user()->name),
        ]);

        if ($request->hasFile('pic')) {

            $invoice_id = Invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = time() . rand() . '.' . $request->pic->extension();
            $invoice_number = $request->invoice_number;

            $attachments = new invoices_attachments();
            $attachments->fil_name= $file_name;
            $attachments->invoices_number = $invoice_number;
            $attachments->created_by = Auth::user()->name;
            $attachments->invoices_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $file_name);
        }
         //email
        // $user = user::first();
        // Notification::send($user,new Addinvoice($invoice_id));

        $user = User::get();
        $invoices = invoices::latest()->first();
        Notification::send($user, new \App\Notifications\Add_invoice_new($invoices));


        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoices = invoices::find($id);
        return view('invoices.status_update',compact('invoices'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoices= invoices::find($id);
        $sections= sections::all();
        return view('invoices.edit_invoices', compact('sections','invoices'));
    }


    public function update(Request $request)
    {
        $invoices = invoices::findOrFail($request->invoice_id);
        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'note' => $request->note,
        ]);

        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return back();
    }


    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
         $invoices= invoices::where('id',$id)->first();
        //$invoices = invoices::findOrFail($request->invoice_id)->forcedelete();
        $Details = invoices_attachments::where('invoices_id',$id)->first();
        $id_page = $request->id_page;

        if(!$id_page == 2){

        if (!empty($Details->invoices_number)) {

            Storage::disk('public_uploads')->deleteDirectory($Details->invoices_number);
        }
        $invoices->forcedelete();
       session()->flash('delete_invoice');
       return redirect('invoices');
     }else{

        $invoices->delete();
        session()->flash('archive_invoice');
        return redirect('/invoices');
     }
    }
    public function getproduct($id){

        $products = products::where('section_id',$id)->pluck("product_name","id");
        return json_encode($products);

     //$products = DB::table("products")->where("section_id", $id)->pluck("product_name","id");
    //   return json_encode($products);
    }
    public function Status_Update($id,Request $request){
        $invoices= invoices::where('id',$id)->first();

        if($request->Status == "مدفوعة"){
            $invoices->update([
                'Value_Status' => 1,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoices_details::create([
                'Id_invoices' => $request->invoice_id,
                'invoices_number' => $request->invoice_number,
                'product' => $request->product,
                'section' => $request->Section,
                'status' => $request->Status,
                'value_status' => 1,
                'notes' => $request->note,
                'Payment_date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);

        }else{
            $invoices->update([
                'Value_Status' => 3,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoices_details::create([
                'Id_invoices' => $request->invoice_id,
                'invoices_number' => $request->invoice_number,
                'product' => $request->product,
                'section' => $request->Section,
                'status' => $request->Status,
                'value_status' => 3,
                'notes' => $request->note,
                'Payment_date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }
        session()->flash('Status_Update');
        return redirect('/invoices');
    }
    public function Invoices_paid(){

        $invoices = invoices::where('Value_Status' , 1)->get();
        return view('invoices.invoices_paid' , compact('invoices'));
    }

    public function Invoices_partpaid(){

        $invoices = invoices::where('Value_Status' , 3)->get();
        return view('invoices.invoices_partpaid' , compact('invoices'));
    }
    public function Invoices_unpaid(){

        $invoices = invoices::where('Value_Status' , 2)->get();
        return view('invoices.invoices_unpaid' , compact('invoices'));
    }
    public function Print_invoice($id){
        $invoices = invoices::find($id);
         return view('invoices.print_invoice',compact('invoices'));
    }

    public function MarkAsRead_all (Request $request)
    {

        $userUnreadNotification= auth()->user()->unreadNotifications;

        if($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
            return back();
        }


    }


}
