@extends('backpack::layout_guest')

<!-- Main Content -->
@section('content')
    <div class="row m-t-40">
        <div class="col-md-4 col-md-offset-4" style="display: flex">
          <img src="<?php echo e(url('images/logo-secretaria-login.png')); ?>" style="width: 100%; max-width: 200px; display: block; margin: 10px auto;">
          <h2 class="text-center m-t-80">Reválida y Equivalencias</h2>
          <img src="<?php echo e(url('images/logo-ucv-login.png')); ?>" style="width: 100%; max-width: 200px; display: block; margin: 10px auto;">
        </div>
        <div class="col-md-4 col-md-offset-4">
            <h3 class="text-center m-b-20">Registro de Usuario</h3>
            <div class="nav-tabs-custom">
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                        <div class="alert alert-success">
                              Correo de registro de Usuario enviado exitosamente
                        </div>
                    <div class="clearfix"></div>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div>

              <div class="text-center m-t-10">
                <a href="{{ route('backpack.auth.login') }}">{{ trans('backpack::base.login') }}</a>
              </div>
        </div>
    </div>
@endsection
