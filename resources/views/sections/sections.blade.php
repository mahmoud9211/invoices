@extends('layouts.master')
@section('css')

@endsection
@section('title')
{{'الأقسام'}}
@endsection
@section('page-header')
	<!-- breadcrumb -->
	<div class="breadcrumb-header justify-content-between">
		<div class="my-auto">
			<div class="d-flex">
				<h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الأقسام</span>
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
					@can('اضافة قسم')
										<a class="btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8">اضافة قسم</a>
										@endcan
									</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table text-md-nowrap" id="example1">
							<thead>
								<tr>
									<th class="wd-15p border-bottom-0">#</th>
									<th class="wd-15p border-bottom-0">اسم القسم</th>
									<th class="wd-20p border-bottom-0">الوصف</th>
									<th class="wd-15p border-bottom-0">العمليات</th>
									
								</tr>
							</thead>
							<tbody>
								@php
                                $i = 1;
								@endphp
								@foreach($sections as $section)
								<tr>
									<td>{{$i++}}</td>
									<td>{{$section->section_name}}</td>
									<td>{{$section->description}}</td>
		
		@can('تعديل قسم')							<td>
<a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
 data-toggle="modal" data-id="{{$section->id}}" data-name="{{$section->section_name}}" data-desc="{{$section->description}}"
  href="#modaldemo9"><i class="fa fa-edit"></i></a>
  @endcan

  @can('حذف قسم')
<a class="modal-effect btn btn-sm btn-danger"  data-toggle="modal"
data-id="{{$section->id}}" data-name="{{$section->section_name}}"
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
						<h6 class="modal-title">اضافة قسم</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">


					<form  action="{{route('sections.store')}}"  method="post">
						{{csrf_field()}}
  <div class="form-group">
    <label for="exampleInputEmail1">اسم القسم</label>
    <input type="text" class="form-control" name="section_name" id="exampleInputEmail1" aria-describedby="emailHelp" >
   
	@error('section_name')
	<span class="text-danger"> {{$message}} </span>
	@enderror

  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">ملاحظات</label>
    <textarea type="text" name="description" class="form-control" id="exampleInputPassword1" > </textarea>
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





<!-- modal for Edit data !-->

<div class="modal" id="modaldemo9">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">تعديل القسم</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">


					<form  action="{{route('sections.update')}}"  method="post">
						@csrf
  <div class="form-group">
	  <input type ="hidden" id="id" name="id">
    <label >اسم القسم</label>
    <input type="text" class="form-control" name="section_name" id="section_name" aria-describedby="emailHelp" >
   


  </div>
  <div class="form-group">
    <label>ملاحظات</label>
    <textarea type="text" name="description" id="description" class="form-control"> </textarea>
  </div>
 
  <div class="modal-footer">
						<button class="btn ripple btn-primary" type="submit">تعديل</button>
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
                                    <h6 class="modal-title">حذف القسم</h6><button aria-label="Close" class="close" data-dismiss="modal"
                                                                                   type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <form action="{{route('sections.delete')}}" method="post">
                                    @csrf
									

                                    <div class="modal-body">
									<input type ="hidden" id="id" name="id">
                                        <p>هل انت متاكد من عملية الحذف ؟</p><br>
                                       
	<input type="text" class="form-control" name="section_name" id="section_name" aria-describedby="emailHelp" readonly >



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
let id = button.data('id')
let section_name = button.data('name')
let description = button.data('desc')

let modal = $(this)
modal.find('.modal-body #id').val(id);
modal.find('.modal-body #section_name').val(section_name);
modal.find('.modal-body #description').val(description);

})

</script>


<script>
$('#modaldemo10').on('show.bs.modal',function(event){

let button = $(event.relatedTarget)
let id = button.data('id')
let section_name = button.data('name')
let modal = $(this)
modal.find('.modal-body #id').val(id);
modal.find('.modal-body #section_name').val(section_name);



})




</script>
@endsection