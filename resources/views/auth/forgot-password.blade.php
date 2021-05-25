@extends('.auth.layout.app')
@section('title','Forgot Password')
@section('content')
    @php
        $setting = \Illuminate\Support\Facades\DB::table('settings')->find(1);
    @endphp
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Login-->
        <div class="login login-2 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
            <!--begin::Aside-->
            <div class="login-aside order-2 order-lg-1 d-flex flex-row-auto position-relative overflow-hidden bg-site">
                <!--begin: Aside Container-->
                <div class="d-flex flex-column-fluid flex-column justify-content-between py-9 px-7 py-lg-13 px-lg-35">
                    <!--begin::Logo-->
                    <a href="{{ url('/') }}" class="text-center pt-2">
                        <img src="{{$setting->logo != null && $setting->logo != "" ? asset('public/storage/system/'.$setting->logo) : asset('public/storage/system/temp_logo.png')}}" class="max-h-75px" alt="" />
                    </a>
                    <!--end::Logo-->
                    <!--begin::Aside body-->
                    <div class="d-flex flex-column-fluid flex-column flex-center">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                    @endif


                        <!--begin::Forgot-->
                        <div class="login-form">
                            <!--begin::Form-->
                            <form class="form" method="POST" action="{{ route('password.email') }}">
                            @csrf
                                <!--begin::Title-->
                                <div class="text-center pb-8">
                                    <h2 class="font-weight-bolder text-white font-size-h2 font-size-h1-lg">{{ __('system.forgotten_password') }}?</h2>
                                    <p class="font-weight-bold font-size-h4">{{ __('system.email_reset_password') }}</p>
                                </div>
                                <!--end::Title-->
                                <!--begin::Form group-->
                                <div class="form-group">
                                    <input id="email" type="email" class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <!--end::Form group-->
                                <!--begin::Form group-->
                                <div class="form-group d-flex flex-wrap flex-center pb-lg-0 pb-3">

                                    <button type="submit" class="btn btn-light-site-2 font-weight-bolder font-size-h6 px-8 py-4 my-3 mx-4">
                                        {{ __('system.send_password_reset_link') }}
                                    </button>
                                    <a href="{{ url('/') }}" type="button" class="hd_a_hover btn btn-site-2 font-weight-bolder font-size-h6 px-8 py-4 my-3 mx-4">{{ __('system.cancel') }}</a>
                                </div>
                                <!--end::Form group-->
                            </form>
                            <!--end::Form-->


                        </div>
                        <!--end::Forgot-->
                    </div>
                    <!--end::Aside body-->

                </div>
                <!--end: Aside Container-->
            </div>
            <!--begin::Aside-->
            <!--begin::Content-->
            <div class="content order-1 order-lg-2 d-flex flex-column w-100 p-0" style="background-color: var(--siteLightColor2);">
                <!--begin::Title-->
                <div class="d-flex flex-column justify-content-center text-center pt-lg-40 pt-md-5 pt-sm-5 px-lg-0 pt-5 px-7">
                    <h3 class="display4 font-weight-bolder my-7 text-white" style="color: #986923;">{{ $setting->title }}</h3>
                    <!--<p class="font-weight-bolder font-size-h2-md font-size-lg text-dark opacity-70">User Experience &amp; Interface Design, Product Strategy
                        <br />Web Application SaaS Solutions</p>-->
                </div>
                <!--end::Title-->
                <!--begin::Image-->
                <div class="content-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center" style="background-image: url(assets/media/svg/illustrations/login-visual-2.svg);"></div>
                <!--end::Image-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Login-->
    </div>
    <!--end::Main-->
@endsection
