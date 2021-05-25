@extends('.Backend.layout.app')
@section('title', __('system.users'))

@section('content')
    <div class="container" id="test-id">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">
                                {{ __('system.users')." ".__('system.table') }}
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            <a href="{{ url($role.'/addNewUser') }}" class="btn btn-light-site font-weight-bold">
                                <i class="fas fa-plus"></i> {{ __('system.add')." ".__('system.new')." ".__('system.user') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped" id="users-table">
                            <thead>
                            <tr>
                                <th>{{ __('system.name') }}</th>
                                <th>{{ __('system.email') }}</th>
                                <th>{{ __('system.role') }}</th>
                                <th>{{ __('system.status') }}</th>
                                <th>{{ __('system.option') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <script>
        $(document).ready(function() {
            axios.get('{{url('/callQueue')}}')
                .then(response => {
                    console.log(response.data)
                })
        })
        $(function() {
            $('#hd_datepicker').datepicker({
                format: 'yyyy-mm-dd',
                startDate: new Date()
            });
            $('#hd_timepicker').timepicker();
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{!! route('getUser') !!}',
                columns: [
                    // { data: 'id', name: 'id' },
                    // { data: 'name', name: 'name' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'badge', name: 'badge', orderable: false },
                    { data: 'statusBtn', name: 'statusBtn', orderable: false },
                    { data: 'action', name: 'action', orderable: false },
                ],
                columnDefs: [
                    { "width": "20%", "targets": 0 },
                    { "width": "20%", "targets": 1 },
                    { "width": "20%", "targets": 2 },
                    { "width": "20%", "targets": 3 },
                    { "width": "20%", "targets": 4 },
                ],
                order: [[0, 'asc']]
            });
        });

        $(document).on('click', '.userDeactivate', function() {
            let id = $(this).data('id');
            Swal.fire({
                text: "{{ __('system.wanna_deactive') }}",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "{{ __('system.yes_deactivate') }}",
                cancelButtonText: "{{ __('system.no_cancel') }}",
                customClass: {
                    confirmButton: "btn font-weight-bold btn-danger",
                    cancelButton: "btn font-weight-bold btn-default"
                }
            }).then(function (result) {
                if(result.isConfirmed) {
                    axios.get('{{ url('/userDeactivate') }}/'+id)
                        .then(response => {
                            if(response.data == 'success') {
                                $('#users-table').DataTable().clear().destroy();
                                $('#users-table').DataTable({
                                    processing: true,
                                    serverSide: true,
                                    responsive: true,
                                    ajax: '{!! route('getUser') !!}',
                                    columns: [
                                        // { data: 'id', name: 'id' },
                                        // { data: 'name', name: 'name' },
                                        { data: 'name', name: 'name' },
                                        { data: 'email', name: 'email' },
                                        { data: 'badge', name: 'badge', orderable: false },
                                        { data: 'statusBtn', name: 'statusBtn', orderable: false },
                                        { data: 'action', name: 'action', orderable: false },
                                    ],
                                    columnDefs: [
                                        { "width": "20%", "targets": 0 },
                                        { "width": "20%", "targets": 1 },
                                        { "width": "20%", "targets": 2 },
                                        { "width": "20%", "targets": 3 },
                                        { "width": "20%", "targets": 4 },
                                    ],
                                    order: [[0, 'asc']]
                                });
                            }
                        })
                }
            })
        })

        $(document).on('click', '.userActivate', function() {
            let id = $(this).data('id');
            Swal.fire({
                text: "{{ __('system.wanna_activate') }}",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "{{ __('system.yes_activate') }}",
                cancelButtonText: "{{ __('system.no_cancel') }}",
                customClass: {
                    confirmButton: "btn font-weight-bold btn-success",
                    cancelButton: "btn font-weight-bold btn-default"
                }
            }).then(function (result) {
                if(result.isConfirmed) {
                    axios.get('{{ url('/userActivate') }}/'+id)
                        .then(response => {
                            if(response.data == 'success') {
                                $('#users-table').DataTable().clear().destroy();
                                $('#users-table').DataTable({
                                    processing: true,
                                    serverSide: true,
                                    responsive: true,
                                    ajax: '{!! route('getUser') !!}',
                                    columns: [
                                        // { data: 'id', name: 'id' },
                                        // { data: 'name', name: 'name' },
                                        { data: 'name', name: 'name' },
                                        { data: 'email', name: 'email' },
                                        { data: 'badge', name: 'badge', orderable: false },
                                        { data: 'statusBtn', name: 'statusBtn', orderable: false },
                                        { data: 'action', name: 'action', orderable: false },
                                    ],
                                    columnDefs: [
                                        { "width": "20%", "targets": 0 },
                                        { "width": "20%", "targets": 1 },
                                        { "width": "20%", "targets": 2 },
                                        { "width": "20%", "targets": 3 },
                                        { "width": "20%", "targets": 4 },
                                    ],
                                    order: [[0, 'asc']]
                                });
                            }
                        })
                }
            })
        })

        $(document).on('click', '.userDelete', function() {
            let id = $(this).data('id');
            Swal.fire({
                text: "{{ __('system.delete_user_warning') }}",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "{{ __('system.yes_delete') }}",
                cancelButtonText: "{{ __('system.no_cancel') }}",
                customClass: {
                    confirmButton: "btn font-weight-bold btn-danger",
                    cancelButton: "btn font-weight-bold btn-default"
                }
            }).then(function (result) {
                if(result.isConfirmed) {
                    axios.get('{{ url('/deleteUser') }}/'+id)
                        .then(response => {
                            if(response.data == 'success') {
                                $('#users-table').DataTable().clear().destroy();
                                $('#users-table').DataTable({
                                    processing: true,
                                    serverSide: true,
                                    responsive: true,
                                    ajax: '{!! route('getUser') !!}',
                                    columns: [
                                        // { data: 'id', name: 'id' },
                                        // { data: 'name', name: 'name' },
                                        { data: 'name', name: 'name' },
                                        { data: 'email', name: 'email' },
                                        { data: 'badge', name: 'badge', orderable: false },
                                        { data: 'statusBtn', name: 'statusBtn', orderable: false },
                                        { data: 'action', name: 'action', orderable: false },
                                    ],
                                    columnDefs: [
                                        { "width": "20%", "targets": 0 },
                                        { "width": "20%", "targets": 1 },
                                        { "width": "20%", "targets": 2 },
                                        { "width": "20%", "targets": 3 },
                                        { "width": "20%", "targets": 4 },
                                    ],
                                    order: [[0, 'asc']]
                                });
                            }
                        })
                }
            })
        })

    </script>
@endpush
