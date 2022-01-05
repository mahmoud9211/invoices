<?php

namespace App\Http\Controllers;

use App\Models\invoices;

use Illuminate\Http\Request;

class homeController extends Controller
{
    public function index()
    {

        $countall = invoices::count();

        $count1 = invoices::where('Value_Status',1)->count();
        if($count1 == 0)
        {
            $per1 = 0 ; 
        }else
        {
            $per1 = $count1 / $countall * 100;
        }
        $count2 = invoices::where('Value_Status',0)->count();
        if ($count2 == 0)
        {
            $per2 = 0;
        }else{
            $per2 = $count2/$countall * 100;
        }
 
        $count3 = invoices::where('Value_Status',2)->count();

        if($count3 == 0)
        {
            $count3 = 0;

        }else
        {
            $per3 = $count3 / $countall * 100;
        }
        

        $chartjs = app()->chartjs
        ->name('barChartTest')
        ->type('bar')
        ->size(['width' => 300, 'height' => 200])
        ->labels([])
        ->datasets([
            [
                "label" => "كل الفواتير",
                'backgroundColor' => ['rgba(66, 135, 245)'],
                'data' => [100]
            ],
            [
                "label" => "الفواتير المدفوعه",
                'backgroundColor' => ['rgba(66, 245, 191)'],
                'data' => [$per1]
            ],
            [
                "label" => "الفواتير الغير مدفوعه",
                'backgroundColor' => ['rgba(245, 72, 66)'],
                'data' => [$per2]
            ],
            [
                "label" => "الفواتير المدفوعه جزئيا",
                'backgroundColor' => ['rgba(245, 167, 66)'],
                'data' => [$per3]
            ],
            [
                'data' => [0] 
            ]
            
        ])
        ->options([]);



        $chartjs2 = app()->chartjs
        ->name('pieChartTest')
        ->type('pie')
        ->size(['width' => 400, 'height' => 200])
        ->labels(['الفواتير المدفوعه', 'الفواتير الغير مدفوعه','الفواتير المدفوعه جزئيا'])
        ->datasets([
            [
                'backgroundColor' => ['rgba(66, 245, 191)','rgba(245, 72, 66)', 'rgba(245, 167, 66)' ],
                'hoverBackgroundColor' => ['rgba(66, 245, 191)','rgba(245, 72, 66)', 'rgba(245, 167, 66)' ],
                'data' => [$per1,$per2,$per3]
            ],
           

        ])
        ->options([]);


         return view('dashboard', compact('chartjs','chartjs2'));




    }
}
