@extends('layouts.master')
@section('css')

@endsection
@section('title')
{{'المنتجات'}}
@endsection
@section('page-header')
	<!-- breadcrumb -->
	<div class="breadcrumb-header justify-content-between">
		<div class="my-auto">
			<div class="d-flex">
				<h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المنتجات</span>
			</div>
		</div>
	
	</div>
	<!-- breadcrumb -->
@endsection
@section('content')
	<!-- row -->
	<div class="row">

	@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

	<div class="col-xl-12">
			<div class="card">
				<div class="card-header pb-0">
				<div class="col-sm-6 col-md-4 col-xl-3">
					@can('اضافة منتج')
					<a class="btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8">اضافة منتج</a>
					@endcan 
				</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table text-md-nowrap" id="example1">
							<thead>
								<tr>
									<th class="wd-15p border-bottom-0">#</th>
									<th class="wd-15p border-bottom-0">المنتج</th>
									<th class="wd-20p border-bottom-0">القسم</th>
									<th class="wd-20p border-bottom-0">الملاحظات</th>
									<th class="wd-15p border-bottom-0">العمليات</th>
								</tr>
							</thead>
							<tbody>
								@php
                                $i = 1;
								@endphp
								@foreach($products as $product)
								<tr>
									<td>{{$i++}}</td>
									<td>{{$product->product_name}}</td>
									<td>{{$product->sections->section_name}} </td>
									<td>{{$product->description}}</td>
									<td>

@can('تعديل منتج')										
<a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
 data-toggle="modal" data-id="{{$product->id}}" data-name="{{$product->product_name}}" data-section="{{$product->sections->section_name}}"
 data-desc="{{$product->description}}"
  href="#modaldemo9"><i class="fa fa-edit"></i></a>
  @endcan

  @can('حذف منتج')
<a class="modal-effect btn btn-sm btn-danger"  data-toggle="modal" data-id="{{$product->id}}" data-name="{{$product->product_name}}"
 data-effect="effect-scale"  href="#modaldemo10"><i class="fa fa-trash"></i></a>	
@endcan
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

<!-- modal for insert data !-->

<div class="modal" id="modaldemo8">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title">اضافة منتج</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">


			<form  action=""  method="post">
				@csrf
<div class="form-group">
<label>اسم المنتج</label>
<input type="text" class="form-control" name="product_name"  aria-describedby="emailHelp" >
</div>

<div class="form-group">

<label class="my-1 mr-2">القسم</label>
<select name="section_id" id="section_id" class="form-control" required>
<option value="" selected disabled> --حدد القسم--</option>
@foreach ($sections as $section)
<option value="{{ $section->id }}">{{ $section->section_name }}</option>
@endforeach

</select>
</div>


<div class="form-group">
<label>ملاحظات</label>
<textarea type="text" name="description" class="form-control" > </textarea>
</div>

<div class="modal-footer">
				<button class="btn ripple btn-primary" type="submit">تأكيد</button>
				<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">اغلاق</button>
			</div>


</form>



			</div>
		
		</div>
	</div>
</div>





<!-- modal for edit data !-->

<div class="modal" id="modaldemo9">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title"> تعديل منتج</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">


			<form  action="{{route('products.update')}}"  method="post">
				@csrf
				<input type="hidden" id="pro_id" name="pro_id">
<div class="form-group">
<label>اسم المنتج</label>
<input type="text" class="form-control" name="product_name" id="product_name"  aria-describedby="emailHelp" >
</div>

<div class="form-group">

<label class="my-1 mr-2">القسم</label>
<select name="section_name" id="section_name" class="form-control" required>
<option value="" selected disabled> --حدد القسم--</option>
@foreach ($sections as $section)
	<option>{{ $section->section_name }}</option>
@endforeach
</select>
</div>


<div class="form-group">
<label>ملاحظات</label>
<textarea type="text" name="description" id='description' class="form-control" > </textarea>
</div>

<div class="modal-footer">
				<button class="btn ripple btn-primary" type="submit">تأكيد</button>
				<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">اغلاق</button>
			</div>


</form>



			</div>
		
		</div>
	</div>
</div>



	<!-- modal for delete data !-->

	<div class="modal" id="modaldemo10">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content modal-content-demo">
				<div class="modal-header">
					<h6 class="modal-title">حذف المنتج</h6><button aria-label="Close" class="close" data-dismiss="modal"  type="button"><span aria-hidden="true">&times;</span></button>
				</div>
				<form action="{{route('products.delete')}}" method="post">
					@csrf
					

					<div class="modal-body">
					<input type ="hidden" id="id" name="id">
						<p>هل انت متاكد من عملية الحذف ؟</p><br>
					   
<input type="text" class="form-control" name="product_name" id="product_name" aria-describedby="emailHelp" readonly >



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
	$('#modaldemo9').on('show.bs.modal',function(event){
	let button = $(event.relatedTarget)
	let pro_id = button.data('id')
	let product_name = button.data('name')
	let section_name = button.data('section')
	let description = button.data('desc')
	
	let modal = $(this)
	modal.find('.modal-body #product_name').val(product_name);
	modal.find('.modal-body #section_name').val(section_name);
	modal.find('.modal-body #description').val(description);
	modal.find('.modal-body #pro_id').val(pro_id);
	
	
	
	})
	
	</script>
	
	<script>
	$('#modaldemo10').on('show.bs.modal',function(event){
	
	let button = $(event.relatedTarget)
	let id = button.data('id')
	let name = button.data('name')
	let modal = $(this)
	modal.find('.modal-body #id').val(id);
	modal.find('.modal-body #product_name').val(name);
	
	
	
	})
	
	
	
	
	</script>
	
	
	
	@endsection