@extends('.Backend.layout.app')
@section('title', 'Settings')

@section('content')
    <div class="container" id="test-id">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">
                                {{__('system.system')." ".__('system.settings')}}
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="systemSettingForm" action="{{ url('/updateSetting') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('system.system_title')}}</label>
                                        <input type="text" data-setting="name" class="form-control @error('title') is-invalid @enderror" placeholder="{{__('system.enter')." ".__('system.shop_title')}}" name="title" value="{{$settings['title']}}" required @if(\Illuminate\Support\Facades\Auth::user()->role_id == 3) readonly @endif>
                                        @error('title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <span class="invalid-feedback" role="alert" style="display: block">
                                             <strong id="hd-setting-name"></strong>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('system.system_logo')}}</label>
                                        <input type="file" class="form-control @error('logo') is-invalid @enderror" name="logo">
                                        @error('logo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('system.system_favicon')}}</label>
                                        <input type="file" class="form-control @error('favicon') is-invalid @enderror" name="favicon">
                                        @error('favicon')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
{{--                                <div class="col-md-6">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <label for="exampleInputEmail1">{{__('system.user_dashboard_images')}}</label>--}}
{{--                                        <input type="file" id="dashboard_images" class="form-control @error('dashboard_images') is-invalid @enderror" name="dashboard_images[]" multiple>--}}
{{--                                        <span class="text-muted">Preferred Image size 960*640</span>--}}
{{--                                        @error('dashboard_images')--}}
{{--                                        <span class="invalid-feedback" role="alert">--}}
{{--                                                <strong>{{ $message }}</strong>--}}
{{--                                        </span>--}}
{{--                                        @enderror--}}
{{--                                        <span class="invalid-feedback" role="alert" style="display: block">--}}
{{--                                             <strong id="hd-dashboard-images"></strong>--}}
{{--                                        </span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-12">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <label for="exampleInputEmail1">{{__('system.shop_description')}}</label>--}}
{{--                                        <textarea class="form-control @error('description') is-invalid @enderror" name="description">{{ $settings['description'] }}</textarea>--}}
{{--                                        @error('description')--}}
{{--                                        <span class="invalid-feedback" role="alert">--}}
{{--                                                <strong>{{ $message }}</strong>--}}
{{--                                            </span>--}}
{{--                                        @enderror--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <input type="hidden" name="id" value="{{$settings['id']}}">
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button class="btn btn-light-site font-weight-bold submitSetting">{{__('system.submit')}}</button>
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
        $('.submitSetting').on('click', function () {
            let name = document.querySelector('[data-setting="name"]').value;
            if(name.trim()) {
                $('#hd-setting-name').empty();
                $('#systemSettingForm').submit();
            }  else {
                $('#hd-setting-name').empty();
                $('#hd-setting-name').append('Enter System Name');
            }
        })
    </script>
@endpush
