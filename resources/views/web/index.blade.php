@extends('layouts.web.app')
@section('styles')
  <style>
    .main-slider {
      background-image: url('frontend/img/header.png');
      height: 80vh;
      background-size: cover;
      background-position: center;
    }
    .header {
      display: flex;
      align-items: center;
      justify-content: center;
      height: inherit;
      padding-inline: 1rem;
    }
  </style>
@endsection
@section('content')
  <div class="main-slider">
    <div class="container" style="height: inherit;">
      <div class="header">
        <div class="col-sm-12 col-md-6 header-left">
          <h3 class="mb-1 text-white format-title">Nuestras Sucursales</h3>
          <div class="container-fluid list-branch-office">
            @foreach ($sucursales as $sucursal)
            <div class="row d-flex justify-content-start" style="padding: 0; padding-bottom: .5rem" >
              <div class="col-sm-12 col-md-10 col-lg-8">
                <div class="branch-office">
                  <div class="branch-office-icon">
                    <img src="{{ asset('frontend/img/branch-office.svg') }}" height="40px" alt="">
                  </div>
                  <div class="text-white branch-office-description" style="line-height: 1;">
                    <p class="select-all font-weight-bold text-uppercase">{{$sucursal->name}}</p>
                    <small style="color: #dfdfdf;" class="select-all">{{$sucursal->address}}</small>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
        <div class="col-sm-12 col-md-6 header-description">
          <h4 class="mb-0 text-white format-title">Bienvenidos a</h4>
          <h2 class="mb-0 text-white format-title">Brayan Brush</h2>
          <h5 class="text-white" style="margin-bottom: 3em;">Somos un empresa peruana que brinda servicio en el areá de de transporte y almacén, agenciamiento de envíos y transporte terráqueo interno.</h5>
          <a href="{{ route('servicios') }}" style="display: inline-block;margin-bottom: 1em;" class="rounded-lg button button-custom-success">Pedir cotización</a>
          <a href="{{ route('rotulo') }}"  style="display: inline-block;margin-bottom: 1em;" class="rounded-lg button button-custom-success"><i class="fas fa-print"></i> Descargar rótulo</a>
        </div>
      </div>
    </div>
  </div>

  <section class="pos-r" style="padding-block: 7rem;">
    <div class="container pl-0 pr-0 pl-xs-15 pr-xs-15">
        <div class="pl-0 pr-20 col-md-4 pb-sm-30 pl-sm-15 pr-sm-15">
            <div class="about-2-content">
                <div class="about-2-content-head" style="border-radius: 20px 20px 0 0;">
                    <i class="icon-engineer"></i>
                    <h5 class="lh-11 ff-b fz-16 center ls-25 text-up c-5">Staff de Profesionales</h5>
                </div>
                <a href="javascript:;">
                    <div class="about-2-content-img">
                      <img src="{{ asset('frontend/img/about/about-2.jpg') }}" alt="">
                    </div>
                </a>
                <div class="about-2-content-text" style="height: 120px; border-radius: 0 0 20px 20px;">
                    <p class="text">Contamos con un staff de profesionales en el rubro de Curier para que su envio este garantizado al 100% </p>
                </div>
            </div>
        </div>
        <div class="pl-10 pr-10 col-md-4 pb-sm-30 pl-sm-15 pr-sm-15">
            <div class="about-2-content">
                <div class="about-2-content-head" style="border-radius: 20px 20px 0 0;">
                    <i class="icon-planet-earth"></i>
                    <h5 class="lh-11 ff-b fz-16 center ls-25 text-up c-5">Sucursales en todo el Perú</h5>
                </div>
                <a href="javascript:;">
                    <div class="about-2-content-img">
                        <img src="{{ asset('frontend/img/about/about-3.jpg') }}" alt="">
                    </div>
                </a>
                <div class="about-2-content-text" style="height: 120px; border-radius: 0 0 20px 20px;">
                    <p class="text">Para su comodidad contamos con sucursales en todo el territorio Peruano</p>
                </div>
            </div>
        </div>
        <div class="pl-20 pr-0 col-md-4 pb-sm-30 pl-sm-15 pr-sm-15">
            <div class="about-2-content">
                <div class="about-2-content-head" style="border-radius: 20px 20px 0 0;">
                    <i class="icon-archive"></i>
                    <h5 class="lh-11 ff-b fz-16 center ls-25 text-up c-5">Almacenes</h5>
                </div>
                <a href="javascript:;">
                    <div class="about-2-content-img">
                        <img src="{{ asset('frontend/img/about/about-4.jpg') }}" alt="">
                    </div>
                </a>
                <div class="about-2-content-text" style="height: 120px; border-radius: 0 0 20px 20px;">
                    <p class="text">Contamos con almacenes que cuentan con todas la garantias para la seguridad
                        de su envio.</p>
                </div>
            </div>
        </div>
    </div>
  </section>

  <section class="news-1 pt-120 pb-120" id="rastreo_tracking">
    <div class="text-white col-12 mb-30">
      <h2 class="text-center">RASTREA TU PAQUETE</h2>
    </div>
    <div class="container-card-follow">
      <div class="col-12 col-md-3 card-follow-tracking" style="margin-inline: 1rem">
        <div class="quick-quote">
          <p class="text-white">Conoce dónde se encuentra tu paquete, ingrese el <b>CÓDIGO TRACKING</b> y <b>N° DNI/RUC</b> del destinatario, click en el botón de buscar y listo!</p>
          <form action="{{ route('search-tracking') }}" method="get" target="_blank">
            <div class="row">
              <div class="mb-10 col-12">
                  <input type="text"
                  class="rounded-sm quick-quote-name input-placeholder form-control"
                  name="codeTracking"
                  style="border-radius: 30px;"
                  placeholder="Código Tracking..."
                  autocomplete="codeTracking"
                  required>
              </div>
              <div class="mb-10 col-12">
                <input type="text"
                  class="rounded-sm input-placeholder form-control"
                  name="recipientDni"
                  style="border-radius: 30px;"
                  placeholder="N° DNI / RUC"
                  autocomplete="recipientDni"
                  required>
              </div>
            </div>
            <div class="text-center col-12">
              <button type="submit" class="rounded-sm button button-custom-success"><i class="fas fa-search"></i> Buscar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <section class="services-2 pt-140 pb-120">
      <div class="container pl-0 pr-0 pl-xs-15 pr-xs-15">
          <div class="pl-0 col-md-6 pr-33 services-2-left">
              <div class="services-2-left-content pos-r pt-80 pb-80">
                  <div class="section-head">
                      <img src="{{ asset('frontend/img/section-sep-1.png') }}" alt="">
                      <p class="header">Nuestros Servicios</p>
                      <h1 class="header-text">A su servicio</h1>
                  </div>
                  <p class="text c-3">Otorgamos flexibilidad y confiabilidad en sus procesos logisticos.
                  </p>
                  <p class="text services-2-left-text pb-33">Garantizamos una distribución eficiente de su
                      mercaderia.</p>
                  <a href="{{ route('servicios') }}" class="default-btn dib">Servicios</a>
                  <img src="{{ asset('frontend/img/services/services-7.png') }}" class="services-2-left-content-abs" alt="">
              </div>
          </div>
          <div class="pl-0 pr-0 col-md-6 services-2-right">
              <div class="pl-0 pr-0 col-sm-6 pb-100">
                  <div class="pr-0 col-xs-6 pl-xs-0 services-2-right-icon-1 center">
                      <i class="icon-airplane"></i>
                  </div>
                  <div class="pl-0 pr-0 col-xs-6">
                      <h4 class="pt-10 ff-n fz-14 text-up c-4 lh-10">Transporte</h4>
                  </div>
              </div>
              <div class="pl-0 pr-0 col-sm-6 pb-100">
                  <div class="pr-0 col-xs-6 pl-xs-0 services-2-right-icon-2 center">
                      <i class="icon-transport-1"></i>
                  </div>
                  <div class="pl-0 pr-0 col-xs-6">
                      <h4 class="pt-10 ff-n fz-14 text-up c-4 lh-10">Almacenamiento</h4>
                  </div>
              </div>
              <div class="pl-0 pr-0 col-sm-6 pb-100">
                  <div class="pr-0 col-xs-6 pl-xs-0 services-2-right-icon-1 center">
                      <i class="icon-transport-6"></i>
                  </div>
                  <div class="pl-0 pr-0 col-xs-6">
                      <h4 class="pt-10 ff-n fz-14 text-up c-4 lh-10">Logistica</h4>
                  </div>
              </div>
              <div class="pl-0 pr-0 col-sm-6 pb-100">
                  <div class="pr-0 col-xs-6 pl-xs-0 services-2-right-icon-2 center">
                      <i class="icon-package"></i>
                  </div>
                  <div class="pl-0 pr-0 col-xs-6">
                      <h4 class="pt-10 ff-n fz-14 text-up c-4 lh-10">cargo</h4>
                  </div>
              </div>
              <div class="pl-0 pr-0 col-sm-6 pb-xs-100">
                  <div class="pr-0 col-xs-6 pl-xs-0 services-2-right-icon-1 center">
                      <i class="icon-business"></i>
                  </div>
                  <div class="pl-0 pr-0 col-xs-6">
                      <h4 class="pt-10 ff-n fz-14 text-up c-4 lh-10">Paqueteria &amp; Almacenamiento</h4>
                  </div>
              </div>
              <div class="pl-0 pr-0 col-sm-6">
                  <div class="pr-0 col-xs-6 pl-xs-0 services-2-right-icon-2 center">
                      <i class="icon-box"></i>
                  </div>
                  <div class="pl-0 pr-0 col-xs-6">
                      <h4 class="pt-10 ff-n fz-14 text-up c-4 lh-10">Delivery</h4>
                  </div>
              </div>
          </div>
      </div>
  </section>

  <section class="about-1 pt-120 spb-1">
    <div class="container pl-0 pr-0 pl-xs-15 pr-xs-15">
      <div class="pl-0 pr-0 pt-sm-30 pl-xs-0 pr-xs-0 col-md-6 col-md-offset-1 about-1-right col-md-push-5">
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
      </div>

      <div class="pt-5 pl-0 pr-0 about-1-left pt-sm-30 pl-xs-0 pr-xs-0 col-md-5 col-md-pull-7">
        <div class="about-1-left-img">
          <img src="{{ asset('frontend/img/about/about-1.jpg') }}" alt="">
        </div>
        <div class="pt-40 about-1-left-content">
          <p class="text">“El precio del éxito es trabajo duro, dedicación y determinación en que, ganes o pierdas, habrás hecho todo lo que estaba en tus manos”</p>
        </div>
      </div>
    </div>
  </section>

  <section class="map-2 pos-r">
    <div class="pl-0 pr-0 container-fluid">
      {{-- <iframe src="" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe> --}}
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3901.770163561372!2d-77.02750948462534!3d-12.05932864541908!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105c8bc5a8c785f%3A0x63fa3a704615acea!2sCorporaci%C3%B3n%20Logistico%20Brayan%20Bruhs%20E.I.R.L.!5e0!3m2!1ses-419!2spe!4v1634226600765!5m2!1ses-419!2spe"
        width="100%"
        height="450"
        style="border:0;"
        allowfullscreen=""
        aria-hidden="false"
        loading="lazy">
      </iframe>
      <div class="map-detail">
        <div class='pt-40 m-10 map-detail-wrapper pos-r pb-33 center'>
          <img src="{{ asset('frontend/img/logo-1.png') }}" alt=''>
          <p class='pt-40 text lh-10 center'>Telf. <span class='ff-b fz-16 c-3'>+51 970 795 188</span></p>
          <p class='pt-20 text lh-10 center'>Email <span class='ff-b fz-16 c-3'>info@brayanbrush.com</span></p>
          <p class='text pt-33'>Jr. Los Obreros 125 - La Victoria Lima <br> La Victoria - Lima</p>
          <div class="map-detail-closer">x</div>
        </div>
      </div>
    </div>
  </section>
@endsection
