@extends('.Backend.layout.app')
@section('title', __('system.edit')." ".__('system.user'))

@section('content')
    <div class="container" id="test-id">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">
                                {{__('system.edit')." ".__('system.user')}}
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="updateUserForm" action="{{ url('/updateUser') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('system.name')}} <span class="hd-required">*</span></label>
                                        <input type="text" data-update-user="name" class="form-control @error('name') is-invalid @enderror" placeholder="{{__('system.enter')." ".__('system.name')}}" name="name" value="{{ $user->name }}" required>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <span class="invalid-feedback" role="alert" style="display: block;">
                                                <strong id="hd-user-update-name"></strong>
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('system.email')}} <span class="hd-required">*</span></label>
                                        <input type="email" id="user_update_email" data-update-user="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{__('system.enter')." ".__('system.email')}}" name="email" value="{{ $user->email }}" required>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <span class="invalid-feedback" role="alert" style="display: block;">
                                                <strong id="hd-user-update-email"></strong>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('system.user')." ".__('system.type')}} <span class="hd-required">*</span></label>
                                        <select name="type" data-update-user="type" id="user_type" class="@error('type') is-invalid @enderror hd-select2 form-control" required>
                                            <option value="-1">{{ __('system.select') ." ". __('system.user') ." ".__('system.type') }}</option>
                                            @if(\Illuminate\Support\Facades\Auth::user()->role_id == 2)
                                                @foreach($types as $type)
                                                    <option value="{{ $type->id }}" @if($type->id == $user->role_id) selected @endif>{{ $type->role_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('type')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <span class="invalid-feedback" role="alert" style="display: block;">
                                                <strong id="hd-update-user-type"></strong>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="valid_email" value="1">
                            <input type="hidden" name="id" data-update-user="id" value="{{ $user->id }}">
                        </form>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button class="btn btn-light-site updateUserBtn">{{__('system.update')." ".__('system.user')}}</button>
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


        $('#user_update_email').keyup(function() {
            let email = $('#user_update_email').val();
            let id = document.querySelector('[data-update-user="id"]').value;
            axios.get('{{ url('checkUserUniqueEmail') }}/'+email+'/'+id)
                .then(response => {
                    if(response.data == "notunique") {
                        $('#hd-user-update-email').empty();
                        $('#hd-user-update-email').append('{{ __('system.registered_email_warning') }}');
                        $('#valid_email').val(0);
                    } else {
                        $('#hd-user-update-email').empty();
                        $('#valid_email').val(1);
                    }
                })
        })


        $('#user_update_email').on("change", function() {
            let email = $('#user_update_email').val();
            let id = document.querySelector('[data-update-user="id"]').value;
            axios.get('{{ url('checkUserUniqueEmail') }}/'+email+'/'+id)
                .then(response => {
                    if(response.data == "notunique") {
                        $('#hd-user-update-email').empty();
                        $('#hd-user-update-email').append('{{ __('system.registered_email_warning') }}');
                        $('#valid_email').val(0);
                    } else {
                        $('#hd-user-update-email').empty();
                        $('#valid_email').val(1);
                    }
                })
        })

        $('.updateUserBtn').on('click', function() {
            let intRegex = /^[0-9]+$/;
            let floatRegex = /^-?\d+\.?\d*$/;
            let emailRegex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

            let nameCheck, emailCheck, emailValidCheck, phoneCheck, phoneValidCheck, typeCheck, addressCheck;
            let name = document.querySelector('[data-update-user="name"]').value;


            if(name.trim()) {
                nameCheck = true;
                $('#hd-user-update-name').empty();
            } else {
                nameCheck = false;
                $('#hd-user-update-name').empty();
                $('#hd-user-update-name').append('{{ __('system.enter_user_name') }}');
            }

            let email = document.querySelector('[data-update-user="email"]').value;
            if(emailRegex.test(email)) {
                emailCheck = true;
                if($('#valid_email').val() == 1) {
                    emailValidCheck = true;
                    $('#hd-user-update-email').empty();
                } else {
                    emailValidCheck = false;
                    $('#hd-user-update-email').empty();
                    $('#hd-user-update-email').append('{{ __('system.registered_email_warning') }}');
                }
            } else {
                emailValidCheck = false;
                emailCheck = false;
                $('#hd-user-update-email').empty();
                $('#hd-user-update-email').append('{{ __('system.enter_valid_email') }}');
            }

            let user_type = $('#user_type').val();
            if(intRegex.test(user_type)) {
                typeCheck = true;
                $('#hd-update-user-type').empty();
            } else {
                typeCheck = false;
                $('#hd-update-user-type').empty();
                $('#hd-update-user-type').append('{{ __('system.select_user_type') }}');
            }

            if(nameCheck == true && emailCheck == true && emailValidCheck == true && typeCheck == true) {
                $('#updateUserForm').submit();
            }
        })
    </script>
@endpush
