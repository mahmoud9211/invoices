<?php

namespace App\Http\Controllers;

use App\Models\attachment;
use Illuminate\Http\Request;
use App\Models\sections;
use App\Models\products;
use App\Models\invoices;
use App\Models\invoicedetails;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use File;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class invoiceDet extends Controller
{

  public function  __construct()
  {
  $this->middleware('permission:تفاصيل الفاتوره', ['only' => ['edit']]);
  $this->middleware('permission:عرض المرفق', ['only' => ['viewfile']]);
  $this->middleware('permission:تحميل المرفق', ['only' => ['downloadfile']]);
  $this->middleware('permission:حذف المرفق', ['only' => ['att_delete']]);
  $this->middleware('permission:اضافة مرفق', ['only' => ['upload']]);

  $this->middleware('permission:تغير حالة الدفع', ['only' => ['statusupdate','changestatus']]);
  $this->middleware('permission:ارشفة الفاتورة', ['only' => ['invoicearchive','archived']]);
  $this->middleware('permission:الغاء ارشفة الفاتورة', ['only' => ['delinvoices']]);
  $this->middleware('permission:طباعةالفاتورة', ['only' => ['printinvoice']]);


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

      $attachments = attachment::where('invoice_id',$id)->get();

        return view ('invoices.invoicedetails',compact('invoices','det','attachments'));
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
      $request->filename->move(public_path('Attachments/' . $request->invoice_number), $file_name);
  
      attachment::create([
       'invoice_id' => $request->invoice_id,
       'file' => $file_name 
      ]);

       $msg = array('message' => 'تم اضافة المرفق بنجاح',
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
'Value_Status' => 'required'

  ]);

  if($request->Value_Status == 1)
  {
    invoices::find($id)->update([
      'Status' => 'مدفوعة',
      'Value_Status' => $request->Value_Status,
      'Payment_Date' => $request->Payment_Date
    ]);


    //$section = sections::where('id',$request->section_id)->first();
   // $section_name = $section->section_name;

    invoicedetails::insert([
      'id_Invoice' => $id,
      'invoice_number' => $request->invoice_number,
      'Section' => $request->section_id,
      'product_id' => $request->product,
      'Status' => 'مدفوعة',
      'Value_Status' => $request->Value_Status ,
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
      'Status' => 'مدفوعه جزئيا',
      'Value_Status' => $request->Value_Status,
      'Payment_Date' => $request->Payment_Date
    ]);

   // $section = sections::where('id',$request->section_id)->first();
  //  $section_name = $section->section_name;

    invoicedetails::insert([
       'id_Invoice' => $id,
      'invoice_number' => $request->invoice_number,
      'product_id' => $request->product,
      'Section' => $request->section_id,
      'Status' => 'مدفوعه جزئيا',
      'Value_Status' => $request->Value_Status,
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

public function att_delete (attachment $attachment)
{
  $invoice_number = $attachment->invoice->invoice_number;
  Storage::disk('public_uploads')->delete('/'.$invoice_number.'/'.$attachment->file);
  $attachment->delete();

  $msg = ([
      'message' => 'تم حذف المرفق بنجاح',
      'alert-type' => 'success'
  ]);

  return redirect()->back()->with($msg);
}




}
