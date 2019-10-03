<header class="main-header">
  <!-- Logo -->
  <a href="{{ url('') }}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <div class="" style="display:flex">
      <span class="logo-mini">{!! config('backpack.base.logo_mini') !!}</span>
    </div>
    <!-- logo for regular state and mobile devices -->
    <div class="" style="display:flex">
      <img style="max-height:50px;" src="/images/logo-secretaria-login.png" alt="ReválidayEquivalencias">
      <span class="logo-lg" style="font-size: 12px; margin-left:10px">Revalidas y Equivalencias</span>
    </div>

  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">{{ trans('backpack::base.toggle_navigation') }}</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </a>

    @include('backpack::inc.menu')
  </nav>
</header>
