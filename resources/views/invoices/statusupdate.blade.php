@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تغيير حالة الدفع</span>
						</div>
					</div>
				
				</div>
				<!-- breadcrumb -->
@endsection

@section('title')
{{'تغيير حالة الدفع'}}
@endsection

@section('content')
				<!-- row -->
				<div class="row">
				<div class="col-xl-12">
						<div class="card">
						
						<div class="card-header pb-0">
				<div class="col-sm-6 col-md-4 col-xl-3">
									</div>
							<div class="card-body">

 <form action="{{route('change.status',$data->id)}}" method="post" enctype="multipart/form-data">
	 @csrf

 <div class="form-row">
<div class="col-md-4">

<div class="form-group">
    <label>رقم الفاتورة</label>
    <input type="text" class="form-control" name="invoice_number" value="{{$data->invoice_number}}" readonly>
	@error('invoice_number')
	<span class="text-danger"> {{$message}} </span>
	@enderror
  </div>

</div>

<div class="col-md-4">

<div class="form-group">
    <label>تاريخ الفاتورة</label>
    <input type="date" class="form-control" name="invoice_Date"  value="{{$data->invoice_Date}}" readonly>
	@error('invoice_Date')
	<span class="text-danger"> {{$message}} </span>
	@enderror
  </div>

</div>

<div class="col-md-4">

<div class="form-group">
    <label>تاريخ الاستحقاق</label>
    <input type="date" class="form-control" name="Due_date"  value="{{$data->Due_date}}" readonly>
	@error('Due_date')
	<span class="text-danger"> {{$message}} </span>
	@enderror
  </div>

</div>

</div>






<div class="form-row">

<div class="col-md-4">

<div class="form-group">
    <label for="exampleFormControlSelect1">القسم</label>
	
    <select class="form-control" name="section_id" id="exampleFormControlSelect1" readonly>
	<option value="" disabled="" selected="">اختر القسم</option>
	@foreach($sections as $section)
      <option value="{{$section->id}}" {{$section->id == $data->section_id ? 'selected' : ''}} >{{$section->section_name}}</option>
	  @endforeach
    </select>
	@error('section_id')
	<span class="text-danger"> {{$message}} </span>
	@enderror
  </div>
</div>

<div class="col-md-4">

<div class="form-group">
    <label for="exampleFormControlSelect1">المنتج</label>
    <select class="form-control" name="product" id="exampleFormControlSelect1" readonly>
		@foreach($products as $pro)
<option value="{{$pro->id}}" {{$pro->id == $data->product ? 'selected' : ''}} > {{$pro->product_name}} </option>
		@endforeach

    </select>
	@error('product')
	<span class="text-danger"> {{$message}} </span>
	@enderror
  </div>
</div>

<div class="col-md-4">

<div class="form-group">
    <label>مبلغ التحصيل</label>
    <input type="text" class="form-control" name="Amount_collection" value="{{$data->Amount_collection}}" readonly>
	@error('Amount_collection')
	<span class="text-danger"> {{$message}} </span>
	@enderror
  </div>

</div>

</div>






<div class="form-row">

<div class="col-md-4">
<div class="form-group">
    <label>مبلغ العمولة</label>
    <input type="text" class="form-control" id="Amount_Commission" name="Amount_Commission" value="{{$data->Amount_Commission}}" readonly>
	@error('Amount_Commission')
	<span class="text-danger"> {{$message}} </span>
	@enderror
  </div>

</div>


<div class="col-md-4">

<div class="form-group">
    <label>الخصم</label>
    <input type="text" class="form-control" id="Discount" value="0" name="Discount" value="{{$data->Discount}}" readonly>
  </div>
</div>




<div class="col-md-4">
<div class="form-group">
    <label >نسبة ضريبة القيمة المضافة</label>
    <select class="form-control" id="Rate_VAT" onchange="myFunction()" name="Rate_VAT" readonly>
 
	@if($data->Rate_VAT == '5%')
	<option value=" 5%" selected disabled>5%</option>
	<option value=" 10%" disabled>10%</option>

 @else
 <option value=" 10%" selected disabled>10%</option>
 <option value=" 5%" disabled >5%</option>

 @endif



	</select>
	@error('Rate_VAT')
	<span class="text-danger"> {{$message}} </span>
	@enderror
  </div>


</div>

</div>

</div>


<div class="form-row">

<div class="col-md-6">

<div class="form-group">
    <label>قيمة ضريبة القيمة المضافة</label>
    <input type="text" class="form-control" id="Value_VAT" name="Value_VAT" value="{{$data->Value_VAT}}" readonly >
  </div>


</div>

<div class="col-md-6">

<div class="form-group">
    <label>الاجمالي شامل الضريبة</label>
    <input type="text" class="form-control" id="Total" name="Total" value="{{$data->Total}}" readonly >
  </div>

</div>

</div>

<div class="form-row">

<div class="col-md-12">
<div class="form-group">
    <label for="exampleFormControlTextarea1">ملاحظات</label>
    <textarea class="form-control" name="note" id="exampleFormControlTextarea1" rows="3" readonly>{{$data->note}}</textarea>
  </div>

</div>
</div>
<br>


<div class="form-row">

<div class="col-md-6">
<div class="form-group">
<label >حالة الدفع</label>
    <select class="form-control"  name="Status" >
	<option value="" selected disabled>اختر حالة الدفع</option>
 <option value="مدفوعة">مدفوعة</option>
 <option value="مدفوعة جزئيا">مدفوعة جزئيا</option>

</select>
</div>
</div>

<div class="col-md-6">
<div class="form-group">



<label>تاريخ الدفع</label>
    <input type="date" class="form-control"  name="Payment_Date"  >
  </div>


</div>
</div>




</div>


<div class="form-group">

	<button type="submit" class="btn btn-primary">حفظ البيانات</button>
</div>
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