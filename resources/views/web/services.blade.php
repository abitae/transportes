@extends('layouts.web.app')

@section('content')
  <div class="other-page-banner">
    <div class="other-page-banner-content">
        <h1 class="other-page-banner-head">Servicio</h1>
        <div class="other-page-banner-detail"><a class="c-1" href="{{ asset('/') }}">Inicio&nbsp;</a> / &nbsp; Servicio
        </div>
    </div>
  </div>
  <div class="clearfix"></div>
  <section class="services-3" >
    <div class="container pl-xs-15 pr-xs-15 pl-0 pr-0" style="margin-top: 2em;">
        <div class="section-head center">
            <img src="{{ asset('frontend/img/section-sep-2.png') }}" alt="">
            <p class="header center">Cotización</p>
            <h1 class="header-text center">Pida su cotización</h1>
        </div>
        <!-- services-3 1st row-->
        <div class="services-3-content pl-sm-0 pr-sm-0 col-md-4 pl-0 pr-20" style="">
            <div class="services-3-content-in text-center" style="padding-block: 3rem;">
              <h3 class="title-color format-title">Personas</h3>
              <img src="{{ asset('frontend/services/persona.svg') }}" alt="" style="height: 150px;margin-bottom: 2rem;">
              <a href="{{ route('cotizacion', ['view' => 'persona']) }}" class="button button-custom-success rounded-lg d-inline-block"><i class="far fa-file-alt"></i> Emprende</a>
            </div>
        </div>
        <div class="services-3-content pl-sm-0 pr-sm-0 col-md-4 pl-10 pr-10">
            <div class="services-3-content-in text-center" style="padding-block: 3rem;">
              <h3 class="title-color format-title">Empresas</h3>
              <img src="{{ asset('frontend/services/empresa.svg') }}" alt="" style="height: 150px;margin-bottom: 2rem;">
              <a href="{{ route('cotizacion', ['view' => 'empresa']) }}" class="button button-custom-success rounded-lg d-inline-block"><i class="far fa-file-alt"></i> Envía y crece</a>
            </div>
        </div>
        <div class="services-3-content pl-sm-0 pr-sm-0 col-md-4 pl-20 pr-0">
            <div class="services-3-content-in text-center" style="padding-block: 3rem;">
              <h3 class="title-color format-title">Mudanza</h3>
              <img src="{{ asset('frontend/services/mudanza.svg') }}" alt="" style="height: 150px;margin-bottom: 2rem;">
              <a href="{{ route('cotizacion', ['view' => 'mudanza']) }}" class="button button-custom-success rounded-lg d-inline-block"><i class="far fa-file-alt"></i> Lo llevamos</a>
            </div>
        </div>
    </div>
  </section>

  <div class="clearfix mb-2"></div>
  <section class="services-3">
    <div class="container pl-xs-15 pr-xs-15 pl-0 pr-0">
        <div class="section-head center">
            <img src="{{ asset('frontend/img/section-sep-2.png') }}" alt="">
            <p class="header text-center">Lo que podemos podemos hacer por usted</p>
        </div>

        <div class="services-3-content col-sm-12 col-md-4 col-lg-2">
            <div class="item-service mb-2 rounded-md">
                <img src="{{ asset('frontend/img/services/services-1.png') }}" alt="">
                <small>Transporte</small>
            </div>
        </div>
        <div class="services-3-content col-sm-12 col-md-4 col-lg-2">
            <div class="item-service mb-2 rounded-md">
                <img src="{{ asset('frontend/img/services/services-2.png') }}" alt="">
                <small>Logística</small>
            </div>
        </div>
        <div class="services-3-content col-sm-12 col-md-4 col-lg-2">
            <div class="item-service mb-2 rounded-md">
                <img src="{{ asset('frontend/img/services/services-3.png') }}" alt="">
                <small>Paquetería & almacenamiento</small>
            </div>
        </div>
        <!-- services-3 2nd row-->
        <div class="services-3-content col-sm-12 col-md-4 col-lg-2">
            <div class="item-service mb-2 rounded-md">
                <img src="{{ asset('frontend/img/services/services-4.png') }}" alt="">
                <small>Almacen</small>
            </div>
        </div>
        <div class="services-3-content col-sm-12 col-md-4 col-lg-2">
            <div class="item-service mb-2 rounded-md">
                <img src="{{ asset('frontend/img/services/services-5.png') }}" alt="">
                <small>Cargo</small>
            </div>
        </div>
        <div class="services-3-content col-sm-12 col-md-4 col-lg-2">
            <div class="item-service mb-2 rounded-md">
                <img src="{{ asset('frontend/img/services/services-6.png') }}" alt="">
                <small>Delivery puerta a puerta</small>
            </div>
        </div>
    </div>
  </section>

  <div class="other-page-banner">
    <div class="other-page-banner-content">
        <h1 class="other-page-banner-head">Nosotros</h1>
        </div>
    </div>
  </div>
  <div class="clearfix"></div>
  <section class="about-1 spb-1">
    <div class="container pl-xs-15 pr-xs-15 pl-0 pr-0" style="margin-top: 2em;">
        <div class="pt-sm-30 pl-xs-0 pr-xs-0 col-md-6 pt-sm-30 pl-xs-0 pr-xs-0 col-md-offset-1 pl-0 pr-0 about-1-right col-md-push-5">
            <div class="section-head">
              <img src="{{ asset('frontend/img/section-sep-1.png') }}" alt="">
              <p class="header">Nuestra Empresa</p>
              <h1 class="header-text">Nuestras Fortalezas</h1>
            </div>
            <div class="about-1-right-content pl-60">
              <div class="about-1-right-content-item">
                <i class="icon-engineer"></i>
                <h2 class="section-sub-head c-3">El mejor Equipo</h2>
              </div>
              <div class="about-1-right-content-item">
                <i class="icon-planet-earth"></i>
                <h2 class="section-sub-head c-3">Sucursales</h2>
              </div>
              <div class="about-1-right-content-item">
                <i class="icon-archive"></i>
                <h2 class="section-sub-head c-3">Almacenes</h2>
              </div>
            </div>
            <div class="about-1-right-content-item">
                <h2 class="section-sub-head c-3">GERENTE GENERAL
                </h2>
                <h4>Hernan Martinez Cristobal</h4>
                <p>964 488 021</p>
                <p>922 417 769</p>
            </div>
            <br>
            <div class="about-1-right-content-item">
                <h2 class="section-sub-head c-3">GERENTE LOGÍSTICO
                </h2>
                <h4>BRAYAN MARTINEZ CHUCO </h4>
                <p>970 795 188</p>
                <p>998 313 642</p>
            </div>
            <br>

            <div class="about-1-right-content-item">
                <h2 class="section-sub-head c-3">OFICINA HUANCAYO
                </h2>
                <h4>MARIA ELENA CHUCO ARTEZANO</h4>
                <p>975 724 414</p>
                <p>914 389 081</p>
            </div>

            <br>
            <div class="about-1-right-content-item">
                <h2 class="section-sub-head c-3">OFICINA HUANCAVELICA
                </h2>
                <h4>RAQUEL ELENA ZERPA MALPICA </h4>
                <p>970795896</p>
                <p>922 417 769</p>
            </div>
            <br>
            <div class="about-1-right-content-item">
                <h2 class="section-sub-head c-3">OFICINA LIMA
                </h2>
                <p>013867341</p>
                <p>970 794 881</p>
            </div>


        </div>
        <!-- About-left-->
        <div class="about-1-left pt-sm-30 pl-xs-0 pr-xs-0 col-md-5 pt-5 pl-0 pr-0 col-md-pull-7">
            <div class="about-1-left-img">
                <img src="{{ asset('frontend/img/about/about-1.jpg') }}" alt="">
            </div>
            <div class="about-1-left-content pt-40" style="width: 100%;">
                <p class="text">Nuestro Equipo, incluso de valer con los conocimientos obtenidos por su destreza
                    académica y profesional, tienen importantes logros que demuestran su interés y potencial en las
                    áreas de transporte y almacén, agenciamiento de envíos y transporte terráqueo interno.
                    Somos un empresa joven con nuevas propuestas y nuevas ideas, estamos comprometidos con sacar a
                    nuestro Peru adelante mediante proyectos integrales, que apoyen a la economía, al desarrollo
                    regional y contribuyan a disminuir el cambio climático.
                </p>


            </div>

        </div>
    </div>
</section>
@endsection
