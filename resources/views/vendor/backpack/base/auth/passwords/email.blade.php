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
            <h3 class="text-center m-b-20">{{ trans('backpack::base.reset_password') }}</h3>
            <div class="nav-steps-wrapper">
                <ul class="nav nav-tabs nav-steps">
                  <li class="active"><a href="#tab_1" data-toggle="tab"><strong style="color:white; background-color:#161966">Paso 1</strong> {{ trans('backpack::base.confirm_email') }}</a></li>
                  <li><a class="disabled text-muted"><strong style="background-color:white">Paso 2</strong> {{ trans('backpack::base.choose_new_password') }}</a></li>
                </ul>
            </div>
            <div class="nav-tabs-custom">
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                    @if (session('status'))
                        <div class="alert alert-success">
                            @if (session('status') == 'passwords.sent')
                              Correo de recuperación de contraseña enviado exitosamente
                            @endif
                            {{-- {{ session('status') }} --}}
                        </div>
                    @else
                    <form class="col-md-12 p-t-10" role="form" method="POST" action="{{ route('backpack.auth.password.email') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="control-label">{{ trans('backpack::base.email_address') }}</label>

                            <div>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>
                                          @if ($errors->first('email') == 'passwords.user')
                                              Correo ingresado invalido
                                          @endif
                                          {{-- {{ $errors->first('email') }} --}}
                                        </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-block btn-primary">
                                    {{ trans('backpack::base.send_reset_link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    @endif
                    <div class="clearfix"></div>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div>

              <div class="text-center m-t-10">
                <a href="{{ route('backpack.auth.login') }}">{{ trans('backpack::base.login') }}</a>

                @if (config('backpack.base.registration_open'))
                / <a href="{{ route('backpack.auth.register') }}">{{ trans('backpack::base.register') }}</a>
                @endif
              </div>
        </div>
    </div>
@endsection
