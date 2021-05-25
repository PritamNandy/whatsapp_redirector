@extends('.Backend.layout.app')

@section('content')


                    <div class="d-flex flex-column-fluid flex-column flex-center">


                        @if (session()->has('notification'))
                            <div class="notification">
                                {!! session('notification') !!}
                            </div>
                         @endif


                        <!--begin::Signup-->
                        <div class="login-form">
                            <!--begin::Form-->
                            <form class="form" method="POST" action="{{ url('manager/registerUser') }}">
                            @csrf
                            <!--begin::Title-->
                                <div class="text-center pb-8">
                                    <h2 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Create New  user</h2>

                                </div>
                                <!--end::Title-->
                                <!--begin::Form group-->
                                <div class="form-group">

                                    <input placeholder="{{ __('Name') }}" id="name" type="text" class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>

                                <input hidden id="user_role" type="number"  value="1" class="form-control" name="role_id">


                                <div class="form-group">


                                    <input placeholder="{{ __('E-Mail Address') }}" id="email" type="email" class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                                <!--end::Form group-->
                                <!--begin::Form group-->




                                <div class="form-group">

                                    <input placeholder="{{ __('Phone') }}" id="phone" type="text" class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6 @error('phone') is-invalid @enderror" name="phone" required>

                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>



                                <!--end::Form group-->
                                <!--begin::Form group-->

                                <!--end::Form group-->
                                <!--begin::Form group-->
                                <div class="form-group">

                                    <input placeholder="{{ __("Address") }}" id="address" type="text" class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6 @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}">

                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror


                                </div>

                                <!--end::Form group-->
                                <!--begin::Form group-->

                                <div class="form-group">
                                    <label class="checkbox mb-0">
                                        <input type="checkbox" name="agree" />I Agree the
                                        <a href="#">terms and conditions</a>.
                                        <span></span></label>
                                </div>
                                <!--end::Form group-->
                                <!--begin::Form group-->
                                <div class="form-group d-flex flex-wrap flex-center pb-lg-0 pb-3">
                                    <button type="submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mx-4">{{ __('Register') }}</button>
                                    <button type="button" id="kt_login_signup_cancel" class="btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mx-4">Cancel</button>
                                </div>
                                <!--end::Form group-->
                            </form>
                            <!--end::Form-->


                        </div>
                        <!--end::Signup-->

                    </div>



@endsection

