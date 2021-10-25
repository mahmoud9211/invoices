@extends('layouts.master')
@section('css')
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اضافة فاتورة</span>
						</div>
					</div>
					
				</div>
				<!-- breadcrumb -->
@endsection

@section('title')
{{'اضافة فاتورة'}}
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

 <form action="{{route('invoice.insert')}}" method="post" enctype="multipart/form-data">
	 @csrf

 <div class="form-row">
<div class="col-md-4">

<div class="form-group">
    <label>رقم الفاتورة</label>
    <input type="text" class="form-control" name="invoice_number" >
	@error('invoice_number')
	<span class="text-danger"> {{$message}} </span>
	@enderror
  </div>

</div>

<div class="col-md-4">

<div class="form-group">
    <label>تاريخ الفاتورة</label>
    <input type="date" class="form-control" name="invoice_Date" value="{{ date('Y-m-d') }}" >
	@error('invoice_Date')
	<span class="text-danger"> {{$message}} </span>
	@enderror
  </div>

</div>

<div class="col-md-4">

<div class="form-group">
    <label>تاريخ الاستحقاق</label>
    <input type="date" class="form-control" name="Due_date" >
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
	
    <select class="form-control" name="section_id" id="exampleFormControlSelect1">
	<option value="" disabled="" selected="">اختر القسم</option>
	@foreach($sections as $section)
      <option value="{{$section->id}}">{{$section->section_name}}</option>
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
    <select class="form-control" name="product" id="exampleFormControlSelect1">

    </select>
	@error('product')
	<span class="text-danger"> {{$message}} </span>
	@enderror
  </div>
</div>

<div class="col-md-4">

<div class="form-group">
    <label>مبلغ التحصيل</label>
    <input type="text" class="form-control" name="Amount_collection" >
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
    <input type="text" class="form-control" id="Amount_Commission" name="Amount_Commission" >
	@error('Amount_Commission')
	<span class="text-danger"> {{$message}} </span>
	@enderror
  </div>

</div>


<div class="col-md-4">

<div class="form-group">
    <label>الخصم</label>
    <input type="text" class="form-control" id="Discount" value="0" name="Discount">
  </div>
</div>




<div class="col-md-4">
<div class="form-group">
    <label >نسبة ضريبة القيمة المضافة</label>
    <select class="form-control" id="Rate_VAT" onchange="myFunction()" name="Rate_VAT">
	<option value="" selected disabled>حدد نسبة الضريبة</option>
	<option value=" 5%">5%</option>
	<option value="10%">10%</option>
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
    <input type="text" class="form-control" id="Value_VAT" name="Value_VAT" readonly >
  </div>


</div>

<div class="col-md-6">

<div class="form-group">
    <label>الاجمالي شامل الضريبة</label>
    <input type="text" class="form-control" id="Total" name="Total" readonly >
  </div>

</div>

</div>

<div class="form-row">

<div class="col-md-12">
<div class="form-group">
    <label for="exampleFormControlTextarea1">ملاحظات</label>
    <textarea class="form-control" name="note" id="exampleFormControlTextarea1" rows="3"></textarea>
  </div>

</div>
</div>
<br>
<p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>

<h5 class="card-title">المرفقات</h5>
<div class="form-group">
    <label for="exampleFormControlTextarea1">files</label>
<input type="file" name="pic">
</div>
	<button type="submit" class="btn btn-primary">حفظ البيانات</button>
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

<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

 <script>
$(document).ready(function(){

$('select[name="section_id"]').on('change',function(){
let section_id = $(this).val();

if(section_id)
{
  $.ajax({
    type : 'GET',
	url : '/invoices/getbyajax/' + section_id,
	dataType : 'json',
	success:function(data)
	{ 
		$('select[name="product"]').empty();
		$.each(data,function(key,value){
			$('select[name="product"]').append('<option value=" '+value.id+' " >'+ value.product_name + '</option>') ;

		})
		


	}

  })

}



})





})

 


</script>


<script>
        function myFunction() {
            var Amount_Commission = parseFloat(document.getElementById("Amount_Commission").value); //مبلغ العموله
            var Discount = parseFloat(document.getElementById("Discount").value); //مبلغ الخصم
            var Rate_VAT = parseFloat(document.getElementById("Rate_VAT").value); //نسبة الضريبة
            var Value_VAT = parseFloat(document.getElementById("Value_VAT").value); //قيمة الضريبة
            var Amount_Commission2 = Amount_Commission - Discount; //حساب قيمة العمولة بعد الخصم
            if (typeof Amount_Commission === 'undefined' || !Amount_Commission) {
                alert('يرجي ادخال مبلغ العمولة ');
            } else {
                var intResults = Amount_Commission2 * Rate_VAT / 100; //حساب قيمة الضريبه
                var intResults2 = parseFloat(intResults + Amount_Commission2); //اجمالي المبلغ بعد الضريبة
                sumq = parseFloat(intResults).toFixed(2);
                sumt = parseFloat(intResults2).toFixed(2);
                document.getElementById("Value_VAT").value = sumq;
                document.getElementById("Total").value = sumt;
            }
        }
    </script>

@endsection