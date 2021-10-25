@extends('layouts.master')
@section('css')
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ صلاحيات المستخدمين</span>
						</div>
					</div>
			
				</div>
				<!-- breadcrumb -->
@endsection

@section('title')
{{'صلاحيات المستخدمين'}}
@endsection

@section('content')
				<!-- row -->
				<div class="row">



	<div class="col-xl-12">
<div class="card">

<div class="card-header pb-0">

<div class="col-sm-6 col-md-4 col-xl-3">
<a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" href="{{url('roles/create')}}">اضافة</a>
</div>

<div class="card-body">
<div class="table-responsive">
<table class="table text-md-nowrap" id="example1">
	<thead>
		<tr>
			<th class="wd-15p border-bottom-0">#</th>
			<th class="wd-15p border-bottom-0">الاسم</th>
			<th class="wd-25p border-bottom-0">العمليات</th>
		</tr>
	</thead>
	<tbody>
	
@php
$i = 1;
@endphp
		@foreach($roles as $val)
		<tr>
			<td>{{$i++}}</td>
			<td>{{$val->name}}</td>
			<td>
<a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"  href="{{route('roles.showpermission',$val->id)}}">عرض</a>

<a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"  href="{{route('roles.edit',$val->id)}}">تعديل</a>
		    </td>
		
			


		</tr>
		@endforeach
										
							
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>    









				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
@endsection