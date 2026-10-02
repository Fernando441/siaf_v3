<!DOCTYPE html>
<html lang="es">
<!--begin::Head-->

<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name', 'SIAF Sistema Integral de Administración y Finanzas') }} login</title>
    <meta name="description" content="SIAF Sistema Integral de Administración y Finanzas" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow" />
    {{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> --}}
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Custom Styles(used by this page)-->
    <link href="{{ asset('theme/assets/css/pages/login/classic/login-4.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Custom Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{ asset('theme/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <link href="{{ asset('theme/assets/css/themes/layout/header/base/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/css/themes/layout/header/menu/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/css/themes/layout/brand/dark.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/css/themes/layout/aside/dark.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Layout Themes-->
    <!--begin::Custom Theme(used by all pages)-->
    <link href="{{ asset('css/principal.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Custom Theme-->
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">

        <!--begin::Login-->
			<div class="login login-4 login-signin-on d-flex flex-row-fluid" id="kt_login">

                
				<div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat login-body" style="" >

					<div class="login-form text-center p-7 position-relative overflow-hidden login-form" style="z-index: 2;">
						<!--begin::Login Header-->
						<div class="d-flex flex-center mb-3">
							<a href="#">
								<img src="{{ asset('theme/assets/media/logos/LogoJetVan-sin-fondo.png') }}" class="max-h-160px" alt="" />
							</a>
						</div>
						<!--end::Login Header-->
						<!--begin::Login Sign in form-->
						<div class="login-signin">
							<div class="mb-13">
								<h3>SIAF</h3>
								<div class="text-muted font-weight-bold mb-2">Sistema Integral de Adminstración y Finanzas</div>
                                 @if (count($errors) > 0)
                                        @foreach ($errors->all() as $message)
                                            <div class="alert alert-custom alert-outline-danger fade show mb-2 animate__animated animate__fadeIn pt-4" role="alert" style="padding: 9px;">
                                                <div class="alert-icon pl-5"><i class="flaticon-warning"></i></div>
                                                <div class="alert-text">{{ $message }}</div>
                                            </div>
 
                                        @endforeach
                                    @endif
							</div>
							<form class="form" id="kt_login_signin_form" action="{{ route('login') }}" method="post" autocomplete="off" novalidate="novalidate">
                                @csrf
                                <!--begin::Form group-->
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mt-n5">
                                    <label class="font-size-h7 font-weight-bolder">{{ __('Correo') }}</label>
                                    </div>
                                    <input
                                        class="form-control h-auto py-4 px-6 rounded-lg font-size-lg font-weight-bold"
                                        type="email" name="email" autocomplete="off" value="{{ old('email') }}"
                                        required autofocus />
                                </div>
                                <!--end::Form group-->
                                <!--begin::Form group-->
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mt-n5">
                                        <label
                                            class="font-size-h7 font-weight-bolder pt-5">{{ __('Contraseña') }}</label>
                                    </div>
                                    <input class="form-control h-auto py-4 px-6 rounded-lg" type="password"
                                        name="password" autocomplete="off" required />
                                </div>
                                <!--end::Form group-->
                                <div
                                    class="form-group d-flex flex-wrap justify-content-between align-items-center mt-6">
                                    <div class="row pl-3">
                                        <div class="captcha">
                                            <span
                                                style="display: inline-block; width: 160px;">{!! captcha_img('flat') !!}</span>
                                        </div>
                                        <a href="#" id="refresh-captcha"
                                            class="btn btn-icon btn-outline-secondary btn-circle ml-3">
                                            <i class="flaticon-refresh"></i>
                                        </a>
                                        <blockquote class="blockquote text-left ml-3">
                                            <p class="mb-0 font-size-base">CAPTCHA</p>
                                            <p class="text-muted font-size-sm">No sensible a mayúsculas.</p>
                                        </blockquote>
                                    </div>
                                    <input id="captcha" type="text" class="form-control mt-1" placeholder="Captcha"
                                        name="captcha" required>
                                </div>

                                <div
                                    class="form-group d-flex flex-wrap justify-content-between align-items-center mt-3">
                                    <div class="checkbox-inline">
                                        <label class="checkbox checkbox-outline m-0 text-gray-700">
                                            <input type="checkbox" name="remember">
                                            <span></span>Recordar Sesión</label>
                                    </div>
                                    <a href="javascript:;" id="kt_login_forgot" class="text-hover-primary">Recuperar
                                        Contraseña</a>
                                </div>

                                <!--begin::Action-->
                                <div class="text-center pt-2">
                                    <button id="kt_login_signin_submit"
                                        class="btn btn-login-green btn-lg btn-block font-weight-bolder font-size-h6 px-8 py-3 my-3">{{ __('Iniciar Sesión') }}</button>
                                </div>
                                <!--end::Action-->


							</form>
							 


						</div>

       

						<!--end::Login Sign in form-->
						 <!--end::Signin-->
                        <form class="form" novalidate="novalidate" id="kt_login_signup_form">
                        </form>
                        <!--begin::Forgot-->
                        <div class="login-form login-forgot p-7">
                            <!--begin::Form-->
                            <form class="form" novalidate="novalidate" id="kt_login_forgot_form">
                                <!--begin::Title-->
                                <div class="text-center pb-8">
                                     
                                    <p class="font-weight-bold">Ingresa tu correo a recuperar
                                        contraseña</p>
                                </div>
                                <!--end::Title-->
                                <!--begin::Form group-->
                                <div class="form-group">
                                    <input
                                        class="form-control h-auto py-4 px-6 rounded-lg"
                                        type="email" placeholder="Correo" name="email" autocomplete="off" />
                                </div>
                                <!--end::Form group-->
                                <!--begin::Form group-->
                                <div class="form-group d-flex flex-wrap flex-center pb-lg-0 pb-3">
                                    <button type="button" id="kt_login_forgot_submit"
                                        class="btn btn-primary font-weight-bolder px-8 py-3 my-3 mx-4">Recuperar</button>
                                    <button type="button" id="kt_login_forgot_cancel"
                                        class="btn btn-light-primary font-weight-bolder px-8 py-3 my-3 mx-4">Cancelar</button>
                                </div>
                                <!--end::Form group-->
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Forgot-->
					</div>
				</div>
			</div>
			<!--end::Login-->


                                

    </div>

    
    <!--end::Main-->
    <script>
        var HOST_URL = "";
    </script>
    <!--begin::Global Config(global config for global JS scripts)-->
    <script>
        var KTAppSettings = {
            "breakpoints": {
                "sm": 576,
                "md": 768,
                "lg": 992,
                "xl": 1200,
                "xxl": 1400
            },
            "colors": {
                "theme": {
                    "base": {
                        "white": "#ffffff",
                        "primary": "#3699FF",
                        "secondary": "#E5EAEE",
                        "success": "#1BC5BD",
                        "info": "#8950FC",
                        "warning": "#FFA800",
                        "danger": "#F64E60",
                        "light": "#E4E6EF",
                        "dark": "#181C32"
                    },
                    "light": {
                        "white": "#ffffff",
                        "primary": "#E1F0FF",
                        "secondary": "#EBEDF3",
                        "success": "#C9F7F5",
                        "info": "#EEE5FF",
                        "warning": "#FFF4DE",
                        "danger": "#FFE2E5",
                        "light": "#F3F6F9",
                        "dark": "#D6D6E0"
                    },
                    "inverse": {
                        "white": "#ffffff",
                        "primary": "#ffffff",
                        "secondary": "#3F4254",
                        "success": "#ffffff",
                        "info": "#ffffff",
                        "warning": "#ffffff",
                        "danger": "#ffffff",
                        "light": "#464E5F",
                        "dark": "#ffffff"
                    }
                },
                "gray": {
                    "gray-100": "#F3F6F9",
                    "gray-200": "#EBEDF3",
                    "gray-300": "#E4E6EF",
                    "gray-400": "#D1D3E0",
                    "gray-500": "#B5B5C3",
                    "gray-600": "#7E8299",
                    "gray-700": "#5E6278",
                    "gray-800": "#3F4254",
                    "gray-900": "#181C32"
                }
            },
            "font-family": "Poppins"
        };
    </script>
    <!--end::Global Config-->
    <!--begin::Global Theme Bundle(used by all pages)-->
    <script src="{{ asset('theme/assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('theme/assets/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
    <script src="{{ asset('theme/assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Theme Bundle-->
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{ asset('theme/assets/js/pages/custom/login/login-general.js') }}"></script>
    <!--end::Page Scripts-->
</body>
<ul class="bg-bubbles" style="overflow: hidden">
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    </ul>
</div>
                                
<!--end::Body-->
</html>
