@extends('.auth.layout.app')
@section('title', __('system.create')." ".__('system.password'))

@section('content')
    <style>
        #hd_body {
            background: #232323;
        }
    </style>
    @php
        $setting = \App\Models\Setting::find(1);
    @endphp
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center mt-5 mb-5">
                <img src="{{ $setting->logo != null && $setting->logo != "" ? asset('public/storage/system/'.$setting->logo) : asset('public/storage/system/temp_logo.png') }}" alt="" width="300px">
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('system.create_your_password') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ request()->token }}">

                                <div class="col-md-6">
                                    <input hidden id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ request()->email }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('system.password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" minlength="7" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('system.confirm_password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-dark">
                                        {{ __('system.update')." ".__('system.password') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

    </script>
@endsection
