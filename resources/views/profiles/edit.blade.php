@extends('layouts.master')
@section('css')
<!-- Internal Nice-select css  -->
@section('title')
تعديل الملف الشخصي
@endsection


@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
<div class="my-auto">
<div class="d-flex">
<h4 class="content-title mb-0 my-auto">الملف الشخصي</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل
مستخدم</span>
</div>
</div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">


<div class="col-lg-12 col-md-12">

@if (count($errors) > 0)
<div class="alert alert-danger">
<button aria-label="Close" class="close" data-dismiss="alert" type="button">
<span aria-hidden="true">&times;</span>
</button>
<strong>خطا</strong>
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<div class="card">
<div class="card-body">
<div class="col-lg-12 margin-tb">
<div class="pull-right">
<a class="btn btn-primary btn-sm" href="{{ url('/') }}">رجوع</a>
</div>
</div><br>
<form class="parsley-style-1"  autocomplete="off" action="{{route('profile.update',Auth::user()->id)}}" method="post" enctype="multipart/form-data">
@csrf

<div class="">

<div class="row mg-b-20">
	<div class="parsley-input col-md-6" id="fnWrapper">
		<label>اسم المستخدم: <span class="tx-danger">*</span></label>
		<input class="form-control form-control-sm mg-b-20"
			data-parsley-class-handler="#lnWrapper" name="name" value="{{Auth::user()->name}}" required="" type="text">
	</div>

	
</div>

</div>

<div class="row mg-b-20">
    <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
		<label>البريد الالكتروني: <span class="tx-danger">*</span></label>
		<input class="form-control form-control-sm mg-b-20"
			data-parsley-class-handler="#lnWrapper" name="email" value="{{Auth::user()->email}}" required=""  type="email">
	</div>


</div>

<div class="row row-sm mg-b-20">
<div class="col-lg-6">
	<label class="form-label">الصوره الشخصيه</label>

    <input class="form-control form-control-sm mg-b-20" name="photo"  type="file">
	
</div>
</div>


</div>
<div class="col-xs-12 col-sm-12 col-md-12 text-center">
<button class="btn btn-main-primary pd-x-20" type="submit">تاكيد</button>
</div>

</form>
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



@endsection