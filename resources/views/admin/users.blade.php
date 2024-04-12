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
                <li class="text-white"><a href="{{ route('to.Dashboard') }}">Dashboard</a></li>
                <li class="text-white active"> Users </li>
            </ul>
        </div>
    </div>
    <!-- -->
    <div id="info-account" class="info-account" style="display: none;">
        <div class="modal-global">
            <div class="header-modal-global">
                <p>User Details</p>
            </div>
            <div class="modal-content-global">
                <form action="{{ route('update.User') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="uid" id="id">
                    <div class="d-flex" style="gap: 0.5rem;">
                        <div class="form-group">
                            <label for="First-Name" class="form-label">First Name</label>
                            <input type="text" class="form-control" name="fname" id="fname">
                        </div>
                        <div class="form-group">
                            <label for="Middle-Name" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" name="mname" id="mname">
                        </div>
                        <div class="form-group">
                            <label for="Last-Name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="lname" id="lname">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="role" class="form-label">Department</label>
                        <select style="height: 38px; padding-left: 0.5rem;" name="department" id="department" class="form-control">
                            @foreach ($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="role" class="form-label">Role</label>
                        <select style="height: 38px; padding-left: 0.5rem;" name="role" id="role" class="form-control">
                            <option value="3">Super Admin</option>
                            <option value="2">Admin</option>
                            <option value="1">User</option>
                        </select>
                    </div>
            </div>
            <div class="modal-footer-global">
                <button class="btn bg-success btn-success-hover" type="submit">Update</button>
                </form>
                &nbsp;
                <button class="btn bg-danger btn-danger-hover" onclick="closeInfoModal()">Close</button>
            </div>
        </div>
    </div>


    <div class="body-con d-flex">
        <a class="btn d-flex userAdd-admin table-groupBtn" id="userAdd" onclick="location.href='#add-account'">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5" />
            </svg> Add User
        </a>
        @include('admin.userTable')
    </div>
    <!-- -->
</div>
<!-- -->
<div class="">

</div>

<div id="resetter" class="resetter">
    <div class="modal">
        <div class="header-modal">
            <p>Reset Password</p>
            <!-- Close Layout - Commented -->
            <!-- <span class="modal-close" onclick="location.href='#'">&times;</span> -->
        </div>
        <div class="modal-content d-flex" style="justify-content: center;">
            <form action="{{ route('password.reset') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="resetid" id="resetid">
                <h4 style="font-weight: normal;">Reset this users password to default?</h4>
        </div>
        <div class="modal-footer">
            <button class="btn bg-success btn-success-hover" type="submit">Yes</button>
            </form>
            <button class="btn bg-danger btn-danger-hover" onclick="location.href=''">No</button>
        </div>
    </div>
</div>
@include('modals.addUser')




@endsection


@section('scripts')
<script src="{{ asset('js/datatables/jquery.dataTables.js') }}"></script>
@if (session('success'))
<script>
    toastr.success('{{session('
        success ')}}', 'Success');
</script>
@endif
@if (session('fail'))
<script>
    toastr.error('{{ session('
        fail ') }}', $message);
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


        // Use event delegation to ensure the click event works even for dynamically added elements
        $(document).on('click', '.action-button', function(e) {
            e.preventDefault();
            var $dropdown = $(this).closest('.dropdown');
            var $dropdownMenu = $dropdown.find('.dropdown-menu');

            // Toggle the visibility of the dropdown menu
            $dropdownMenu.toggleClass('show');

            // Close other dropdowns if any
            $('.dropdown-menu').not($dropdownMenu).removeClass('show');
        });

        // Define the document-level click event handler once to handle clicks outside of dropdowns
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.dropdown').length) {
                $('.dropdown-menu').removeClass('show');
            }
        });

        // DataTables pagination may require you to re-initiate the plugin or features
        // This code would need to run after DataTables has redrawn the table, e.g. in a 'drawCallback'
    });


    function submitForm(item) {
        let submitForm = document.getElementById('formUser' + item);
        submitForm.submit();
    }

    function openModalUser(url) {
        $.ajax({
            url: url, // Replace with your API endpoint URL
            method: 'GET',
            success: function(response) {
                // If request succeeds, display the modal or the element
                $('#fname').val(response.fname);
                $('#mname').val(response.mname);
                $('#lname').val(response.lname);
                $('#department').val(response.department_id);
                // Assuming the response contains department ID
                $('#role').val(response.role);
                $('#id').val(response.id);

                let userInfo = document.getElementById('info-account');
                userInfo.style.display = 'block';
            },
            error: function(xhr, status, error) {
                // If request fails, handle the error (e.g., show error message)
                console.error('Error fetching user data:', error);
            }
        });
    }
</script>

<script>
    function closeInfoModal() {
        document.getElementById('info-account').style.display = 'none';
    }
</script>

<script>
    function resetModal(resetID){
        document.getElementById("resetid").value = resetID;
        this.href = '#resetter';
        window.location.href = this.href;
    }
</script>

@endsection