@extends('layouts.web.app')

@section('content')
  <div class="other-page-banner">
    <div class="other-page-banner-content">
        <h1 class="other-page-banner-head">Libro de reclamaciones</h1>
        <div class="other-page-banner-detail"><a class="c-1" href="{{ asset('/') }}">Inicio&nbsp;</a> / &nbsp;Libro de reclamaciones
        </div>
    </div>
  </div>
  <div class="container separate-content">
    <complaints-book-component url-base="{{ asset('') }}"></complaints-book-component>
  </div>
@endsection
