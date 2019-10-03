@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
        <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
        <small>{!! $crud->getSubheading() ?? trans('backpack::crud.edit').' '.$crud->entity_name !!}.</small>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'),'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	    <li class="active">{{ trans('backpack::crud.edit') }}</li>
	  </ol>
	</section>
@endsection

@section('content')
{{-- @if ($crud->hasAccess('list')) --}}
{{ request()->segment(2) }}
<br>
	@php
		$currentModule = request()->segment(2);
		switch ($currentModule) {
			case 'college':
					$targetUrl = url('/admin/college');
				break;
			case 'faculty':
				if (str_contains(Request::fullUrl(), 'college_from')) {
					$currentCollege = app('request')->input('college_from');
					$targetUrl = url('/admin/college/'.$currentCollege);
				}else{
					$targetUrl = url('/admin/faculty');
				}
				break;
			case 'school':
				if (str_contains(Request::fullUrl(), 'faculty_from')) {
					$currentFaculty = app('request')->input('faculty_from');
					$targetUrl = url('/admin/faculty/'.$currentFaculty);
				}else{
					$targetUrl = url('/admin/school');
				}
				break;
			case 'career':
				if (str_contains(Request::fullUrl(), 'school_from')) {
					$currentSchool = app('request')->input('school_from');
					$targetUrl = url('/admin/school/'.$currentSchool);
				}else{
					$targetUrl = url('/admin/career');
				}
				break;
			case 'subject':
				if (str_contains(Request::fullUrl(), 'career_from')) {
					$currentCareer = app('request')->input('career_from');
					$targetUrl = url('/admin/career/'.$currentCareer);
				}else{
					$targetUrl = url('/admin/subject');
				}
				break;
			case 'academic_period':
					$targetUrl = url('/admin/academic_period');
				break;
			case 'user':
					$targetUrl = url('/admin/user');
				break;
			case 'myrequest':
					$targetUrl = url('/admin/myrequest');
				break;
			default:
				$targetUrl = "";
				break;
		}
	@endphp
	<a href="{{ $targetUrl }}" class="hidden-print"><i class="fa fa-angle-double-left"></i> Regresar </span></a>

{{-- @endif --}}

<div class="row m-t-20">
	<div class="{{ $crud->getEditContentClass() }}">
		<!-- Default box -->

		@include('crud::inc.grouped_errors')

		  <form method="post"
		  		action="{{ url($crud->route.'/'.$entry->getKey()) }}"
				@if ($crud->hasUploadFields('update', $entry->getKey()))
				enctype="multipart/form-data"
				@endif
		  		>
		  {!! csrf_field() !!}
		  {!! method_field('PUT') !!}
		  <div class="col-md-12">
		  	@if ($crud->model->translationEnabled())
		    <div class="row m-b-10">
		    	<!-- Single button -->
				<div class="btn-group pull-right">
				  <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    {{trans('backpack::crud.language')}}: {{ $crud->model->getAvailableLocales()[$crud->request->input('locale')?$crud->request->input('locale'):App::getLocale()] }} &nbsp; <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">
				  	@foreach ($crud->model->getAvailableLocales() as $key => $locale)
					  	<li><a href="{{ url($crud->route.'/'.$entry->getKey().'/edit') }}?locale={{ $key }}">{{ $locale }}</a></li>
				  	@endforeach
				  </ul>
				</div>
		    </div>
		    @endif
		    <div class="row display-flex-wrap">
		      <!-- load the view from the application if it exists, otherwise load the one in the package -->
		      @if(view()->exists('vendor.backpack.crud.form_content'))
		      	@include('vendor.backpack.crud.form_content', ['fields' => $fields, 'action' => 'edit'])
		      @else
		      	@include('crud::form_content', ['fields' => $fields, 'action' => 'edit'])
		      @endif
		    </div><!-- /.box-body -->

            <div class="">

                @include('crud::inc.form_save_buttons')

		    </div><!-- /.box-footer-->
		  </div><!-- /.box -->
		  </form>
	</div>
</div>
@endsection
