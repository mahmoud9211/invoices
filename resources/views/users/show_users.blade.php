@extends('layouts.master')
@section('css')

@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة المستخدمين</span>
						</div>
					</div>
			
				</div>
				<!-- breadcrumb -->
@endsection

@section('title')
{{'قائمة المستخدمين'}}
@endsection

@section('content')
				<!-- row -->
				<div class="row">



	<div class="col-xl-12">
<div class="card">

<div class="card-header pb-0">

<div class="col-sm-6 col-md-4 col-xl-3">

	@can('اضافة مستخدم')
	<a class="btn btn-outline-primary btn-block" data-effect="effect-scale" href="{{route('users.create')}}">  اضافة مستخدم</a>
	@endcan

</div>

<div class="card-body">
<div class="table-responsive">
<table class="table text-md-nowrap" id="example1">
	<thead>
		<tr>
			<th class="wd-15p border-bottom-0">#</th>
			<th class="wd-15p border-bottom-0">اسم المستخدم</th>
			<th class="wd-20p border-bottom-0">البريد الالكتروني</th>
			<th class="wd-15p border-bottom-0">حالة المستخدم</th>
			<th class="wd-10p border-bottom-0">نوع المستخدم</th>
			<th class="wd-25p border-bottom-0">العمليات</th>
		</tr>
	</thead>
	<tbody>
	
		@php
		$i=1;
		@endphp

		@foreach($data as $val)
		<tr>
			<td>{{$i++}}</td>
			<td>{{$val->name}}</td>
			<td>{{$val->email}} </td>
			<td>@if($val->status == 0)
				غير مفعل
				@else 
				مفعل
				@endif
			</td>
			
			<td>{{$val->roles_name}}</td>
			<td>

				@can('تعديل مستخدم')
			<a class="btn btn-sm btn-info" data-effect="effect-scale" 
  href="{{route('users.edit',$val->id)}}"><i class="fa fa-edit"></i></a>
  @endcan

  @can('حذف مستخدم')
<a class="modal-effect btn btn-sm btn-danger"  data-toggle="modal"
data-id="{{$val->id}}" 
 data-effect="effect-scale"  href="#modaldemo9"><i class="fa fa-trash"></i></a>	
 @endcan




			</td>
			
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


					<div class="modal" id="modaldemo9">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title">حذف الفاتورة</h6><button aria-label="Close" class="close" data-dismiss="modal"
                                                                                   type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <form action="{{route('users.del')}}" method="post">
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









				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')

<!--Internal  Datatable js -->

<script>
	$('#modaldemo9').on('show.bs.modal',function(event){
	
	let button = $(event.relatedTarget)
	let id = button.data('id')
	let modal = $(this)
	modal.find('.modal-body #id').val(id);
	})
	
	
	
	
	</script>

@endsection