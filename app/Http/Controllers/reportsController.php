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

$data = invoices::where('Status',$request->type)->get();
$type = $request->type;
return view ('reports.invoices',compact('type'))->withDetails($data);

}else{

$start_at = date($request->start_at);
$end_at = date($request->end_at);
$data = invoices::whereBetween('invoice_Date',[$start_at,$end_at])->where('Status',$request->type)->get();
$type = $request->type;
return view ('reports.invoices',compact('start_at','end_at','type'))->withDetails($data);


}
    




}else{


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

if ($request->section_id &&  $request->product &&  $request->start_at == '' && $request->end_at == '' )
{

$data = invoices::where('section_id',$request->section_id)->where('product',$request->product)->get();
$sec = sections::get();

return view ('reports.customers',compact('sec'))->withDetails($data);
}else
{
    $sec = sections::get();
  
$data = invoices::whereBetween('invoice_Date',[$request->start_at,$request->end_at])->where('section_id',$request->section_id)->where('product',$request->product)->get();
return view ('reports.customers',compact('sec'))->withDetails($data);
}


}
}
