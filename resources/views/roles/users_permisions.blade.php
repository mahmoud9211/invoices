@extends('layouts.master')
@section('css')

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
	@can('اضافة صلاحية')
<a class="btn btn-outline-primary btn-block" data-effect="effect-scale" href="{{url('roles/create')}}">اضافة</a>
@endcan
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
@can('عرض صلاحية')
<a class="btn btn-sm btn-info" data-effect="effect-scale"  href="{{route('roles.showpermission',$val->id)}}">عرض</a>
@endcan


@can('تعديل صلاحية')
<a class="btn btn-sm btn-danger" data-effect="effect-scale"  href="{{route('roles.edit',$val->id)}}">تعديل</a>
@endcan


@if($val->name !== 'Admin')
@can('حذف صلاحية')

<a class="modal-effect btn btn-sm btn-danger"  data-toggle="modal"
data-id="{{$val->id}}" 
 data-effect="effect-scale"  href="#modaldemo9">حذف</a>	
 @endcan

 @else 
 @endif


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
                                    <h6 class="modal-title">حذف الصلاحيه</h6><button aria-label="Close" class="close" data-dismiss="modal"
                                                                                   type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <form action="{{route('roles.destroy','test')}}" method="post">
                                    @csrf
									{{method_field('delete')}}
									

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


<script>
	$('#modaldemo9').on('show.bs.modal',function(event){
	
	let button = $(event.relatedTarget)
	let id = button.data('id')
	let modal = $(this)
	modal.find('.modal-body #id').val(id);
	})
	
	
	
	
	</script>

@endsection