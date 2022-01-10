@extends('layouts.master')
@section('css')

@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
<div class="my-auto">
<div class="d-flex">
<h4 class="content-title mb-0 my-auto">قائمة الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل الفاتورة</span>
</div>
</div>

</div>
<!-- breadcrumb -->
@endsection

@section('title')
{{'تفاصيل الفاتورة'}}
@endsection

@section('content')
<!-- row -->
<div class="row">


<div class="col-xl-12">
<!-- div -->
<div class="card mg-b-20" id="tabs-style2">
<div class="card-body">
<div class="text-wrap">
<div class="example">
<div class="panel panel-primary tabs-style-2">
<div class=" tab-menu-heading">
<div class="tabs-menu1">
<!-- Tabs -->
<ul class="nav panel-tabs main-nav-line">
<li><a href="#tab4" class="nav-link active" data-toggle="tab">تفاصيل الفاتورة</a></li>
<li><a href="#tab5" class="nav-link" data-toggle="tab">حالات الدفع</a></li>
<li><a href="#tab6" class="nav-link" data-toggle="tab">المرفقات</a></li>
</ul>
</div>
</div>
<div class="panel-body tabs-menu-body main-content-body-right border">
<div class="tab-content">
<div class="tab-pane active" id="tab4">
<div class="table-responsive mt-15">
<table class="table table-striped" style="text-align:center">
		<tbody>
			<tr>
				<th scope="row">رقم الفاتورة</th>
				<td>{{ $invoices->invoice_number }}</td>
				<th scope="row">تاريخ الاصدار</th>
				<td>{{ $invoices->invoice_Date }}</td>
				<th scope="row">تاريخ الاستحقاق</th>
				<td>{{ $invoices->Due_date }}</td>
				<th scope="row">القسم</th>
				<td>{{ $invoices->section->section_name }}</td>
			</tr>

			<tr>
				<th scope="row">المنتج</th>
				<td>{{ $invoices->products->product_name }}</td>
				<th scope="row">مبلغ التحصيل</th>
				<td>{{ $invoices->Amount_collection }}</td>
				<th scope="row">مبلغ العمولة</th>
				<td>{{ $invoices->Amount_Commission }}</td>
				<th scope="row">الخصم</th>
				<td>{{ $invoices->Discount }}</td>
			</tr>


			<tr>
				<th scope="row">نسبة الضريبة</th>
				<td>{{ $invoices->Rate_VAT }}</td>
				<th scope="row">قيمة الضريبة</th>
				<td>{{ $invoices->Value_VAT }}</td>
				<th scope="row">الاجمالي مع الضريبة</th>
				<td>{{ $invoices->Total }}</td>
				<th scope="row">الحالة الحالية</th>

				@if ($invoices->Value_Status == 0)
					<td><span
							class="badge badge-pill badge-danger">{{ $invoices->Status }}</span>
					</td>
				@elseif($invoices->Value_Status ==1)
					<td><span
							class="badge badge-pill badge-success">{{ $invoices->Status }}</span>
					</td>
				@else
					<td><span
							class="badge badge-pill badge-warning">{{ $invoices->Status }}</span>
					</td>
				@endif
			</tr>

			<tr>
				<th scope="row">ملاحظات</th>
				<td>{{ $invoices->note }}</td>
			</tr>
		</tbody>
	</table>





</div>
</div>

<div class="tab-pane" id="tab5">

<div class="table-responsive mt-15">
<table class="table center-aligned-table mb-0 table-hover"
style="text-align:center">
<thead>
<tr class="text-dark">
	<th>#</th>
	<th>رقم الفاتورة</th>
	<th>نوع المنتج</th>
	<th>القسم</th>
	<th>حالة الدفع</th>
	<th>تاريخ الدفع </th>
	<th>ملاحظات</th>
	<th>تاريخ الاضافة </th>
	<th>المستخدم</th>
</tr>
</thead>
<tbody>
<?php $i = 0; ?>
@foreach ($det as $x)
	<?php $i++; ?>
	<tr>
		<td>{{ $i }}</td>
		<td>{{ $x->invoice_number }}</td>
		<td>{{ $x->product->product_name }}</td>
		<td>{{ $invoices->Section->section_name }}</td>
		@if ($x->Value_Status == 0)
			<td><span
					class="badge badge-pill badge-danger">{{ $x->Status }}</span>
			</td>
		@elseif($x->Value_Status == 1)
			<td><span
					class="badge badge-pill badge-success">{{ $x->Status }}</span>
			</td>
		@else
			<td><span
					class="badge badge-pill badge-warning">{{ $x->Status }}</span>
			</td>
		@endif
		<td>{{$x->Payment_Date}}</td>
		<td>{{$x->note}}</td>
		<td>{{$x->created_at}}</td>
		<td>{{$x->user}}</td>
	</tr>
@endforeach
</tbody>
</table>


</div>
</div>


























<div class="tab-pane" id="tab6">

	<div class="card-body">
		<p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
		<h5 class="card-title">اضافة مرفقات</h5>
		<form method="post" action="{{route('uploadFiles')}}"
			enctype="multipart/form-data">
			@csrf
			
				<input type="file" name="filename">
				<input type="hidden" id="customFile" name="invoice_number"
					value="{{ $invoices->invoice_number }}">

					<input type="hidden" id="customFile" name="product"
					value="{{ $invoices->product }}">

					<input type="hidden" id="customFile" name="section"
					value="{{ $invoices->section->section_name }}">

				<input type="hidden" id="invoice_id" name="invoice_id"
					value="{{ $invoices->id }}">
				
			</div>
			<button type="submit" class="btn btn-primary btn-sm "
				name="uploadedFile">تاكيد</button>
		</form>
	
<br>



<div class="table-responsive">
	<table class="table text-md-nowrap" id="example1">

		

	
		<thead>
			
			<tr class="text-dark">
			
				<th scope="col">م</th>
				<th scope="col">اسم الملف</th>
				<th scope="col">قام بالاضافة</th>
				<th scope="col">تاريخ الاضافة</th>
				<th scope="col">العمليات</th>
				
			</tr>
			
		</thead>
		

		
		<tbody>
			<?php $i = 1; ?>
			@foreach ($attachments as $attachment)
				<tr>
                   
					@if($attachment->file)
					<td>{{ $i++ }}</td>
					<td>{{ $attachment->file }}</td>
					<td>{{ $attachment->user }}</td>
					<td colspan="2">

						<a class="btn btn-outline-success btn-sm"
							href="{{url('viewfile')}}/{{$attachment->file}}/{{$attachment->invoice->invoice_number}}"
							role="button"><i class="fas fa-eye"></i>&nbsp;
							عرض</a>

						<a class="btn btn-outline-info btn-sm"
							href="{{url('downloadfile')}}/{{$attachment->file}}/{{$attachment->invoice->invoice_number}}"
							role="button"><i
								class="fas fa-download"></i>&nbsp;
							تحميل</a>

							<a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
							data-toggle="modal" data-target="#del{{$attachment->id}}"><i class=" fa fa-trash"></i>حذف</a>

<!-- modal for delete data !-->

<div class="modal" id="del{{$attachment->id}}">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title">حذف المرفق </h6><button aria-label="Close" class="close" data-dismiss="modal"
															   type="button"><span aria-hidden="true">&times;</span></button>
			</div>
			<form action="{{route('attachment.delete',$attachment->id)}}" method="post">
		
				@csrf
				

				<div class="modal-body">
				<input type ="hidden" id="id" name="id" value="{{$attachment->id}}">
					<p>هل انت متأكد من الحذف ؟</p><br>
				   



				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
					<button type="submit" class="btn btn-danger">حذف</button>
				</div>
		</div>
		</form>
	</div>
</div>







					</td>
					@endif
				</tr>
			@endforeach
		</tbody>
		</tbody>
	</table>

</div>
</div>

</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>








</div>
</div>






</div>
</div>
</div>
</div>
</div>
<ul class="nav nav-tabs html-source" id="html-source-code2" role="tablist">
<li class="nav-item">
</li>
</ul>

</div>
</div>
</div>
</div>
<!-- /div -->













</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')

@endsection