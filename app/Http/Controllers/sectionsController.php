<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sections;
use Auth;


class sectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = sections::get();
        return view('sections.sections',compact('sections'));
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
