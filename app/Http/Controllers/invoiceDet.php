<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sections;
use App\Models\products;
use App\Models\invoices;
use App\Models\invoicedetails;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use File;
use Auth;





class invoiceDet extends Controller
{
    public function add()
    {
       $sections = sections::get();
        return view('invoices.addinvoices',compact('sections'));
    }

    public function getprobyajax ($section_id)
    {
      $data = products::where('section_id',$section_id)->get();

      return json_encode($data);

    }

    public function edit($id)
    {
      $invoices = invoices::find($id);

      $det = invoicedetails::where('id_Invoice',$id)->get();

        return view ('invoices.invoicedetails',compact('invoices','det'));
    }

    public function viewfile ($file,$invoice_number)
    {
      $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file);
        return response()->file($files);


    }

    public function downloadfile ($file,$invoice_number)
    {
      $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file);
        return response()->download($files);


    }


    public function upload (Request $request)

    {

      $image = $request->file('filename');
      $file_name = $image->getClientOriginalName();
      $imageName = $request->filename->getClientOriginalName();
      $request->filename->move(public_path('Attachments/' . $request->invoice_number), $imageName);
  
      invoicedetails::insert([
       'id_Invoice' => $request->invoice_id,
       'invoice_number' => $request->invoice_number,
       'product' => $request->product,
       'Section' => $request->section,
       'Status' => 'غير مدفوعة',
       'Value_Status' => 2,
       'user' => Auth::user()->name,
       'file' => $file_name ]);

       $msg = array('message' => 'تم اضافة المرفق بنجاح',
       'alert-type' => 'success');
   
       return redirect()->back()->with($msg);


    }

    public function editinvoice ($id)

    {
      $data = invoices::where('id',$id)->first();
      $sections = sections::get();
      $products = products::where('section_id',$data->section_id)->get();
      return view ('invoices.invoiceedit',compact('data','sections','products'));
    }

    public function updateinvoice ($id,Request $request)
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
'product' => $request->product,
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




}

public function deleteinvoice (Request $request)

{

 $file = invoicedetails::where('id_Invoice',$request->id)->first(); 

$file_name = $file->file;

$invoice_num = invoices::find($request->id)->invoice_number; 

if ($file_name)
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


public function statusupdate ($id)
{
  $data = invoices::where('id',$id)->first();
  $sections = sections::get();
  $products = products::where('section_id',$data->section_id)->get();
  return view ('invoices.statusupdate',compact('data','sections','products'));
 

}

public function changestatus (Request $request, $id)
{
  $validation = $request->validate([
'Payment_Date' => 'required',
'Status' => 'required'

  ]);

  if($request->Status == 'مدفوعة')
  {
    invoices::find($id)->update([
      'Status' => $request->Status,
      'Value_Status' => 1,
      'Payment_Date' => $request->Payment_Date
    ]);


    //$section = sections::where('id',$request->section_id)->first();
   // $section_name = $section->section_name;

    invoicedetails::insert([
      'id_Invoice' => $id,
      'invoice_number' => $request->invoice_number,
      'Section' => $request->section_id,
      'product' => $request->product,
      'Status' => $request->Status,
      'Value_Status' => 1,
      'note' => $request->note,
      'user' => Auth::user()->name,
      'Payment_Date' => $request->Payment_Date,
      'created_at' => Carbon::now()

    ]);

    $msg = array('message' => 'تم تعديل حالة الدفع بنجاح',
'alert-type' => 'success');

return redirect()->to('/invoices')->with($msg);


  }
  else
  {
    invoices::find($id)->update([
      'Status' => $request->Status,
      'Value_Status' => 2,
      'Payment_Date' => $request->Payment_Date
    ]);

   // $section = sections::where('id',$request->section_id)->first();
  //  $section_name = $section->section_name;

    invoicedetails::insert([
       'id_Invoice' => $id,
      'invoice_number' => $request->invoice_number,
      'product' => $request->product,
      'Section' => $request->section_id,
      'Status' => $request->Status,
      'Value_Status' => 2,
      'note' => $request->note,
      'user' => Auth::user()->name,
      'Payment_Date' => $request->Payment_Date,
      'created_at' => Carbon::now()


    ]);

    $msg = array('message' => 'تم تعديل حالة الدفع بنجاح',
'alert-type' => 'success');

return redirect()->to('/invoices')->with($msg);




  }

}



public function invoicearchive (Request $request)
{

 $id = $request->id;

 invoices::find($id)->delete();

 $msg = array('message' => 'تم أرشفة الفاتورة بنجاح',
 'alert-type' => 'info');

 return redirect()->back()->with($msg);

}

public function archived ()

{

  $archived_inv = invoices::onlyTrashed()->get();
  return view ('invoices.archivedinvoices',compact('archived_inv'));
}

public function unarchive (Request $request)
{

  $id = $request->id;

  invoices::withTrashed()->restore();

  $msg = array('message' => 'تم الغاء أرشفة الفاتورة بنجاح',
 'alert-type' => 'info');

 return redirect()->to('/invoices')->with($msg);


}

public function delinvoices (Request $request)
{
 $id = $request->id;

 $data = invoices::withTrashed()->find($id);

 $data->forceDelete();

 $msg = array('message' => 'تم حذف الفاتورة بنجاح',
 'alert-type' => 'info');

 return redirect()->back()->with($msg);


}

public function printinvoice ($id)
{
  $data = invoices::find($id);
  return view ('invoices.print',compact('data'));

}




}
