@extends('layouts.master')

@section('title')
الملف الشخصي
@endsection

@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الملف الشخصي</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ عرض</span>
						</div>
					</div>
				
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row">

					<div class="col-xl-12">
						<div class="card mg-b-20">
						
						
						<div class="card-header pb-0">

					<div class="main-profile-overview">
						<div class="main-img-user profile-user">
							<img  src="{{Auth::user()->profile_photo_path == null ? asset('uploads/user_images/'.'noimg.png') : asset('uploads/user_images/'. Auth::user()->profile_photo_path)}}">
						</div>
						<div class="d-flex justify-content-between mg-b-20">
							<div>
								<h5 class="main-profile-name">{{optional(Auth::user())->name}}</h5>
								<p class="main-profile-name-text">{{optional(Auth::user())->roles_name}}</p>
							</div>
						</div>
						<h6>{{optional(Auth::user())->email}}</h6>
					
						<div class="row">
							<div class="col-md-4 col mb20">
								<a href="{{route('profile.edit')}}" class="btn btn-primary"> تعديل الملف الشخصي </a>

								<a href="{{route('profile.password.change')}}" class="btn btn-danger"> تغيير كلمة السر </a>

							</div>

							
						</div>
						<hr class="mg-y-30">
						
						</div>
						
						
				
					</div><!-- main-profile-overview -->
				</div></div></div>

				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
@endsection