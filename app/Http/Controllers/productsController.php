<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\products;
use App\Models\sections;



class productsController extends Controller
{
    
    public function  __construct()
    {
    $this->middleware('permission:المنتجات', ['only' => ['index']]);
    $this->middleware('permission:اضافة منتج', ['only' => ['create','store']]);
    $this->middleware('permission:تعديل منتج', ['only' => ['edit','update','show']]);
    $this->middleware('permission:حذف منتج', ['only' => ['destroy']]);
    }


    public function index()
    {
        $sections = sections::get();
        $products = products::with('sections')->get();
        return view('products.products',compact('sections','products'));
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
      $validation = $request->validate([
          'product_name' => 'required',
          'section_id' => 'required'
      ],
      [
          'product_name.required' => 'من فضلك ادخل اسم المنتج',
          'section_id.required' => 'من فضلك اختر القسم'
      ]
      );


      $data = products::insert([
        'product_name' => $request->product_name,
        'section_id' => $request->section_id,
        'description' => $request->description

      ]);

      if($data)
      {
          $msg = array('message' => 'تم اضافة المنتج بنجاح',
          'alert-type' => 'success'
      );

      return redirect()->back()->with($msg);
      }
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->pro_id;

        
       $this->validate($request, [

        'product_name' => 'required|max:255'.$id
    ],[

        'product_name.required' =>'يرجي ادخال اسم القسم'
    ]);
      

        $sec_id = sections::where('section_name', $request->section_name)->first()->id;

        products::find($id)->update([
         'product_name' => $request->product_name,
         'description' => $request->description,
         'section_id' => $sec_id


        ]);

        $msg = array('message' => 'تم التعديل بنجاح',
        'alert-type' => 'success');
        return redirect()->back()->with($msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      $id = $request->id;
      products::find($id)->delete();
      $msg = array('message' => 'تم الحذف بنجاح',
        'alert-type' => 'info');
      return redirect()->back()->with($msg);
    }
}
