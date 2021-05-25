@extends('.auth.layout.app')
@section('title', __('system.registration'))
@section('content')
    @php
        $setting = \Illuminate\Support\Facades\DB::table('settings')->find(1);
    @endphp
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Login-->
        <div class="login login-2 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
            <!--begin::Aside-->
            <div class="login-aside order-2 order-lg-1 d-flex flex-row-auto position-relative overflow-hidden">
                <!--begin: Aside Container-->
                <div class="d-flex flex-column-fluid flex-column justify-content-between py-9 px-7 py-lg-13 px-lg-35">
                    <!--begin::Logo-->
                    <a href="{{ url('/') }}" class="text-center pt-2">
                        <img src="{{$setting->logo != null && $setting->logo != "" ? asset('public/storage/system/'.$setting->logo) : asset('public/storage/system/temp_logo.png')}}" class="max-h-75px" alt="" />
                    </a>
                    <!--end::Logo-->
                    <!--begin::Aside body-->
                    <div class="d-flex flex-column-fluid flex-column flex-center">

                        <!--begin::Signup-->
                        <div class="login-form">
                            <!--begin::Form-->
                            <form class="form" method="POST" action="{{ url('/createUser') }}">
                            @csrf
                                <!--begin::Title-->
                                <div class="text-center pb-8">
                                    <h2 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">{{ __('system.sign_up') }}</h2>
                                    <span class="text-muted font-weight-bold font-size-h4">{{ __('system.already_account') }}?
										<a href="{{ route('login') }}" class="text-site font-weight-bolder" id="kt_login_signup">{{ __('system.login') }}</a></span>
                                </div>
                                <!--end::Title-->
                                <!--begin::Form group-->
                                <div class="form-group">

                                    <input placeholder="{{ __('system.name') }}" id="name" type="text" class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>

                                <input hidden id="user_role" type="number"  value="1" class="form-control" name="role_id">


                                <div class="form-group">


                                    <input placeholder="{{ __('system.email') }}" id="email" type="email" class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                                <!--end::Form group-->
                                <!--begin::Form group-->




{{--                                <div class="form-group">--}}

{{--                                    <input placeholder="{{ __('Phone') }}" id="phone" type="text" class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6 @error('phone') is-invalid @enderror" name="phone" required>--}}

{{--                                    @error('phone')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                    @enderror--}}

{{--                                </div>--}}


                                <div class="form-group">

                                    <input  placeholder="{{ __('system.password') }}" id="password" type="password" class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                                <!--end::Form group-->
                                <!--begin::Form group-->
                                <div class="form-group">
                                    <input placeholder="{{ __('system.confirm_password') }}"  id="password-confirm" type="password" class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6" name="password_confirmation" required autocomplete="new-password">
                                </div>

                                <!--end::Form group-->
                                <!--begin::Form group-->

                                <!--end::Form group-->
                                <!--begin::Form group-->
{{--                                <div class="form-group">--}}

{{--                                    <input placeholder="{{ __("Address") }}" id="address" type="text" class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6 @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}">--}}

{{--                                    @error('address')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                    @enderror--}}


{{--                                </div>--}}

                                <!--end::Form group-->
                                <!--begin::Form group-->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="agree" id="remember" {{ old('remember') ? 'checked' : '' }} required>

                                    <label class="form-check-label text-dark" for="remember">
                                        {{ __('system.i_agree') }}
                                        <a class="text-site" href="#">{{ __('system.term_condition') }}</a>
                                    </label>
                                </div>
                                <!--end::Form group-->
                                <!--begin::Form group-->
                                <div class="form-group d-flex flex-wrap flex-center pb-lg-0 pb-3">
                                    <button type="submit" class="btn btn-site font-weight-bolder font-size-h6 px-8 py-4 my-3 mx-4">{{ __('system.register') }}</button>
                                    <button type="button" id="kt_login_signup_cancel" class="btn btn-light-site font-weight-bolder font-size-h6 px-8 py-4 my-3 mx-4">{{ __('system.cancel') }}</button>
                                </div>
                                <!--end::Form group-->
                            </form>
                            <!--end::Form-->


                        </div>
                        <!--end::Signup-->
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
            <div class="content order-1 order-lg-2 d-flex flex-column w-100 pb-0" style="background-color: var(--siteLightColor);">
                <!--begin::Title-->
                <div class="d-flex flex-column justify-content-center text-center pt-lg-40 pt-md-5 pt-sm-5 px-lg-0 pt-5 px-7">
                    <h3 class="display4 font-weight-bolder my-7 text-dark" style="color: #986923;">{{ $setting->title }}</h3>
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
