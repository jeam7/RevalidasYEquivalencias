<div class="box">
    <div class="box-body box-profile">
      @php
        $placeholder = 'https://placehold.it/160x160/00a65a/ffffff/&text='.backpack_user()->first_name[0];
      @endphp
	    <img class="profile-user-img img-responsive img-circle" src="{{ $placeholder }}">
	    <h3 class="profile-username text-center">{{ backpack_user()->first_name ." ". backpack_user()->last_name}}</h3>
	</div>

	<ul class="nav nav-pills nav-stacked">

	  <li role="presentation"
		@if (Request::route()->getName() == 'backpack.account.info')
	  	class="active"
	  	@endif
	  	><a href="{{ route('backpack.account.info') }}">{{ trans('backpack::base.update_account_info') }}</a></li>

	  <li role="presentation"
		@if (Request::route()->getName() == 'backpack.account.password')
	  	class="active"
	  	@endif
	  	><a href="{{ route('backpack.account.password') }}">{{ trans('backpack::base.change_password') }}</a></li>

	</ul>
</div>
