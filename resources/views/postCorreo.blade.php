@extends('backpack::layout_guest')

@section('content')
    <div class="row m-t-40">
        <div class="col-md-4 col-md-offset-4" style="display: flex">
          <img src="<?php echo e(url('images/logo-secretaria-login.png')); ?>" style="width: 100%; max-width: 200px; display: block; margin: 10px auto;">
          <h2 class="text-center m-t-80">Reválida y Equivalencias</h2>
          <img src="<?php echo e(url('images/logo-ucv-login.png')); ?>" style="width: 100%; max-width: 200px; display: block; margin: 10px auto;">
        </div>
        <div class="col-md-4 col-md-offset-4">
            <h3 class="text-center m-b-20">Registro de usuario</h3>
            <div class="box">
                <div class="box-body">
                    <form class="col-md-12 p-t-10" role="form" method="POST" action="{{ url('/admin/registerStep2') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has(backpack_authentication_column()) ? ' has-error' : '' }}">
                            <label class="control-label">{{ config('backpack.base.authentication_column_name') }}</label>
                            <div>
                                <input type="{{ backpack_authentication_column()=='email'?'email':'text'}}" class="form-control" name="{{ backpack_authentication_column() }}" value="{{ $ci ?? old('ci') }}" readonly>

                                @if ($errors->has(backpack_authentication_column()))
                                    <span class="help-block">
                                        <strong>{{ $errors->first(backpack_authentication_column()) }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label class="control-label">Nombre</label>
                            <div>
                                <input type="text" class="form-control" name="first_name" value="{{ $first_name ?? old('first_name') }}" readonly>

                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label class="control-label">Apellido</label>
                            <div>
                                <input type="text" class="form-control" name="last_name" value="{{ $last_name ?? old('last_name') }}" readonly>

                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('place_birth') ? ' has-error' : '' }}">
                            <label class="control-label">Lugar de nacimiento</label>
                            <div>
                                <input type="text" class="form-control" name="place_birth" value="{{ old('place_birth') }}">

                                @if ($errors->has('place_birth'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('place_birth') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('nacionality') ? ' has-error' : '' }}">
                            <label class="control-label">Nacionalidad</label>
                            <div>
                                <select class="form-control" name="nacionality">
                                  <option value="v" selected>Venezolano</option>
                                  <option value="e">Extranjero</option>
                                </select>
                                @if ($errors->has('nacionality'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nacionality') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('birthdate') ? ' has-error' : '' }}">
                            <label class="control-label">Fecha de nacimiento</label>
                            <div>
                                <input type="date" class="form-control" name="birthdate" value="{{ old('birthdate') }}">

                                @if ($errors->has('birthdate'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('birthdate') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                            <label class="control-label">Género</label>
                            <div>
                                <select class="form-control" name="gender">
                                  <option value="f" selected>Femenino</option>
                                  <option value="m">Masculino</option>
                                </select>
                                @if ($errors->has('gender'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            <label class="control-label">Dirección</label>
                            <div>
                                <input type="text" class="form-control" name="address" value="{{ old('address') }}">
                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label class="control-label">Teléfono</label>
                            <div>
                                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="control-label">Correo</label>
                            <div>
                                <input type="text" class="form-control" name="email" value="{{ $email ?? old('email') }}" readonly>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="control-label">{{ trans('backpack::base.password') }}</label>
                            <div>
                                <input type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label class="control-label">{{ trans('backpack::base.confirm_password') }}</label>
                            <div>
                                <input type="password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-block btn-primary">
                                    Registrar Usuario
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
