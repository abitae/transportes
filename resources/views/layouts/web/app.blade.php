@php
  function addActiveClass($link) {
    if(str_contains($link, Request::path())) return 'active';
  }
@endphp
<!doctype html>
<html lang="es" style="scroll-behavior: smooth;">
<head>
  <meta charset="utf-8">
  <title>Brayan Brush | Corporación Logística</title>
  <meta name="end-point" content="https://brayanbruhs.pe/"/>
  <link href="{{ asset('frontend/css/bootstrap.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/css/revolution-slider.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/css/font-awesome.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/css/owl.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/style.css') }}" rel="stylesheet">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link href="{{ asset('frontend/css/bootstrap-margin-padding.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/css/responsive.css') }}" rel="stylesheet">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('frontend/icono.ico') }}">
  <link rel="icon" type="image/png" href="{{ asset('frontend/icono.ico') }}" sizes="32x32">
  <link rel="stylesheet" href="{{ asset('frontend/css/general-style.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="{{ asset("vendor/fontawesome-free/css/all.min.css") }}" rel="stylesheet" type="text/css">
  @yield('styles')
  <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
    <div class="main-wrapper" id="app">

      <div class="socials-contact" id="socials-contact">
        <button class="icon" onclick="chatHandleClick()" title="Contactar" id="contact-icon"><i class="far fa-comment-dots"></i> </button>
        <div class="list-contact">
          <a href="https://api.whatsapp.com/send?phone=+51970795188&text=Quiero información sobre sus servicios" target="_blank" class="contact-item">
            <img class="icon-contact" src="{{ asset('frontend/images/whatsapp.png') }}" alt="Logo whatsapp">
            <div class="description">
              <b class="d-block">Whatsapp</b>
              <small>Contacto con Brayan Brush</small>
            </div>
          </a>
          <a href="http://m.me/108646774085241" target="_blank" class="contact-item">
            <img class="icon-contact" src="{{ asset('frontend/images/messenger.png') }}" alt="Logo de Messengar">
            <div class="description">
              <b class="d-block">Messenger</b>
              <small>Contacto con Brayan Brush</small>
            </div>
          </a>
        </div>
      </div>

        <div class="clearfix"></div>

        <nav class="nav-2 stricky">
          <div class="container pl-xs-15 pr-xs-15 pl-0 pr-0">
            <div class="fl logo-wrapper">
              <a href="{{ url('/') }}"><img src="{{ asset('frontend/img/logo-1.png') }}" alt="" class="logo"></a>
            </div>
            <div class="fr hidden-bar-opener pt-40 pb-40">
              <i class="fa fa-bars"></i>
            </div>
            <div class="fr nav-itm-wrapper">
              <ul>
                <li class="dib"><a href="{{ asset('/') }}" class="db {{ Request::path() == '/' ? 'active' : '' }}">Inicio</a></li>
                <li class="dib"><a href="{{ route('servicios') }}" class="db {{addActiveClass('servicios')}}">Servicios</a></li>
                <li class="dib"><a href="{{ route('contacto') }}" class="db {{addActiveClass('contacto')}}">Contacto</a></li>
                {{-- <li class="dib"><a href="javascript:;" class="db {{addActiveClass('inicio')}}">Agencias</a></li> --}}
              </ul>
            </div>
          </div>
        </nav>

        @yield('content')

        <div class="clearfix"></div>


        <footer class="footer-2 pt-80">
          <div class="container text-white">
            <div class="row">
              <form class="col-sm-12 col-md-8" action="javascript:;" onsubmit="subscribe()">
                <div class="row pb-0">
                  <div class="col-sm-12">
                    <h3 class="format-title">Boletón de noticias</h3>
                  </div>
                </div>
                <div class="row d-flex pt-0">
                  <div class="col-sm-8 col-md-10" style="padding-right: 0">
                    <input type="email" placeholder="Correo electronico..." id="email-subscribe" autocomplete="email" class="form-control input-placeholder"
                    style="border-radius: 30px 0 0 30px;">
                  </div>
                  <div class="col-sm-4 col-md-2" style="padding-left: 0">
                    <button type="submit" class="button btn-block btn-sm button-custom-success"
                    style="border-radius: 0 30px 30px 0;">Suscribirme</button>
                  </div>
                </div>
              </form>
              <div class="col-sm-12 col-md-4">
                <a href="{{ route('libro-de-reclamaciones') }}" class="container-claim-book">
                  <img src="{{ asset('frontend/book.svg') }}" alt="Libro de reclamción">
                  <h5>Libro de reclamos</h5>
                </a>
              </div>
            </div>
            <div class="row pb-0 pt-0">
              <div class="col-sm-12 pb-0 pt-0">
                <hr>
              </div>
              <div class="col-sm-12">
                <h3 class="text-center">Redes Sociales</h3>
              </div>
            </div>
            <div class="row list-socials">
              <a href="https://www.facebook.com/BrayanBrushTransporte" class="text-white item-social"><i class="fab fa-facebook-f"></i></a>
              {{-- <a href="javascript:;" class="text-white item-social"><i class="fab fa-twitter"></i></a> --}}
              <a href="https://www.instagram.com/brayan_brush/" class="text-white item-social"><i class="fab fa-instagram"></i></a>
            </div>
          </div>
          <div class="separator"></div>
          <p class="text-center text-white" style="padding-block: 2rem;">Copyright &copy; {{ now()->format('Y') }} <a href="{{ url('/') }}" class="c-5"><b>Brayan Brush</b></a> Todos los derechos reservados</p>
        </footer>

        <div class="clearfix"></div>

        <button class="scroll-to-top"><span class="fa fa-angle-up"></span></button>

        <div class="clearfix"></div>

        <div class="hidden-bar anim-5">
          <div class="hidden-bar-closer">
            <button class="btn">
              <i class="fa fa-close"></i>
            </button>
          </div>
          <div class="hidden-bar-wrapper">
            <div class="logo text-center" style="padding-bottom: 1rem">
              <a href="{{ asset('/') }}">
                <img src="{{ asset('frontend/img/logo-1.png') }}" alt="">
              </a>
            </div>
            <div class="main-menu text-center">
              <ul class="navigation clearfix">
                <li>
                  <a href="{{ asset('/') }}">Inicio</a>
                </li>
                <li>
                  <a href="{{ route('servicios') }}">Servicios</a></li>
                <li>
                  <a href="{{ route('contacto') }}">Contacto</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
    </div>

    <div class="preloader"></div>

    <script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/axios/axios.min.js') }}"></script>
    <script src="{{ asset('js/axios/config-axios.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/revolution.min.js') }}"></script>
    <script src="{{ asset('frontend/js/owl.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.mixitup.min.js') }}"></script>
    {{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRvBPo3-t31YFk588DpMYS6EqKf-oGBSI"></script> --}}
    <script src="{{ asset('frontend/js/gmaps.min.js') }}"></script>
    <script src="{{ asset('frontend/js/map-helper.js') }}"></script>
    <script src="{{ asset('frontend/js/wow.js') }}"></script>
    <script src="{{ asset('frontend/js/script.js') }}" defer></script>
    @yield('scripts')
    <script>

      async function subscribe() {
        try {
          const data = await axios.post('subscribe-newsletter', {
            email: document.getElementById('email-subscribe').value
          })
          Swal.fire({
            icon: 'success',
            title: 'Suscripción exitosa',
            text: 'Le enviaremos noticias y novedades a su correo.',
            confirmButtonText: '¡Confirmar!'
          })
        } catch (error) {
          const message = error.response.data.errors.email[0]
          Swal.fire({
            icon: 'warning',
            title: '¡Alerta!',
            html: `<b>${message}</b>`,
            confirmButtonText: '¡Corregir!'
          })
        }
      }
      const classShowContact = 'social-show';
      function chatHandleClick() {
        document.querySelector('#socials-contact').classList.toggle(classShowContact);
      }
      document.addEventListener('keyup',(e) => {
        if(e.code == 'Escape') {
          if(document.querySelector('#socials-contact').classList.contains(classShowContact)) {
            document.querySelector('#socials-contact').classList.remove(classShowContact);
          }
        }
      })
    </script>

</body>

</html>
