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
            <p style="color: grey"><b>REQUEST</b></p>
            <ul class="breadcrumbs">
                <li class="text-white"><a href="#">Dashboard</a></li>
                <li class="text-white active"> Request </li>
            </ul>
        </div>
    </div>
    <!-- -->
    <div class="box-con">
        <!-- -->
        <form action="{{ route('file.Status') }}" method="get">
            @csrf
            <select name="fileStatus" id="fileStatus" class="form-control statusSelect table-groupBtn d-flex" onchange="this.form.submit()" style="width: 150px;">
                <option value="">All</option>
                <option value='1' {{ request('fileStatus') == '1' ? 'selected' : '' }}>Approved</option>
                <option value='0' {{ request('fileStatus') == '0' ? 'selected' : '' }}>Pending</option>
                <option value='2' {{ request('fileStatus') == '2' ? 'selected' : '' }}>Declined</option>
            </select>
        </form>
        <div class="table-box bg-light" style="border-radius: 1rem; margin-top: 1rem;">
            <!-- -->
            <div class="table-wrap" style="padding: 1rem;">
                <!-- -->
                <table id="dataTable" class="table-content display">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Department</th>
                            <th>Document</th>
                            <th>Status</th>
                            <!-- <th>URL</th> -->

                            <th style="max-width: 10px;"></th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requestedDocs as $requested)
                        <tr>
                            <td>
                                {{$requested->user->username}}
                            </td>
                            <td>{{$requested->user->department->name}}</td>
                            <td>{{$requested->document->name}}</td>
                            <td>
                                @if ($requested->request_status == 1)
                                <span style="background-color: #28A745; color: white; padding: 0.5rem; border-radius: 1rem; margin: 0;">Approved</span>
                                @elseif ($requested->request_status == 2)
                                <span style="background-color: #b44554; color: white; padding: 0.5rem; border-radius: 1rem; margin: 0;">Declined</span>
                                @else
                                <span style="background-color: #F17E0E; color: white; padding: 0.5rem; border-radius: 1rem; margin: 0;">Pending</span>
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
                                    @if (Auth::user()->username == $requested->user->username && $requested->request_status == true)
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <ul>
                                            <a href="{{route('download.Docs', $requested->id)}}" style="background: none; color: inherit; border: none; padding: 0; margin: 0; font: inherit; cursor: pointer; outline: inherit;">
                                                <li>Download</li>
                                            </a>
                                        </ul>
                                    </div>
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
            "language": {
                "search": "",
                "searchPlaceholder": "Search files..."
            },
            "searching": true
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
</script>
@endsection