</div>

<!--end::Content-->
<!--begin::Footer-->
<div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
    <!--begin::Container-->
    <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
        @php
        $currentyear = date('Y');
        @endphp
        <!--begin::Copyright-->
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted font-weight-bold mr-2">© {{$currentyear}}</span>
            <a href="{{ url('/') }}" target="_blank" class="text-dark-75 text-hover-primary">{{ $setting->title }}</a>
        </div>
        <!--end::Copyright-->
        <!--begin::Nav-->
        <!--<div class="nav nav-dark">
            <a href="#" target="_blank" class="nav-link pl-0 pr-5">About</a>
            <a href="#" target="_blank" class="nav-link pl-0 pr-5">Team</a>
            <a href="#" target="_blank" class="nav-link pl-0 pr-0">Contact</a>
        </div>-->
        <!--end::Nav-->
    </div>
    <!--end::Container-->
</div>
<!--end::Footer-->
</div>


