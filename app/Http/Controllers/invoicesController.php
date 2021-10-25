<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoices;
use App\Models\sections;
use App\Models\invoicedetails;
use App\Models\invoiceattachments;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use App\Notifications\invoiceadd;
use App\Notifications\invoice_db;

use App\Models\User;

use App\Exports\invoicesExport;
use Maatwebsite\Excel\Facades\Excel;



use Auth;


class invoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


  


    public function index()
    {
      $data = invoices::with('section','products')->get();
       return view('invoices.invoices',compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
         'invoice_number' => 'required',
         'invoice_Date' => 'required',
         'Due_date' => 'required',
         'product' => 'required',
         'section_id' => 'required',
         'Amount_collection' => 'required',
         'Amount_Commission' => 'required',
         'Rate_VAT' => 'required'

        ],
        
        [
            'invoice_number.required'=> 'من فضلك ادخل رقم الفاتوره',
            'invoice_Date.required' => 'من فضلك ادخل تاريخ الفاتوره',
            'Due_date.required' => 'من فضلك ادخل تاريخ الاستحقاق',
            'product.required' => 'من فضلك اختر المنتج',
            'section_id.required' => 'من فضلك اختر القسم',
            'Amount_collection.required' => 'من فضلك ادخل مبلغ التحصيل',
            'Amount_Commission.required' => 'من فضلك ادخل قيمة العمولة',
            'Rate_VAT.required' => 'من فضلك اختر نسبة الضريبة'
         

        ]);

      $invoice_id =  invoices::insertGetId([
        'invoice_number' => $request->invoice_number,
        'invoice_Date' => $request->invoice_Date,
        'Due_date' => $request->Due_date,
        'product' => $request->product,
        'section_id' => $request->section_id,
        'Amount_collection' => $request->Amount_collection,
        'Amount_Commission' => $request->Amount_Commission,
        'Discount' => $request->Discount,
        'Value_VAT' => $request->Value_VAT,
        'Rate_VAT' => $request->Rate_VAT,
        'Total' => $request->Total,
        'Status' => 'غير مدفوعه',
        'Value_Status' => 0 ,
        'note' => $request->note
        ]);

      $section = sections::where('id',$request->section_id)->first();
      $section_name = $section->section_name;
if($request->hasFile('pic'))
{
    $image = $request->file('pic');
    $file_name = $image->getClientOriginalName();
    $imageName = $request->pic->getClientOriginalName();
    $request->pic->move(public_path('Attachments/' . $request->invoice_number), $imageName);

    invoicedetails::insert([
     'id_Invoice' => $invoice_id,
     'invoice_number' => $request->invoice_number,
     'product' => $request->product,
     'Section' => $section_name,
     'Status' => 'غير مدفوعة',
     'Value_Status' => 0,
     'note' => $request->note,
     'user' => Auth::user()->name,
     'file' => $file_name,
     'created_at' => Carbon::now()
    ]);
}else
{
    invoicedetails::insert([
        'id_Invoice' => $invoice_id,
        'invoice_number' => $request->invoice_number,
        'product' => $request->product,
        'Section' => $section_name,
        'Status' => 'غير مدفوعة',
        'Value_Status' => 0,
        'note' => $request->note,
        'user' => Auth::user()->name,
        'created_at' => Carbon::now()
    ]);



}


     

//mail 

//$user = User::first();
//Notification::send($user, new invoiceadd($invoice_id));



//notification in database
$user = User::get();

Notification::send($user,new invoice_db($invoice_id));
     



       $msg = array('message' => 'تم اضافة الفاتورة بنجاح',
       'alert-type' => 'success');

       return redirect()->to('/invoices')->with($msg);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
 

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function export() 
    {
        return Excel::download(new invoicesExport, 'invoices.xlsx');
    }
}
