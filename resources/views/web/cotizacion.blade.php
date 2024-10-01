@extends('layouts.web.app')

@section('content')
  <div class="other-page-banner">
    <div class="other-page-banner-content">
        <h1 class="other-page-banner-head">Cotización para {{$title}}</h1>
        <div class="other-page-banner-detail"><a class="c-1" href="{{ asset('/') }}">Inicio&nbsp;</a> / &nbsp; Cotización
        </div>
    </div>
  </div>
  <div class="clearfix"></div>
  <div class="container separate-content">
    <quotation-component url-base="{{ asset('') }}"></quotation-component>
  </div>
@endsection

@section('scripts')

@endsection
