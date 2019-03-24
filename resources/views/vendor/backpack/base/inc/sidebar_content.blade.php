<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>

@if (backpack_user()->type_user == 4)
  <li><a href='{{ backpack_url('myrequest') }}'><i class='fa fa-tag'></i> <span>Mis Solicitudes</span></a></li>
@elseif (backpack_user()->type_user == 3)
  <li class="header">Solicitudes / Comprobantes</li>
  <li><a href='{{ backpack_url('request') }}'><i class='fa fa-tag'></i> <span>Solicitudes</span></a></li>
  <li><a href='{{ backpack_url('voucher') }}'><i class='fa fa-tag'></i> <span>Comprobantes</span></a></li>
  <li class="header">Universidades / Institutos </li>
  <li><a href='{{ backpack_url('college') }}'><i class='fa fa-tag'></i> <span>Universidades</span></a></li>
  <li><a href='{{ backpack_url('faculty') }}'><i class='fa fa-tag'></i> <span>Facultades</span></a></li>
  <li><a href='{{ backpack_url('school') }}'><i class='fa fa-tag'></i> <span>Escuelas</span></a></li>
  <li><a href='{{ backpack_url('career') }}'><i class='fa fa-tag'></i> <span>Carreras</span></a></li>
  <li><a href='{{ backpack_url('subject') }}'><i class='fa fa-tag'></i> <span>Asignaturas</span></a></li>
  <li class="header">Administracion de usuarios</li>
  <li><a href='{{ backpack_url('user') }}'><i class='fa fa-tag'></i> <span>Usuarios</span></a></li>
@elseif (backpack_user()->type_user == 2)
  <li class="header">Solicitudes / Comprobantes</li>
  <li><a href='{{ backpack_url('request') }}'><i class='fa fa-tag'></i> <span>Solicitudes</span></a></li>
  <li><a href='{{ backpack_url('voucher') }}'><i class='fa fa-tag'></i> <span>Comprobantes</span></a></li>
  <li class="header">Universidades / Institutos </li>
  <li><a href='{{ backpack_url('college') }}'><i class='fa fa-tag'></i> <span>Universidades</span></a></li>
  <li><a href='{{ backpack_url('faculty') }}'><i class='fa fa-tag'></i> <span>Facultades</span></a></li>
  <li><a href='{{ backpack_url('school') }}'><i class='fa fa-tag'></i> <span>Escuelas</span></a></li>
  <li><a href='{{ backpack_url('career') }}'><i class='fa fa-tag'></i> <span>Carreras</span></a></li>
  <li><a href='{{ backpack_url('subject') }}'><i class='fa fa-tag'></i> <span>Asignaturas</span></a></li>
  <li><a href='{{ backpack_url('academic_period') }}'><i class='fa fa-tag'></i> <span>Periodo Academico</span></a></li>
  <li class="header">Administracion de usuarios</li>
  <li><a href='{{ backpack_url('user') }}'><i class='fa fa-tag'></i> <span>Usuarios</span></a></li>
@elseif (backpack_user()->type_user == 1)
  <li class="header">Solicitudes / Comprobantes</li>
  <li><a href='{{ backpack_url('request') }}'><i class='fa fa-tag'></i> <span>Solicitudes</span></a></li>
  <li><a href='{{ backpack_url('voucher') }}'><i class='fa fa-tag'></i> <span>Comprobantes</span></a></li>
  <li class="header">Universidades / Institutos </li>
  <li><a href='{{ backpack_url('college') }}'><i class='fa fa-tag'></i> <span>Universidades</span></a></li>
  <li><a href='{{ backpack_url('faculty') }}'><i class='fa fa-tag'></i> <span>Facultades</span></a></li>
  <li><a href='{{ backpack_url('school') }}'><i class='fa fa-tag'></i> <span>Escuelas</span></a></li>
  <li><a href='{{ backpack_url('career') }}'><i class='fa fa-tag'></i> <span>Carreras</span></a></li>
  <li><a href='{{ backpack_url('subject') }}'><i class='fa fa-tag'></i> <span>Asignaturas</span></a></li>
  <li><a href='{{ backpack_url('academic_period') }}'><i class='fa fa-tag'></i> <span>Periodo Academico</span></a></li>
  <li class="header">Administracion de usuarios</li>
  <li><a href='{{ backpack_url('user') }}'><i class='fa fa-tag'></i> <span>Usuarios</span></a></li>
@endif

{{-- @if (backpack_user()->type_user == 1)
  <li class="header">Solicitudes / Comprobantes</li>
  <li><a href='{{ backpack_url('request') }}'><i class='fa fa-tag'></i> <span>Solicitudes</span></a></li>
  <li><a href='{{ backpack_url('voucher') }}'><i class='fa fa-tag'></i> <span>Comprobantes</span></a></li>
  <li class="header">Universidades / Institutos </li>
  <li><a href='{{ backpack_url('college') }}'><i class='fa fa-tag'></i> <span>Universidades</span></a></li>
  <li><a href='{{ backpack_url('faculty') }}'><i class='fa fa-tag'></i> <span>Facultades</span></a></li>
  <li><a href='{{ backpack_url('school') }}'><i class='fa fa-tag'></i> <span>Escuelas</span></a></li>
  <li><a href='{{ backpack_url('career') }}'><i class='fa fa-tag'></i> <span>Carreras</span></a></li>
  <li><a href='{{ backpack_url('subject') }}'><i class='fa fa-tag'></i> <span>Asignaturas</span></a></li>
  <li><a href='{{ backpack_url('academic_period') }}'><i class='fa fa-tag'></i> <span>Periodo Academico</span></a></li>
  <li class="header">Administracion de usuarios</li>
  <li><a href='{{ backpack_url('user') }}'><i class='fa fa-tag'></i> <span>Usuarios</span></a></li>
@endif --}}
