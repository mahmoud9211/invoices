<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\invoices;
use App\Models\sections;


class reportsController extends Controller
{

    public function  __construct()
    {
    $this->middleware('permission:تقرير الفواتير', ['only' => ['index','search']]);
    $this->middleware('permission:تقرير العملاء', ['only' => ['index2','search2']]);
    }

public function index ()
{
return view ('reports.invoices');


}


public function search (Request $request)

{

    

if ($request->rdio == 1)

{
if ($request->type && $request->start_at == '' && $request->end_at == '')
{
    $validation = $request->validate([
        'type' => 'required'
      ],[
      'type.required' => 'من فضلك ادخل نوع الفاتوره'
   
  
   ]);

$data = invoices::where('Status',$request->type)->get();
$type = $request->type;
return view ('reports.invoices',compact('type'))->withDetails($data);

}else{

    $validation = $request->validate([
        'start_at' => 'required',
        'end_at' => 'required',

      ],[
      'start_at.required' => 'من فضلك ادخل تاريخ البدايه ',
      'end_at.required' => 'من فضلك ادخل تاريخ النهايه ',


   
  
   ]);

$start_at = date($request->start_at);
$end_at = date($request->end_at);
$data = invoices::whereBetween('invoice_Date',[$start_at,$end_at])->where('Status',$request->type)->get();
$type = $request->type;
return view ('reports.invoices',compact('start_at','end_at','type'))->withDetails($data);


}
    




}else{


    $validation = $request->validate([
      'invoice_number' => 'required'
    ],[
    'invoice_number.required' => 'من فضلك ادخل رقم الفاتوره'
 

 ]);

$data = invoices::where('invoice_number',$request->invoice_number)->get();

return view ('reports.invoices')->withDetails($data);



}







}



public function index2 ()
{
$sec = sections::get();
return view ('reports.customers',compact('sec'));
}


public function search2 (Request $request)
{
    $validation = $request->validate([
       'section_id' => 'required',
       'product' => 'required'
    ],
[
    'section_id.required' => 'من فضلك اختر القسم',
    'product.required' => 'من فضلك اختر المنتج',
    
]);

if ($request->section_id &&  $request->product &&  $request->start_at == '' && $request->end_at == '' )
{
   
$data = invoices::where('section_id',$request->section_id)->where('product',$request->product)->get();
$sec = sections::get();

return view ('reports.customers',compact('sec'))->withDetails($data);
}else
{
    $validation = $request->validate([
        'start_at' => 'required',
        'end_at' => 'required',

      ],[
      'start_at.required' => 'من فضلك ادخل تاريخ البدايه ',
      'end_at.required' => 'من فضلك ادخل تاريخ النهايه ',


   
  
   ]);

    $sec = sections::get();
  
$data = invoices::whereBetween('invoice_Date',[$request->start_at,$request->end_at])->where('section_id',$request->section_id)->where('product',$request->product)->get();
return view ('reports.customers',compact('sec'))->withDetails($data);
}


}
}
