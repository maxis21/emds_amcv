@extends('layout.app')
@section('title', 'Request')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/datatables/document.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('css/datatables/datatable_v2.css') }}">
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('body-content')
<!-- -->
<div class="contentcon">
    <div class="container-fluid d-flex" style="justify-content: space-between;">
        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%">
            <p style="color: grey"><b>USER UPLOADS</b></p>
            <ul class="breadcrumbs">
                <li class="text-white"><a href="{{ route('to.DashAdmin') }}">Dashboard</a></li>
                <li class="text-white"><a href="{{ route('to.Documents-admin') }}">Documents</a></li>
                <li class="text-white active"> uploads </li>
            </ul>
        </div>
    </div>
    <!-- -->
    <div class="box-con">
        <!-- -->
        <!-- <form action="{{ route('file.Status') }}" method="get">
            @csrf
            <select name="fileStatus" id="fileStatus" class="form-control statusSelect table-groupBtn d-flex" onchange="this.form.submit()" style="width: 150px;">
                <option value="">All</option>
                <option value='1' {{ request('fileStatus') == '1' ? 'selected' : '' }}>Approved</option>
                <option value='0' {{ request('fileStatus') == '0' ? 'selected' : '' }}>Pending</option>
            </select>
        </form> -->
        <div class="table-box bg-light" style="border-radius: 0.5rem; margin-top: 1rem; box-shadow: 1px 1px 4px 1px rgba(0, 0, 0, 0.1);">
            <!-- -->
            <div class="table-wrap" style="padding: 1rem;">
                <!-- -->
                <table id="dataTable" class="table-content display">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Uploaded by </th>
                            <th>Status</th>

                            <th style="max-width: 10px;"></th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($documents as $document)
                        @php
                        $originalFile = $document->document_versions()->first();
                        $folder = $document->folder_id;
                        @endphp
                        <tr>
                            <td>{{$document->name}}</td>
                            <td>{{$document->department->name}}</td>
                            <td>{{ $originalFile ? $originalFile->uploader->username : '' }}</td>
                            <td>
                                @if($originalFile)
                                @if ($originalFile->approval_status == 'Approved')
                                <span style="background-color: #28A745; color: white; padding: 0.5rem; border-radius: 1rem; margin: 0;">Approved</span>
                                @elseif ($originalFile->approval_status == 'Denied')
                                <span style="background-color: #b44554; color: white; padding: 0.5rem; border-radius: 1rem; margin: 0;">Declined</span>
                                @else
                                <span style="background-color: #F17E0E; color: white; padding: 0.5rem; border-radius: 1rem; margin: 0;">Pending</span>
                                @endif
                                @endif
                            </td>
                            <!-- <td>Data 4</td> -->

                            <td style="display: flex; justify-content: right;">
                                <div class="dropdown">
                                    <a class="dropdown-toggle action-button" role="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                            <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                        </svg>
                                    </a>
                                    @if($originalFile)
                                    @if ($originalFile->approval_status != 'Approved' && $originalFile->approval_status != 'Denied')
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="margin-right: 0.5rem; background-color: #e4e4e4;">
                                        <ul>
                                            <form action="{{route('approve.file', $originalFile->id)}}" method="post">
                                                @csrf
                                                @method('PUT')

                                                <button class="rq-btn" button type="submit" style="background: none; color: inherit; border: none; padding: 1rem; margin: 0; font: inherit; cursor: pointer; outline: inherit; width: 100%;">
                                                    Approve
                                                </button>
                                            </form>

                                            <a class="rq-btn open-message-modal" style="background: none; color: inherit; border: none; padding: 1rem; margin: 0; font: inherit; cursor: pointer; outline: inherit; width: 100%; display: block; text-align: center;"'
                                                data-id="{{$originalFile->id}}">
                                                Decline
                                            </a>

                                            <a href="{{$folder ? route('adminFolders.show', ['folderId' => $folder]) : route('adminFolders.show') }}" class="rq-btn" style="background: none; color: inherit; border: none; padding: 1rem; margin: 0; font: inherit; cursor: pointer; outline: inherit; width: 100%; display: block;">
                                                Show file location
                                            </a>
                                        </ul>
                                    </div>
                                    @endif
                                    @endif
                                </div>
                            </td>


                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- -->
            </div>
            <!-- -->
        </div>
        <!-- -->
    </div>
    <!-- -->
</div>
<!-- -->

@include('modals.message')
@endsection


@section('scripts')
<script src="{{ asset('js/datatables/jquery.dataTables.js') }}"></script>

@if (session('success'))
<script>
    toastr.success('{{ session('
        success ') }}', 'Success');
</script>
@endif


<script>
    $(document).ready(function() {
        // Your code to be executed when the DOM is ready
        $('#dataTable').DataTable({
            "lengthChange": false,
            "pageLength": 10,
            "ordering": false,
            "language": {
                "search": "",
                "searchPlaceholder": "Search files..."
            },
            "searching": true,
            "stripeClasses": []
        });

        $(document).on('click', '.action-button', function(e) {
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


        $('.open-message-modal').click(function() {

            var uploadId = $(this).data('id');
            var modal = $('#create-message');

            // Set the form action URL with the request ID
            modal.find('form').attr('action', '/uploads/decline-file/' + uploadId);


            $('#create-message').css('display', 'flex');

        });

        $('.modal-close').click(function() {
            $('#create-message').css('display', 'none');
        });
        
    });
</script>
@endsection