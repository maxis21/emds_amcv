@extends('layout.app')
@section('title', 'Home')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/users.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datatables/jquery.dataTables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datatables/datatable_v2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/add.css') }}">
@endsection

@section('body-content')
<!-- -->
<div class="contentcon">
    <div class="container-fluid d-flex" style="justify-content: space-between;">
        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%">
            <p style="color: grey"><b>USERS</b></p>
            <ul class="breadcrumbs">
                <li class="text-white active"><a href="{{ route('to.Dashboard') }}">Users</a></li>
            </ul>
        </div>
    </div>
    <!-- -->

    <div class="body-con d-flex">
        <form action="{{ route('select.Role') }}" method="get" >
            @csrf
            <select name="roles" id="roles" class="form-control roleSelect table-groupBtn d-flex" onchange="this.form.submit()">
                <option value="">All</option>
                <option value="super-admin" {{ request('roles') == 'super-admin' ? 'selected' : '' }} >Super Admin</option>
                <option value="admin" {{ request('roles') == 'admin' ? 'selected' : '' }} >Admin</option>
                <option value="user" {{ request('roles') == 'user' ? 'selected' : '' }}>User</option>
            </select>
        </form>
        <a class="btn d-flex userAdd table-groupBtn" id="userAdd" onclick="location.href='#add-account'">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5" />
            </svg> Add User
        </a>
        @include('all.userTable')
    </div>
    <!-- -->
</div>
<!-- -->
<div class="">

</div>


@include('modals.addUser')

@endsection


@section('scripts')
    <script src="{{ asset('js/datatables/jquery.dataTables.js') }}"></script>
    @if (session('success'))
        <script>
            toastr.success('{{ session('success ') }}', 'Record updated successfully!');
        </script>
    @endif
    @if (session('fail'))
    <script>
        toastr.error('{{ session('fail ') }}', 'Something went wrong!');
    </script>
@endif

    <script>
        $(document).ready(function() {
            // Your code to be executed when the DOM is ready
            $('#dataTable').DataTable({
                "lengthChange": false,
                "pageLength": 10,
                "searching": true,
                "columnDefs": [{
                    "targets": -1, // Target the last column
                    "orderable": false // Disable sorting for the last column
                }]
            });


            $('.action-button').on('click', function(e) {
                e.preventDefault();
                var $dropdown = $(this).closest('.dropdown');
                var $dropdownMenu = $dropdown.find('.dropdown-menu');

                // Toggle the visibility of the dropdown menu
                $dropdownMenu.toggleClass('show');

                // Close other dropdowns if any
                $('.dropdown-menu').not($dropdownMenu).removeClass('show');

                // Close the dropdown when clicking outside
                $(document).on('click', function(e) {
                    if (!$(e.target).closest('.dropdown').length) {
                        $dropdownMenu.removeClass('show');
                    }
                });
            });

        });

        $(document).on('click', '#userAdd', function() {
            location.href = '#add-account';
        });
    </script>

    <script>
        function submitForm(item) {
            let submitForm = document.getElementById('formUser' + item);
            submitForm.submit();
        }
    </script>

@endsection
