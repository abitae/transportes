@extends('layouts.web.app')
@section('content')
  <div class="other-page-banner">
    <div class="other-page-banner-content">
        <h1 class="other-page-banner-head">Contacto</h1>
        <div class="other-page-banner-detail"><a class="c-1" href="{{ asset('/') }}">Inicio&nbsp;</a> /&nbsp; contacto
        </div>
    </div>
  </div>

  <div class="clearfix"></div>
  <section class="news-1 pt-120 pb-120">
    <div class="container pl-xs-15 pr-xs-15 pl-0 pr-0">
        <div class="section-head">
            <img src="img/section-sep-1.png" alt="">
            <h1 class="header-text" style="padding-bottom: 1rem">Enviamos un mensaje</h1>
            <p style="padding-bottom: 3rem">Tienes alguna duda o pregunta y no puedes contactar con nosotrsos ahora mismo. Dejanos saber, envianos un mensaje completando tus datos del formulario de abajo, para contactarnos contigo y atenderte lo más pronto posible</p>
        </div>
        <form action="javascript:;" class="quick-quote-form">
            <div class="pl-xs-0 pr-xs-0 col-sm-6 pr-0 pl-0 pr-sm-10">
              <input  type="text" class="input-placeholder quick-quote-name" placeholder="Nombres">
            </div>
            <div class="pl-xs-0 pr-xs-0 col-sm-6 pr-0 pr-sm-10">
              <input  type="email" class="input-placeholder quick-quote-name" placeholder="Email">
            </div>
            <div class="pl-xs-0 pr-xs-0 col-sm-6 pl-0 pr-0 pl-sm-10">
              <input  type="text" class="input-placeholder quick-quote-sub" placeholder="teléfono">
            </div>
            <div class="pl-xs-0 pr-xs-0 col-sm-6 pr-0 pl-sm-10">
              <input  type="text" class="input-placeholder quick-quote-sub" placeholder="Asunto">
            </div>
            <div class="pl-xs-0 pt-xs-20 pr-xs-0 pl-0 col-sm-12 pr-0 pl-sm-10">
              <textarea class="quick-quote-message input-placeholder" placeholder="Mensaje"></textarea>
            </div>
            <div class="clearfix"></div>
            <button type="submit" class="default-btn db mt-40">Enviar</button>
        </form>
    </div>
  </section>
  <!-- News end-->
  <div class="clearfix"></div>
  <!-- Map start-->
  <section class="map-2 pos-r">
    <div class="container-fluid pl-0 pr-0">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d7803.250997988284!2d-75.21500200186767!3d-12.069268182691411!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses-419!2spe!4v1595084650598!5m2!1ses-419!2spe"
            width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false"
            tabindex="0"></iframe>
        <div class="map-detail">
            <div class='map-detail-wrapper pos-r pt-40 pb-33 m-10 center'>
                <img src="{{ asset('frontend/img/logo-1.png') }}" alt=''>
                <p class='text pt-40 lh-10 center'>Telf. <span class='ff-b fz-16 c-3'>+51 970 795 188</span></p>
                <p class='text pt-20 lh-10 center'>Email <span class='ff-b fz-16 c-3'>info@brayanbrush.com</span></p>
                <p class='text pt-33'>Jr. Los Obreros 125 - La Victoria <br> Lima</p>
                <div class="map-detail-closer">x</div>
            </div>
        </div>
    </div>
  </section>
@endsection
