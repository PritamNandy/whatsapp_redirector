@extends('.auth.layout.app')
@section('title', __('system.login'))
@section('content')
    @php
        $setting = \Illuminate\Support\Facades\DB::table('settings')->find(1);
    @endphp
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-2 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
        <!--begin::Aside-->
        <div class="login-aside order-2 order-lg-1 d-flex flex-row-auto position-relative overflow-hidden bg-light-site-2">
            <!--begin: Aside Container-->
            <div class="d-flex flex-column-fluid flex-column justify-content-between py-9 px-7 py-lg-13 px-lg-35">
                <!--begin::Logo-->
                <a href="{{ url('/') }}" class="text-center pt-2">
                    <img src="{{$setting->logo != null && $setting->logo != "" ? asset('public/storage/system/'.$setting->logo) : asset('public/storage/system/temp_logo.png')}}" class="max-h-75px" alt="" />
                </a>
                @if(session()->has('message'))
                    @if(session()->pull('message') == 'success')
                        <span class="alert alert-success mt-3 mb-3">{{ __('system.register_success_alert') }}</span>
                    @elseif(session()->pull('message') == 'failed')
                        <span class="alert alert-danger mt-3 mb-3">{{ __('system.register_failed_alert') }}</span>
                    @endif
                @endif

                <!--end::Logo-->
                <!--begin::Aside body-->
                <div class="d-flex flex-column-fluid flex-column flex-center">
                    <!--begin::Signin-->
                    <div class="login-form login-signin py-11">


                        <!--begin::Form-->
                        <form class="form"  method="POST" action="{{ route('login') }}">
                        @csrf
                            <!--begin::Title-->
                            <div class="text-center pb-8">
                                <h2 class="font-weight-bolder text-white font-size-h2 font-size-h1-lg">{{ __('system.sign_in') }}</h2>
                                <span class="text-muted font-weight-bold font-size-h4">Or
										<a href="{{ route('register') }}" class="text-light font-weight-bolder" id="kt_login_signup">{{ __('system.create_account') }}</a></span>
                            </div>
                            <!--end::Title-->
                            <!--begin::Form group-->
                            <div class="form-group">

                                <label class="font-size-h6 font-weight-bolder text-white">{{ __('system.email') }}</label>
                                <input id="email" type="email" class="form-control form-control-solid h-auto py-7 px-6 rounded-lg form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                            <!--end::Form group-->
                            <!--begin::Form group-->
                            <div class="form-group">
                                <div class="d-flex justify-content-between mt-n5">

                                    <label class="font-size-h6 font-weight-bolder text-white pt-5">{{ __('system.password') }}</label>


                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="text-white font-size-h6 font-weight-bolder text-hover-light pt-5" id="kt_login_forgot">  {{ __('system.forgot_password') }}?</a>
                                    @endif



                                </div>
                                <input id="password" class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="password" name="password" autocomplete="off" />
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label text-white" for="remember">
                                    {{ __('system.remember_me') }}
                                </label>
                            </div>

                            <!--end::Form group-->
                            <!--begin::Action-->



                            <div class="text-center pt-2">
                                <button type="submit" class="btn btn-site font-weight-bolder font-size-h6 px-8 py-4 my-3">
                                    {{ __('system.login') }}
                                </button>
                            </div>
                            <!--end::Action-->
                        </form>
                        <!--end::Form-->

                        <table class="table table-bordered table-striped mt-5">
                            <thead class="thead-dark">
                            <th>{{ __('system.email') }}</th>
                            <th>{{ __('system.password') }}</th>
                            <th>{{ __('system.action') }}</th>
                            </thead>
                            <tbody class="table-light">
                            <tr>
                                <td id="adminEmail">admin@example.com</td>
                                <td id="adminPassword">12345678</td>
                                <td><button class="btn btn-primary hd-table-btn loginInfoBtn" data-id="admin">{{ __('system.copy') }}</button></td>
                            </tr>
                            <tr>
                                <td id="investor1Email">user@example.com</td>
                                <td id="investor1Password">12345678</td>
                                <td><button class="btn btn-primary hd-table-btn loginInfoBtn" data-id="investor1">{{ __('system.copy') }}</button></td>
                            </tr>
                            </tbody>
                        </table>


                    </div>
                    <!--end::Signin-->


                    <!--begin::Forgot-->
                    <div class="login-form login-forgot pt-11">
                        <!--begin::Form-->
                        <form class="form" novalidate="novalidate" id="kt_login_forgot_form">
                            <!--begin::Title-->
                            <div class="text-center pb-8">
                                <h2 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Forgotten Password ?</h2>
                                <p class="text-muted font-weight-bold font-size-h4">Enter your email to reset your password</p>
                            </div>
                            <!--end::Title-->
                            <!--begin::Form group-->
                            <div class="form-group">
                                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6" type="email" placeholder="Email" name="email" autocomplete="off" />
                            </div>
                            <!--end::Form group-->
                            <!--begin::Form group-->
                            <div class="form-group d-flex flex-wrap flex-center pb-lg-0 pb-3">
                                <button type="button" id="kt_login_forgot_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mx-4">Submit</button>
                                <button type="button" id="kt_login_forgot_cancel" class="btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mx-4">Cancel</button>
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
        <div class="content order-1 order-lg-2 d-flex flex-column w-100 p-0" style="background-image: url('{{ asset('public/storage/system/login_cover.jpg') }}');background-repeat: no-repeat;background-origin: content-box;background-position: center;background-size: cover">
            <!--begin::Title-->
            <div class="d-flex flex-column justify-content-center text-center pt-lg-40 pt-md-5 pt-sm-5 px-lg-0 pt-5 px-7">
                <h3 class="display4 font-weight-bolder my-7 text-white" style="color: #986923;">{{ $setting->title }}</h3>
                <!--<p class="font-weight-bolder font-size-h2-md font-size-lg text-white opacity-70">User Experience &amp; Interface Design, Product Strategy
                    <br />Web Application SaaS Solutions</p>-->
            </div>
            <!--end::Title-->
            <!--begin::Image-->
            <div class="content-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center" ></div>
            <!--end::Image-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Login-->
</div>
<!--end::Main-->
    <script src="{{asset('assets/custom/js/jquery-3.6.0.min.js')}}"></script>
    <script>
        $('.loginInfoBtn').on('click', function() {
            let id = $(this).data('id');
            $('#email').val($('#'+id+'Email').text());
            $('#password').val($('#'+id+'Password').text());
        })
    </script>
@endsection
