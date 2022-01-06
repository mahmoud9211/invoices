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
use App\Models\attachment;
use App\Models\products;
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
         'invoice_number' => 'required|unique:invoices',
         'invoice_Date' => 'required',
         'Due_date' => 'required',
         'product' => 'required',
         'section_id' => 'required',
         'Amount_collection' => 'required',
         'Amount_Commission' => 'required',
         'Rate_VAT' => 'required',
         'pic' => 'mimes:pdf,jpg,png,jpeg'

        ],
        
        [
            'invoice_number.required'=> 'من فضلك ادخل رقم الفاتوره',
            'invoice_Date.required' => 'من فضلك ادخل تاريخ الفاتوره',
            'Due_date.required' => 'من فضلك ادخل تاريخ الاستحقاق',
            'product.required' => 'من فضلك اختر المنتج',
            'section_id.required' => 'من فضلك اختر القسم',
            'Amount_collection.required' => 'من فضلك ادخل مبلغ التحصيل',
            'Amount_Commission.required' => 'من فضلك ادخل قيمة العمولة',
            'Rate_VAT.required' => 'من فضلك اختر نسبة الضريبة',
            'pic.mimes' => 'الملف المرفق يجب ان يكون من احد الامتدادات التاليه pdf,jpg,png,jpeg'
         

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


   
    invoicedetails::insert([
        'id_Invoice' => $invoice_id,
        'invoice_number' => $request->invoice_number,
        'product_id' => $request->product,
        'Section' => $section_name,
        'Status' => 'غير مدفوعة',
        'Value_Status' => 0,
        'note' => $request->note,
        'user' => auth()->user()->name,
        'created_at' => Carbon::now()
    ]);

    if($request->hasFile('pic'))
{
    $image = $request->file('pic');
    $file_name = $image->getClientOriginalName();
    $request->pic->move(public_path('Attachments/' . $request->invoice_number), $file_name);

    attachment::create([
       'invoice_id' => $invoice_id,
       'file' => $file_name
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
    public function edit ($id)

    {
      $data = invoices::where('id',$id)->first();
      $sections = sections::get();
      $products = products::where('section_id',$data->section_id)->get();
      return view ('invoices.invoiceedit',compact('data','sections','products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
    public function update ($id,Request $request)
{
  $this->validate($request, [

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

  invoices::find($id)->update([
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


invoicedetails::where('id_Invoice',$id)->update([
'id_Invoice' => $id,
'invoice_number' => $request->invoice_number,
'product_id' => $request->product,
'Section' => $section_name,
'Status' => 'غير مدفوعة',
'Value_Status' => 2,
'note' => $request->note,
'user' => Auth::user()->name,
'created_at' => Carbon::now()
]);


$msg = array('message' => 'تم تعديل الفاتورة بنجاح',
'alert-type' => 'success');

return redirect()->to('/invoices')->with($msg);




        //
    }

    public function destroy (Request $request)

    {
    
     $file = attachment::where('invoice_id',$request->id)->get(); 
       
    $invoice_num = invoices::find($request->id)->invoice_number; 
    
    if ($file != false)
    {
      Storage::disk('public_uploads')->deleteDirectory($invoice_num);
      invoices::find($request->id)->forceDelete();
    
    }
    else{
      invoices::find($request->id)->forceDelete();
    
    }
    
    $msg = array('message' => 'تم حذف الفاتورة بنجاح',
    'alert-type' => 'success');
    
    return redirect()->back()->with($msg);
    
    
    
    
    
    }

    public function export() 
    {
        return Excel::download(new invoicesExport, 'invoices.xlsx');
    }

    public function paid_invoices ()
    {
        $data = invoices::where('Value_Status',1)->get();

        return view('invoices.paid_invoices',compact('data'));
    }

    public function unpaid_invoices ()
    {
        $data = invoices::where('Value_Status',0)->get();

        return view('invoices.unpaid_invoices',compact('data'));
    }

    public function partialypaid_invoices ()
    {

        $data = invoices::where('Value_Status',2)->get();

        return view('invoices.partialypaid_invoices',compact('data'));


    }

    
}
