@extends('.Backend.layout.app')
@section('title', 'Profile')

@section('content')
    <div class="container" id="test-id">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">
                                {{__('system.profile')." ".__('system.settings')}}
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/updateProfile') }}" method="post" id="updateProfileForm">
                            @csrf
                            <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">{{__('system.name')}}</label>
                                            <input type="text" data-profile-update="name" class="form-control @error('name') is-invalid @enderror" placeholder="{{__('system.enter')." ".__('system.name')}}" name="name" value="{{$user['name']}}" required>
                                            <span class="invalid-feedback" role="alert" style="display: block;">
                                                 <strong id="hd-profile-name"></strong>
                                            </span>
                                            @error('name')
                                            <span class="invalid-feedback" role="alert" style="display: block;">
                                                    <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">{{__('system.email')}}</label>
                                            <input type="email" data-profile-update="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{__('system.enter')." ".__('system.email')}}" name="email" value="{{$user['email']}}" required>
                                            <span class="invalid-feedback" role="alert" style="display: block;">
                                                 <strong id="hd-profile-email"></strong>
                                            </span>
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group" style="display: none">
                                            <label for="exampleInputEmail1">{{__('system.phone')}}</label>
                                            <input type="number" data-profile-update="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="{{__('system.enter')." ".__('system.phone')}}" name="phone" value="{{$user['phone']}}" required>
                                            <span class="invalid-feedback" role="alert" style="display: block;">
                                                 <strong id="hd-profile-phone"></strong>
                                            </span>
                                            @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">{{__('system.password')}}</label>
                                            <input type="text" data-profile-update="password" class="form-control @error('password') is-invalid @enderror" placeholder="*******" name="password">
                                            <span class="invalid-feedback" role="alert" style="display: block;">
                                                 <strong id="hd-profile-password"></strong>
                                            </span>
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <input type="hidden" name="id" value="{{$user['id']}}">
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button class="btn btn-site submitBtn">{{__('system.submit')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <script>
        $('.submitBtn').on('click', async function() {
            let email = document.querySelector('[data-profile-update="email"]').value;
            let phone = document.querySelector('[data-profile-update="phone"]').value;
            let name = document.querySelector('[data-profile-update="name"]').value;
            let password = document.querySelector('[data-profile-update="password"]').value;

            let intRegex = /^[0-9]+$/;
            let emailRegex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

            let emailCheck, nameCheck, phoneCheck, passwordCheck;

            if(emailRegex.test(email)) {
                await axios.get('{!! url('/checkProfileUniqueEmail') !!}/'+email)
                    .then(response => {
                        if(response.data == "notunique") {
                            $('#hd-profile-email').empty();
                            $('#hd-profile-email').append('Email Already Registered. Provide an unique email.');
                            emailCheck = false;
                        } else {
                            $('#hd-profile-email').empty();
                            emailCheck = true;
                        }
                    })
            } else {
                $('#hd-profile-email').empty();
                $('#hd-profile-email').append('Please enter a valid email!');
                emailCheck = false;
            }

            if(intRegex.test(phone) && phone.trim().length >= 10) {
                await axios.get('{!! url('/checkProfileUniquePhone') !!}/'+phone)
                    .then(response => {
                        if(response.data == "notunique") {
                            $('#hd-profile-phone').empty();
                            $('#hd-profile-phone').append('Phone Already Registered. Provide an unique phone number.');
                            phoneCheck = false;
                        } else {
                            $('#hd-profile-phone').empty();
                            phoneCheck = true;
                        }
                    })
            } else {
                $('#hd-profile-phone').empty();
                $('#hd-profile-phone').append('Please enter a valid phone number!');
                phoneCheck = false;
            }

            if(name && name.trim().length > 2) {
                $('#hd-profile-name').empty();
                nameCheck = true;
            } else {
                $('#hd-profile-name').empty();
                $('#hd-profile-name').append('Please enter your name properly.');
                nameCheck = false;
            }

            if(password === "") {
                passwordCheck = true;
            } else if(password && password.trim().length > 5) {
                $('#hd-profile-password').empty();
                passwordCheck = true;
            } else if(password && password.trim().length < 5) {
                $('#hd-profile-name').empty();
                $('#hd-profile-password').empty('Password length should be greater than 5!');
                passwordCheck = false;
            }

            // && phoneCheck == true
            if(emailCheck == true && nameCheck == true && passwordCheck == true) {
                $('#updateProfileForm').submit();
            }
        })
    </script>
@endpush
