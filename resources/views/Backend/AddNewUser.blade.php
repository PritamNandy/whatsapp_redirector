@extends('.Backend.layout.app')
@section('title', __('system.create')." ".__('system.user'))

@section('content')
    <div class="container" id="test-id">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">
                                {{__('system.create')." ".__('system.user')}}
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="createUserForm" action="{{ url('/createUser') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('system.name')}} <span class="hd-required">*</span></label>
                                        <input type="text" data-add-user="name" class="form-control @error('name') is-invalid @enderror" placeholder="{{__('system.enter')." ".__('system.name')}}" name="name" required>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <span class="invalid-feedback" role="alert" style="display: block;">
                                                <strong id="hd-user-add-name"></strong>
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('system.email')}} <span class="hd-required">*</span></label>
                                        <input type="email" id="user_add_email" data-add-user="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{__('system.enter')." ".__('system.email')}}" name="email" required>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <span class="invalid-feedback" role="alert" style="display: block;">
                                                <strong id="hd-user-add-email"></strong>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('system.user')." ".__('system.type')}} <span class="hd-required">*</span></label>
                                        <select name="type" data-add-user="type" id="user_type" class="@error('type') is-invalid @enderror hd-select2 form-control" required>
                                            <option value="-1">{{ __('system.select') ." ". __('system.user') ." ".__('system.type') }}</option>
                                            @if(\Illuminate\Support\Facades\Auth::user()->role_id == 2)
                                                @foreach($types as $type)
                                                    <option value="{{ $type->id }}">{{ $type->role_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('type')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <span class="invalid-feedback" role="alert" style="display: block;">
                                                <strong id="hd-add-user-type"></strong>
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('system.account')." ".__('system.password')}} <span class="hd-required">*</span></label>
                                        <input type="text" class="form-control" name="password" data-add-user="password" placeholder="{{ __('system.enter_password') }}">
                                        @error('type')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <span class="invalid-feedback" role="alert" style="display: block;">
                                                <strong id="hd-add-user-password"></strong>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="valid_email">
                        </form>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button class="btn btn-light-site createUserBtn">{{__('system.create')." ".__('system.user')}}</button>
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
        $(document).ready(function() {
            $('.hd-select2').select2();
        })

        $('#user_add_email').keyup(function() {
            let email = $('#user_add_email').val();
            axios.get('{{ url('checkUniqueEmail') }}/'+email)
                .then(response => {
                    if(response.data == "notunique") {
                        $('#hd-user-add-email').empty();
                        $('#hd-user-add-email').append('{{ __('system.registered_email_warning') }}');
                        $('#valid_email').val(0);
                    } else {
                        $('#hd-user-add-email').empty();
                        $('#valid_email').val(1);
                    }
                })
        })

        $('#user_add_email').on("change", function() {
            let email = $('#user_add_email').val();
            axios.get('{{ url('checkUniqueEmail') }}/'+email)
                .then(response => {
                    if(response.data == "notunique") {
                        $('#hd-user-add-email').empty();
                        $('#hd-user-add-email').append('{{ __('system.registered_email_warning') }}');
                        $('#valid_email').val(0);
                    } else {
                        $('#hd-user-add-email').empty();
                        $('#valid_email').val(1);
                    }
                })
        })

        $('.createUserBtn').on('click', function() {
            let intRegex = /^[0-9]+$/;
            let floatRegex = /^-?\d+\.?\d*$/;
            let emailRegex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

            let nameCheck, emailCheck, emailValidCheck, phoneCheck, phoneValidCheck, typeCheck, passwordCheck;
            let name = document.querySelector('[data-add-user="name"]').value;

            if(name.trim()) {
                nameCheck = true;
                $('#hd-user-add-name').empty();
            } else {
                nameCheck = false;
                $('#hd-user-add-name').empty();
                $('#hd-user-add-name').append('{{ __('system.enter_user_name') }}');
            }

            let email = document.querySelector('[data-add-user="email"]').value;
            if(emailRegex.test(email)) {
                emailCheck = true;
                if($('#valid_email').val() == 1) {
                    emailValidCheck = true;
                    $('#hd-user-add-email').empty();
                } else {
                    emailValidCheck = false;
                    $('#hd-user-add-email').empty();
                    $('#hd-user-add-email').append('{{ __('system.registered_email_warning') }}');
                }
            } else {
                emailValidCheck = false;
                emailCheck = false;
                $('#hd-user-add-email').empty();
                $('#hd-user-add-email').append('{{ __('system.enter_valid_email') }}');
            }

            let user_type = $('#user_type').val();
            if(intRegex.test(user_type)) {
                typeCheck = true;
                $('#hd-add-user-type').empty();
            } else {
                typeCheck = false;
                $('#hd-add-user-type').empty();
                $('#hd-add-user-type').append('{{ __('system.select_user_type') }}');
            }

            let password = document.querySelector('[data-add-user="password"]').value;
            if(password.trim()) {
                passwordCheck = true;
                $('#hd-add-user-password').empty();
            } else {
                passwordCheck = false;
                $('#hd-add-user-password').empty();
                $('#hd-add-user-password').append('{{ __('system.enter_password') }}');
            }

            if(nameCheck == true && emailCheck == true && emailValidCheck == true && typeCheck == true && passwordCheck == true) {
                $('#createUserForm').submit();
            }
        })
    </script>
@endpush
