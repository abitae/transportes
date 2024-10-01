@php
  use Carbon\Carbon;
  function isCompleted($state,$currentState) {
    if($state > $currentState) {
      return "disabled";
    }
  }
@endphp
@extends('layouts.web.app')

@section('content')
  <div class="other-page-banner">
    <div class="other-page-banner-content">
        <h1 class="other-page-banner-head">Búsqueda de paquete</h1>
        <div class="other-page-banner-detail"><a class="c-1" href="{{ asset('/') }}">Inicio&nbsp;</a> / &nbsp; Paquete
        </div>
    </div>
  </div>
  <div class="clearfix"></div>
  <div class="container c-wrapper">

    <div class="row">
      <div class="col-12 col-md-3">
        <div class="card">
          <h4>Fecha de registro</h4>
          <h5>{{ Carbon::parse($shipment->created_at) }}</h5>
          <i class="far fa-calendar-alt fa-4x"></i>
        </div>
      </div>
      <div class="col-12 col-md-3">
        <div class="card">
          <h4>Fecha de Entrega</h4>
          <h5>{{ Carbon::parse($shipment->fecha) }}</h5>
          <i class="far fa-calendar-alt fa-4x"></i>
        </div>
      </div>
      <div class="col-12 col-md-3">
        <div class="card">
          <h4>Sucursal origen</h4>
          <h5>{{$shipment->sucursal_remitente->name}}</h5>
          <i class="fas fa-university fa-4x"></i>
        </div>
      </div>
      <div class="col-12 col-md-3">
        <div class="card">
          <h4>Sucursal destino</h4>
          <h5>{{$shipment->sucursal_destinatario->name}}</h5>
          <i class="fas fa-university fa-4x"></i>
        </div>
      </div>
    </div>

    <h2 class="text-center title-color">Estado de paquete "<span class="cursor-pointer select-all">{{$shipment->id_generado}}</span>"</h2>
    <hr>
    <div class="row">
      <div class="col-12 col-md-3">
        <div class="package-status">
          <img class="{{ isCompleted(1,$shipment->estado) }} pb-1" src="{{ asset('frontend/img/icon-status/package-checked.svg') }}" alt="Imagen registrada">
          <h5 class="{{ isCompleted(1,$shipment->estado) }}">Registrado</h5>
        </div>
      </div>
      <div class="col-12 col-md-3">
        <div class="package-status">
          <img class="{{ isCompleted(2,$shipment->estado) }} pb-1" src="{{ asset('frontend/img/icon-status/package-in-route.svg') }}" alt="Imagen en ruta">
          <h5 class="{{ isCompleted(2,$shipment->estado) }}">En ruta</h5>
        </div>
      </div>
      <div class="col-12 col-md-3">
        <div class="package-status">
          <img class="{{ isCompleted(3,$shipment->estado) }} pb-1" src="{{ asset('frontend/img/icon-status/package-in-warehouse.svg') }}" alt="Imagen en almacen">
          <h5 class="{{ isCompleted(3,$shipment->estado) }}">Por recoger</h5>
        </div>
      </div>
      <div class="col-12 col-md-3">
        <div class="package-status">
          <img class="{{ isCompleted(4,$shipment->estado) }} pb-1" src="{{ asset('frontend/img/icon-status/package-delivered.svg') }}" alt="Imagen de paquete entregado">
          <h5 class="{{ isCompleted(4,$shipment->estado) }}">Entregado</h5>
        </div>
      </div>
    </div>
  </div>
@endsection
