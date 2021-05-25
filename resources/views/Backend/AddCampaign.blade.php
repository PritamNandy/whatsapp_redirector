@extends('.Backend.layout.app')
@section('title', __('system.add_campaign'))

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
                                {{__('system.create')." ".__('system.campaign')}}
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="createCampaignForm" action="{{ url('/createCampaign') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="">{{ __('system.icon') }}</label> <span class="hd-required">*</span><br>
                                <div class="image-input image-input-outline" id="kt_image_1">
                                    <div class="image-input-wrapper" style="background-image: url('{{ asset('public/storage/system/logo2.png') }}')"></div>
                                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="{{ __('system.change_icon') }}">
                                        <i class="fa fa-pen icon-sm text-muted"></i>
                                        <input type="file" name="image" data-add-campaign="image" accept=".png, .jpg, .jpeg" />
                                        <input type="hidden" name="profile_avatar_remove" />
                                    </label>
                                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="{{ __('system.cancel_icon') }}">
										<i class="ki ki-bold-close icon-xs text-muted"></i>
									</span>
                                </div>
                                <span class="form-text text-muted">{{ __('system.allowed_images') }}</span>
                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <span class="invalid-feedback" role="alert" style="display: block;">
                                      <strong id="hd-add-campaign-image"></strong>
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="">{{ __('system.name') }}</label> <span class="hd-required">*</span>
                                <input type="text" class="form-control" data-add-campaign="name" name="name" placeholder="{{ __('system.enter_campaign_name') }}">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <span class="invalid-feedback" role="alert" style="display: block;">
                                      <strong id="hd-add-campaign-name"></strong>
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="">{{ __('system.slug') }}</label> <span class="hd-required">*</span>
                                <input type="text" class="form-control" id="campaign_slug" data-add-campaign="slug" name="slug" placeholder="{{ __('system.enter_slug') }}">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <span class="invalid-feedback" role="alert" style="display: block;">
                                      <strong id="hd-add-campaign-slug"></strong>
                                </span>
                            </div>

                            <input type="hidden" id="slug_unique" value="1">
                        </form>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button class="btn btn-site font-weight-bold createCampaignBtn" disabled>{{__('system.create')." ".__('system.campaign')}}</button>
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
            if(message == 'slug_duplicate') {
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
                    title: '{{ __('system.slug_duplicate') }}'
                })
            }
        })

        $('.createCampaignBtn').on('click', function() {
            let name = document.querySelector('[data-add-campaign="name"]').value;
            let slug = document.querySelector('[data-add-campaign="slug"]').value;
            let slugUnique = $('#slug_unique').val();
            let nameCheck, slugCheck, imageCheck = false;

            imageCheck = checkImage();

            if(imageCheck == true) {
                $('#hd-add-campaign-image').empty();
            } else {
                $('#hd-add-campaign-image').empty();
                $('#hd-add-campaign-image').append('{{ __('system.valid_image') }}');
            }

            if(name.trim()) {
                nameCheck = true;
                $('#hd-add-campaign-name').empty();
            } else {
                nameCheck = false;
                $('#hd-add-campaign-name').empty();
                $('#hd-add-campaign-name').append('{{__('system.enter_campaign_name')}}');
            }

            if(slug.trim()) {
                if(slugUnique == 0) {
                    slugCheck = false;
                    $('#hd-add-campaign-slug').empty();
                    $('#hd-add-campaign-slug').append('{{__('system.enter_unique_slug')}}');
                } else {
                    let format = /^[!@#$%^&*()+\-=\[\]{};':"\\|,.<>\/?]*$/;
                    if(format.test(slug)) {
                        slugCheck = false;
                        $('#hd-add-campaign-slug').empty();
                        $('#hd-add-campaign-slug').append('{{ __('system.slug_special') }}');
                    } else {
                        slugCheck = true;
                        $('#hd-add-campaign-slug').empty();
                    }
                }
            } else {
                slugCheck = false;
                $('#hd-add-campaign-slug').empty();
                $('#hd-add-campaign-slug').append('{{__('system.enter_url_slug')}}');
            }

            if(nameCheck == true && slugCheck == true && slugUnique == 1 && imageCheck == true) {
                $('#createCampaignForm').submit();
            }
        })

        $('#campaign_slug').on('change', function() {
            let slug = $('#campaign_slug').val();
            let format = /[!@#$%^&*()+\-=\[\]{};':"\\|,.<>\/?]+/;
            if(format.test(slug)) {
                $('#hd-add-campaign-slug').empty();
                $('#hd-add-campaign-slug').append('{{ __('system.slug_special') }}');
            } else {
                axios.get('{{url('/checkCampaignSlug/')}}/'+slug)
                    .then(response => {
                        if(response.data == 'unique') {
                            $('#hd-add-campaign-slug').empty();
                            $('#slug_unique').val(1);
                            $('.createCampaignBtn').prop('disabled', false);
                        } else {
                            $('#hd-add-campaign-slug').empty();
                            $('#hd-add-campaign-slug').append('{{__('system.enter_unique_slug')}}');
                            $('#slug_unique').val(0);
                            $('.createCampaignBtn').prop('disabled', true);
                        }
                    })
            }
        })

        $('#campaign_slug').on('keyup', function() {
            setTimeout(function() {
                let slug = $('#campaign_slug').val();
                let format = /[!@#$%^&*()+\-=\[\]{};':"\\|,.<>\/?]+/;
                if(format.test(slug)) {
                    $('#hd-add-campaign-slug').empty();
                    $('#hd-add-campaign-slug').append('{{ __('system.slug_special') }}');
                } else {
                    axios.get('{{url('/checkCampaignSlug/')}}/'+slug)
                        .then(response => {
                            if(response.data == 'unique') {
                                $('#hd-add-campaign-slug').empty();
                                $('#slug_unique').val(1);
                                $('.createCampaignBtn').prop('disabled', false);
                            } else {
                                $('#hd-add-campaign-slug').empty();
                                $('#hd-add-campaign-slug').append('{{__('system.enter_unique_slug')}}');
                                $('#slug_unique').val(0);
                                $('.createCampaignBtn').prop('disabled', true);
                            }
                        })
                }
            }, 10);
        })

        function checkImage() {
            let image = document.querySelector('[data-add-campaign="image"]').value;
            let regex = new RegExp("(.*?)\.(jpeg|jpg|png|svg)$");
            return regex.test(image);
        }

    </script>
@endpush
