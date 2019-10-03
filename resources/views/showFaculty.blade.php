@extends('backpack::layout')

@section('header')

	<section class="content-header">
	  <h1>
        <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
        <small>{!! $crud->getSubheading() ?? mb_ucfirst(trans('backpack::crud.preview')).' '.$crud->entity_name !!}.</small>
      </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	    <li class="active">{{ trans('backpack::crud.preview') }}</li>
	  </ol>
	</section>
@endsection

@section('content')
@if ($crud->hasAccess('list'))
	<a href="{{ url($crud->route) }}" class="hidden-print"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a>

	<a href="javascript: window.print();" class="pull-right hidden-print"><i class="fa fa-print"></i></a>
@endif
<div class="row">
	<div class="{{ $crud->getShowContentClass() }}">

	<!-- Default box -->
	  <div class="m-t-20">
	  	@if ($crud->model->translationEnabled())
	    <div class="row">
	    	<div class="col-md-12 m-b-10">
				<!-- Change translation button group -->
				<div class="btn-group pull-right">
				  <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    {{trans('backpack::crud.language')}}: {{ $crud->model->getAvailableLocales()[$crud->request->input('locale')?$crud->request->input('locale'):App::getLocale()] }} &nbsp; <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">
				  	@foreach ($crud->model->getAvailableLocales() as $key => $locale)
					  	<li><a href="{{ url($crud->route.'/'.$entry->getKey()) }}?locale={{ $key }}">{{ $locale }}</a></li>
				  	@endforeach
				  </ul>
				</div>
			</div>
	    </div>
	    @else
	    @endif
	    <div class="box no-padding no-border">
			<table class="table table-striped">
		        <tbody>
		        @foreach ($crud->columns as $column)
		            <tr>
		                <td>
		                    <strong>{{ $column['label'] }}</strong>
		                </td>
                        <td>
							@if (!isset($column['type']))
		                      @include('crud::columns.text')
		                    @else
		                      @if(view()->exists('vendor.backpack.crud.columns.'.$column['type']))
		                        @include('vendor.backpack.crud.columns.'.$column['type'])
		                      @else
		                        @if(view()->exists('crud::columns.'.$column['type']))
		                          @include('crud::columns.'.$column['type'])
		                        @else
		                          @include('crud::columns.text')
		                        @endif
		                      @endif
		                    @endif
                        </td>
		            </tr>
		        @endforeach
				@if ($crud->buttons->where('stack', 'line')->count())
					<tr>
						<td><strong>{{ trans('backpack::crud.actions') }}</strong></td>
						<td>
							@include('crud::inc.button_stack', ['stack' => 'line'])
						</td>
					</tr>
				@endif
		        </tbody>
			</table>
	    </div>
	  </div>
	</div>



</div>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="">
        <div class="overflow-hidden">
        <table id="crudTable" class="box table table-striped table-hover display responsive nowrap m-t-0 dataTable dtr-inline" cellspacing="0">
            <thead>
              <tr>
                  <th
                    data-orderable="{{ var_export($column['orderable'], true) }}"
                    data-priority="{{ $column['priority'] }}"
                    data-visible-in-modal="{{ (isset($column['visibleInModal']) && $column['visibleInModal'] == false) ? 'false' : 'true' }}"
                    data-visible="{{ !isset($column['visibleInTable']) ? 'true' : (($column['visibleInTable'] == false) ? 'false' : 'true') }}"
                    data-visible-in-export="{{ (isset($column['visibleInExport']) && $column['visibleInExport'] == false) ? 'false' : 'true' }}"
                    >
                      Escuelas
                  </th>
                @if ( $crud->buttons->where('stack', 'line')->count() )
                  <th data-orderable="false" data-priority="{{ $crud->getActionsColumnPriority() }}" data-visible-in-export="false">{{ trans('backpack::crud.actions') }}</th>
                @endif
              </tr>
            </thead>
            <tbody>
                <tr>
                  @if (count($entry->school) > 0)
                  @foreach ($entry->school as $schools)
                     <tr>
                          <td><a href="{{ url('admin/school/'.$schools->id) }}">{{$schools->name}}</a></td>
                          <td>
                            <a href="{{ url('admin/school/'.$schools->id.'/edit?faculty_from='.$entry->getKey()) }}" class="btn btn-xs btn-default"><i class="fa fa-edit" title="{{ trans('backpack::crud.edit') }}"></i> editar</a>
                            @if (!in_array(backpack_user()->type_user, [2,3,4]))
                              <a href="javascript:void(0)" onclick="deleteEntry(this)" data-route="{{ url('admin/school/'.$schools->id) }}" class="btn btn-xs btn-default" data-button-type="delete"><i class="fa fa-trash"></i> Eliminar</a>
                            @endif
                          </td>
                     </tr>
                  @endforeach
                  @else
                      <td valign="top" colspan="2" class="dataTables_empty" style="text-align:center">No hay Escuelas disponibles para esta Facultad</td>
                  @endif

              </tr>
            </tbody>
            <tfoot>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>

@endsection


@section('after_styles')
	<link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/crud.css') }}">
	<link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/show.css') }}">
@endsection

@section('after_scripts')
	<script src="{{ asset('vendor/backpack/crud/js/crud.js') }}"></script>
	<script src="{{ asset('vendor/backpack/crud/js/show.js') }}"></script>
@endsection

@push('after_scripts')
<script>
  console.log("si agregue el eliminar");
	if (typeof deleteEntry != 'function') {
	  $("[data-button-type=delete]").unbind('click');
	  function deleteEntry(button) {
	      var button = $(button);
	      var route = button.attr('data-route');
	      var row = $("#crudTable a[data-route='"+route+"']").closest('tr');
	      if (confirm("{{ trans('backpack::crud.delete_confirm') }}") == true) {
	          $.ajax({
	              url: route,
	              type: 'DELETE',
	              success: function(result) {
	                  new PNotify({
	                      title: "{{ trans('backpack::crud.delete_confirmation_title') }}",
	                      text: "{{ trans('backpack::crud.delete_confirmation_message') }}",
	                      type: "success"
	                  });
	                  $('.modal').modal('hide');
	                  if (row.hasClass("shown")) {
	                      row.next().remove();
	                  }
	                  row.remove();
	              },
	              error: function(result) {
	                  // Show an alert with the result
	                  new PNotify({
	                      title: "{{ trans('backpack::crud.delete_confirmation_not_title') }}",
	                      text: "{{ trans('backpack::crud.delete_confirmation_not_message') }}",
	                      type: "warning"
	                  });
	              }
	          });
	      } else {
	          new PNotify({
	              title: "{{ trans('backpack::crud.delete_confirmation_not_deleted_title') }}",
	              text: "{{ trans('backpack::crud.delete_confirmation_not_deleted_message') }}",
	              type: "info"
	          });
	      }
      }
	}
</script>
@endpush
