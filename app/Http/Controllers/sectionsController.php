<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sections;
use Auth;


class sectionsController extends Controller
{
    
    public function  __construct()
    {
    $this->middleware('permission:الاقسام', ['only' => ['index']]);
    $this->middleware('permission:اضافة قسم', ['only' => ['create','store']]);
    $this->middleware('permission:تعديل قسم', ['only' => ['edit','update','show']]);
    $this->middleware('permission:حذف قسم', ['only' => ['destroy']]);
    }
    


    public function index()
    {
        $sections = sections::get();
        return view('sections.sections',compact('sections'));
    }

   
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        $validation = $request->validate([
     'section_name' => 'required'
        ]);

      $data = sections::insert([
          'section_name' => $request->section_name,
          'description' => $request->description,
          'created_by' => Auth::user()->name
        ]);

        if ($data)
        {
            $msg = array(
                'message' => 'تم اضافة القسم',
                'alert-type' => 'success',
                );
            return redirect()->back()->with($msg);

        }else
        {
            $msg = array(
                'message' => 'حدث خطأ !!',
                'alert-type' => 'error',
                );
            return redirect()->back()->with($msg);

        }
        
    }

    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        //
    }

   
    public function update(Request $request)
    {
   
       $id = $request->id;

       $this->validate($request, [

        'section_name' => 'required|max:255|unique:sections,section_name,'.$id
    ],[

        'section_name.required' =>'يرجي ادخال اسم القسم',
        'section_name.unique' =>'اسم القسم مسجل مسبقا'

    ]);
             $data = sections::find($id)->update([
                 'section_name' => $request->section_name,
                 'description' => $request->description,
                 'created_by' => Auth::user()->name
               ]);
       
               if ($data)
               {
                   $msg = array(
                       'message' => 'تم تعديل القسم',
                       'alert-type' => 'success',
                       );
                   return redirect()->back()->with($msg);
       
               }else
               {
                   $msg = array(
                       'message' => 'حدث خطأ !!',
                       'alert-type' => 'error',
                       );
                   return redirect()->back()->with($msg);
       
               }
        
    }

   
    public function destroy(Request $request)
    {
        $id = $request->id;

        sections::find($id)->delete();
        $msg = array(
            'message' => 'تم حذفالقسم',
            'alert-type' => 'info',
            );
        return redirect()->back()->with($msg);
    }
}
