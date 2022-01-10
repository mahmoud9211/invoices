@extends('layouts.master')
@section('css')

@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
<div class="my-auto">
<div class="d-flex">
<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/  الفواتير المدفوعه</span>
</div>
</div>

</div>
<!-- breadcrumb -->
@endsection
@section('title')
{{' الفواتير المدفوعه'}}
@endsection
@section('content')
<!-- row -->
<div class="row">

<div class="col-xl-12">
<div class="card">

<div class="card-header pb-0">
<div class="col-sm-6 col-md-4 col-xl-3">
	@can('اضافة فاتورة')
<a class="btn btn-outline-primary btn-block" data-effect="effect-scale" href="{{route('invoices.create')}}">اضافة فاتورة</a>
@endcan

@can('تصدير EXCEL')
<a class="btn btn-outline-primary btn-block" data-effect="effect-scale" href="{{url('users/export/')}}">تصدير اكسيل</a>
@endcan



</div>
<div class="card-body">
<div class="table-responsive">
<table class="table text-md-nowrap" id="example1">
	<thead>
		<tr>
			<th class="wd-15p border-bottom-0">#</th>
			<th class="wd-15p border-bottom-0">رقم الفاتورة</th>
			<th class="wd-20p border-bottom-0">تاريخ الفاتورة</th>
			<th class="wd-15p border-bottom-0">تاريخ الاستحقاق</th>
			<th class="wd-10p border-bottom-0">المنتج</th>
			<th class="wd-25p border-bottom-0">القسم</th>
			<th class="wd-15p border-bottom-0">الخصم</th>
			<th class="wd-10p border-bottom-0">نسبة الضريبه</th>
			<th class="wd-25p border-bottom-0">قيمة الضريبه</th>
			<th class="wd-10p border-bottom-0">الاجمالي</th>
			<th class="wd-25p border-bottom-0">الحاله</th>
			<th class="wd-25p border-bottom-0" style="width:30%;">العمليات</th>
		</tr>
	</thead>
	<tbody>
		@php
		$i=1;
		@endphp

		@foreach($data as $val)
		<tr>
			<td>{{$i++}}</td>
			<td>{{$val->invoice_number}}</td>
			<td>{{$val->invoice_Date}} </td>
			<td>{{$val->Due_date}}</td>
			<td><a href="{{ route('invoices.det',$val->id) }}">{{$val->products->product_name}}</a></td>
			<td>{{$val->section->section_name}}</td>
			<td>{{$val->Discount}}</td>
			<td>{{$val->Rate_VAT}}</td>
			<td>{{$val->Value_VAT}}</td>
			<td>{{$val->Total}}</td>
			@if($val->Value_Status == 0)
			<td><span class="badge badge-danger">{{$val->Status}}</span></td>
			@elseif($val->Value_Status == 1)
			<td><span class="badge badge-success">{{$val->Status}}</span></td>
			@else
			<td><span class="badge badge-warning">{{$val->Status}}</span></td>

			@endif
			<td> 
			<div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
العمليات  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

      @can('تعديل الفاتورة')
    <a class="dropdown-item" href="{{route('invoice.edit',$val->id)}}">تعديل الفاتورة</a>
	@endcan 

	@can('حذف الفاتورة')
    <a class="dropdown-item"  data-toggle="modal"
data-id="{{$val->id}}" data-effect="effect-scale"  href="#modaldemo10">حذف الفاتورة</a>
@endcan
     
      @can('تغير حالة الدفع')
    <a class="dropdown-item" href="{{route('status.update',$val->id)}}">تغيير حالة الدفع</a>
	@endcan 

	@can('ارشفة الفاتورة')
	<a class="dropdown-item"  data-toggle="modal"
data-id="{{$val->id}}" data-effect="effect-scale"  href="#modaldemo11">أرشفة الفاتورة</a>
@endcan


@can('طباعةالفاتورة')
<a class="dropdown-item" href="{{route('invoice.print',$val->id)}}">طباعة الفاتورة</a>
@endcan


  </div>
</div>

			</td>

		</tr>
		@endforeach
										
							
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>


<!-- modal for delete data !-->

<div class="modal" id="modaldemo10">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title">حذف الفاتورة</h6><button aria-label="Close" class="close" data-dismiss="modal"
                                                                                   type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <form action="{{route('invoice.delete')}}" method="post">
                                    @csrf
									

                                    <div class="modal-body">
									<input type ="hidden" id="id" name="id">
                                        <p>هل انت متاكد من عملية الحذف ؟</p><br>
                                       </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                        <button type="submit" class="btn btn-danger">تاكيد</button>
                                    </div>
                            </div>
                            </form>
                        </div>
                    </div>


					<!-- modal for archive data !-->

<div class="modal" id="modaldemo11">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title">أرشفة الفاتورة</h6><button aria-label="Close" class="close" data-dismiss="modal"
                                                                                   type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <form action="{{route('invoice.archive')}}" method="post">
                                    @csrf
									

                                    <div class="modal-body">
									<input type ="hidden" id="id" name="id">
                                        <p>هل انت متاكد من أرشفة الفاتورة ؟</p><br>
                                       </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                        <button type="submit" class="btn btn-danger">تاكيد</button>
                                    </div>
                            </div>
                            </form>
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


<script>
$('#modaldemo10').on('show.bs.modal',function(event){

let button = $(event.relatedTarget)
let id = button.data('id')
let modal = $(this)
modal.find('.modal-body #id').val(id);
})




</script>

<script>
$('#modaldemo11').on('show.bs.modal',function(event){

let button = $(event.relatedTarget)
let id = button.data('id')
let modal = $(this)
modal.find('.modal-body #id').val(id);
})




</script>










@endsection