<div class="user-panel">
  <a class="pull-left image" href="{{ route('backpack.account.info') }}">
    @php
      $placeholder = 'https://placehold.it/160x160/00a65a/ffffff/&text='.backpack_user()->first_name[0];
    @endphp
    <img src="{{ $placeholder }}" class="img-circle" alt="User Image">
  </a>
  <div class="pull-left info">
    <p><a href="{{ route('backpack.account.info') }}">{{ backpack_user()->first_name }}</a></p>
    <small><small><a href="{{ route('backpack.account.info') }}"><span><i class="fa fa-user-circle-o"></i> {{ trans('backpack::base.my_account') }}</span></a> &nbsp;  &nbsp; <a href="{{ backpack_url('logout') }}"><i class="fa fa-sign-out"></i> <span>{{ trans('backpack::base.logout') }}</span></a></small></small>
  </div>
</div>
