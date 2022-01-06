@extends('layouts.master')
@section('css')
<!--  Owl-carousel css-->
<link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet" />
<!-- Maps css -->
<link href="{{URL::asset('assets/plugins/jqvmap/jqvmap.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
<div class="left-content">
<div>
<h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">برنامج الفواتير</h2>
</div>
</div>
<div class="main-dashboard-header-right">
<div>

</div>


</div>
</div>
<!-- /breadcrumb -->
@endsection
@section('title')
{{'برنامج الفواتير'}}
@endsection
@section('content')
<!-- row -->
<div class="row row-sm">
<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
<div class="card overflow-hidden sales-card bg-primary-gradient">
<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
<div class="">
<h6 class="mb-3 tx-12 text-white">اجمالي الفواتير</h6>
</div>
<div class="pb-0 mt-0">
<div class="d-flex">
<div class="">
<h4 class="tx-20 font-weight-bold mb-1 text-white">
	
@php

$sum_invoices = DB::table('invoices')->where('deleted_at',null)->sum('Total');

@endphp
{{number_format($sum_invoices,2)}} $
</h4>
<p class="mb-0 tx-12 text-white op-7">

@php

$count_invoices = DB::table('invoices')->where('deleted_at',null)->count(); 

@endphp
{{$count_invoices}}
</p>
</div>
<span class="float-right my-auto mr-auto">
<i class="fas fa-arrow-circle-up text-white"></i>
<span class="text-white op-7"> 100%</span>
</span>
</div>
</div>
</div>
<span id="compositeline" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
</div>
</div>
<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
<div class="card overflow-hidden sales-card bg-danger-gradient">
<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
<div class="">
<h6 class="mb-3 tx-12 text-white">الفواتير الغير مدفوعه</h6>
</div>
<div class="pb-0 mt-0">
<div class="d-flex">
<div class="">
<h4 class="tx-20 font-weight-bold mb-1 text-white">
	@php
      $notpayed = DB::table('invoices')->where('Value_Status', 0)->where('deleted_at',null)->sum('Total');
	@endphp

	{{number_format($notpayed,2)}} $
</h4>
<p class="mb-0 tx-12 text-white op-7">
@php 

$count_not_payed = DB::table('invoices')->where('Value_Status', 0)->where('deleted_at',null)->count();

@endphp

{{$count_not_payed}}

</p>
</div>
<span class="float-right my-auto mr-auto">
<i class="fas fa-arrow-circle-down text-white"></i>
<span class="text-white op-7">
@php 	
if($count_invoices !== 0)
$per = $count_not_payed / $count_invoices * 100;
else 

$count_invoices = 1;

$per = $count_not_payed / $count_invoices * 100;



@endphp

{{round($per)}} %

</span>
</span>
</div>
</div>
</div>
<span id="compositeline2" class="pt-1">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span>
</div>
</div>
<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
<div class="card overflow-hidden sales-card bg-success-gradient">
<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
<div class="">
<h6 class="mb-3 tx-12 text-white">الفواتير المدفوعه</h6>
</div>
<div class="pb-0 mt-0">
<div class="d-flex">
<div class="">
<h4 class="tx-20 font-weight-bold mb-1 text-white">

@php
      $payed = DB::table('invoices')->where('Value_Status', 1)->where('deleted_at',null)->sum('Total');
	@endphp

	{{number_format($payed,2)}} $

</h4>
<p class="mb-0 tx-12 text-white op-7">

@php 

$count_payed = DB::table('invoices')->where('Value_Status', 1)->where('deleted_at',null)->count();

@endphp

{{$count_payed}}


</p>
</div>
<span class="float-right my-auto mr-auto">
<i class="fas fa-arrow-circle-up text-white"></i>
<span class="text-white op-7"> 
@php 	
$per_p = $count_payed / $count_invoices * 100;
@endphp
{{round($per_p)}} %


</span>
</span>
</div>
</div>
</div>
<span id="compositeline3" class="pt-1">5,10,5,20,22,12,15,18,20,15,8,12,22,5,10,12,22,15,16,10</span>
</div>
</div>
<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
<div class="card overflow-hidden sales-card bg-warning-gradient">
<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
<div class="">
<h6 class="mb-3 tx-12 text-white">الفواتير المدفوعه جزئيا</h6>
</div>
<div class="pb-0 mt-0">
<div class="d-flex">
<div class="">
<h4 class="tx-20 font-weight-bold mb-1 text-white">
@php
      $per_payed = DB::table('invoices')->where('Value_Status', 2)->where('deleted_at',null)->sum('Total');
	@endphp

	{{number_format($per_payed,2)}} $
</h4>
<p class="mb-0 tx-12 text-white op-7">
@php 

$count_per_payed = DB::table('invoices')->where('Value_Status', 2)->where('deleted_at',null)->count();

@endphp

{{$count_per_payed}}


</p>
</div>
<span class="float-right my-auto mr-auto">
<i class="fas fa-arrow-circle-down text-white"></i>
<span class="text-white op-7"> 

@php 	
$per_pp = $count_per_payed / $count_invoices * 100;
@endphp
{{round($per_pp)}} %

</span>
</span>
</div>
</div>
</div>
<span id="compositeline4" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
</div>
</div>
</div>
<!-- row closed -->

<!-- row opened -->
<div class="row row-sm">
<div class="col-md-12 col-lg-12 col-xl-7">
<div class="card">
<div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
<div class="d-flex justify-content-between">
<h4 class="card-title mb-0">نسبة احصائية الفواتير</h4>
<i class="mdi mdi-dots-horizontal text-gray"></i>
</div>

</div>	


<div style="width:90%;">
    {!! $chartjs->render() !!}
</div>

</div>
</div>



<div class="col-lg-12 col-xl-5">
<div class="card card-dashboard-map-one">
<label class="main-content-label">نسبة احصائية الفواتير</label>
<div style="width:100%;">
    {!! $chartjs2->render() !!}
</div>
</div>
</div>
</div>
<!-- row closed -->

<!-- row opened -->



</div>
</div>
</div>
</div>
</div>
</div>
<!-- row close -->







</div>
</div>
</div>
<!-- /row -->
</div>
</div>
<!-- Container closed -->
@endsection
@section('js')
<!--Internal  Chart.bundle js -->
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
<!-- Moment js -->
<script src="{{URL::asset('assets/plugins/raphael/raphael.min.js')}}"></script>
<!--Internal  Flot js-->
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.categories.js')}}"></script>
<script src="{{URL::asset('assets/js/dashboard.sampledata.js')}}"></script>
<script src="{{URL::asset('assets/js/chart.flot.sampledata.js')}}"></script>
<!--Internal Apexchart js-->
<script src="{{URL::asset('assets/js/apexcharts.js')}}"></script>
<!-- Internal Map -->
<script src="{{URL::asset('assets/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<script src="{{URL::asset('assets/js/modal-popup.js')}}"></script>
<!--Internal  index js -->
<script src="{{URL::asset('assets/js/index.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery.vmap.sampledata.js')}}"></script>	
@endsection