@extends('.Backend.layout.app')
@section('title', __('system.edit_group'))

@section('content')
    @if(session()->has('message'))
        <input type="hidden" id="message" value="{{ session()->pull('message') }}">
    @else
        <input type="hidden" id="message">
    @endif
    <div class="container" id="test-id">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">
                                {{__('system.edit')." ".__('system.group')}}
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="updateGroupForm" action="{{ url('/updateGroup') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="">{{ __('system.name') }}</label> <span class="hd-required">*</span>
                                <input type="text" class="form-control" data-edit-group="name" name="name" placeholder="{{ __('system.enter_group_name') }}" value="{{ $group->name }}">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <span class="invalid-feedback" role="alert" style="display: block;">
                                      <strong id="hd-edit-group-name"></strong>
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="">{{ __('system.whatsapp_link') }}</label> <span class="hd-required">*</span>
                                <input type="text" class="form-control" data-edit-group="link" name="whatsapp_link" placeholder="{{ __('system.enter_whatsapp_link') }}" value="{{ $group->whatsapp_link }}">
                                @error('whatsapp_link')
                                <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <span class="invalid-feedback" role="alert" style="display: block;">
                                      <strong id="hd-edit-group-link"></strong>
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="">{{ __('system.redirect_limit') }}</label> <span class="hd-required">*</span>
                                <input type="number" class="form-control" data-edit-group="limit" name="access_limit" placeholder="{{ __('system.enter_redirect_limit') }}"  value="{{ $group->access_limit }}">
                                @error('access_limit')
                                <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <span class="invalid-feedback" role="alert" style="display: block;">
                                      <strong id="hd-edit-group-limit"></strong>
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="">{{ __('system.performed_redirects') }}</label>
                                <input type="number" class="form-control" data-edit-group="limit" name="access_limit" placeholder="{{ __('system.enter_redirect_limit') }}"  value="{{ $group->total_redirects }}" readonly>
                            </div>

                            <input type="hidden" id="campaign_id" name="campaign_id" value="{{ $group->campaign_id }}">
                        </form>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button class="btn btn-site font-weight-bold createGroupBtn">{{__('system.update')." ".__('system.group')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <script src="{{ asset('assets/js/pages/crud/file-upload/image-input.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.hd-select2').select2();

            let message = $('#message').val();
            if(message == 'failed') {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'error',
                    title: '{{ __('system.try_again') }}'
                })
            } else if(message == 'group_success') {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'error',
                    title: '{{ __('system.group_added') }}'
                })
            }
        })

        $('.createGroupBtn').on('click', function() {
            let name = document.querySelector('[data-edit-group="name"]').value;
            let link = document.querySelector('[data-edit-group="link"]').value;
            let limit = document.querySelector('[data-edit-group="limit"]').value;
            let nameCheck, linkCheck, limitCheck;
            let intRegex = /^[0-9]+$/;

            if(name.trim()) {
                nameCheck = true;
                $('#hd-edit-group-name').empty();
            } else {
                nameCheck = false;
                $('#hd-edit-group-name').empty();
                $('#hd-edit-group-name').append('{{__('system.enter_group_name')}}');
            }

            if(link.trim()) {
                linkCheck = true;
                $('#hd-edit-group-link').empty();
            } else {
                linkCheck = false;
                $('#hd-edit-group-link').empty();
                $('#hd-edit-group-link').append('{{__('system.enter_whatsapp_link')}}');
            }

            if(intRegex.test(limit)) {
                limitCheck = true;
                $('#hd-edit-group-limit').empty();
            } else {
                limitCheck = false;
                $('#hd-edit-group-limit').empty();
                $('#hd-edit-group-limit').append('{{__('system.enter_valid_number')}}');
            }


            if(nameCheck == true && linkCheck == true && limitCheck == true) {
                $('#updateGroupForm').submit();
            }
        })

    </script>
@endpush
