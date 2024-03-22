@extends('layout.app')
@section('title', 'Documents')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/datatables/document.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('css/datatables/datatable_v2.css') }}">
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<link rel="stylesheet" href="{{ asset('css/documents.css') }}">
@endsection

@section('body-content')
<!-- -->
<div class="contentcon">
    <div class="container-fluid d-flex" style="justify-content: space-between;">
        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%">
            <p style="color: grey"><b>DOCUMENTS</b></p>
            <ul class="breadcrumbs">
                <li class="text-white"><a href="#">Dashboard</a></li>
                <li class="text-white active"> Documents </li>
            </ul>
        </div>
    </div>
    <!-- -->
    <div class="top-buttons" style="margin: 0.5rem;">
        <a onclick="location.href='#add-doc'" class="btn" style="font-size: 15px;">Upload File</a>
    </div>
    <div class="box-con">
        <!-- -->
        <div class="table-box">
            <!-- -->
            <div class="table-wrap">
                <!-- -->
                <table id="dataTable" class="table-content display">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Date uploaded</th>
                            <th>Date updated</th>
                            <th style="max-width: 10px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($DocDatas as $document)

                        <tr>
                            <td>{{$document->name}}</td>
                            <td>{{$document->department->name}}</td>
                            <td>{{$document->created_at->format('F j, Y, g:i a')}}</td>
                            <td>
                                @php
                                $lastUpdated = $document->document_versions()->latest('updated_at')->first();
                                @endphp
                                {{$lastUpdated ? $lastUpdated->updated_at->format('F j, Y, g:i a') : 'N/A'}}
                            </td>
                            <td style="align-content: center">
                                <div class="dropdown">
                                    <a class="dropdown-toggle action-button" role="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                            <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                        </svg>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <ul>
                                            @php
                                                $originalFile = $document->document_versions()->first();
                                            @endphp
                                            <a href="{{$originalFile->file_url}}" target="_blank">
                                                <li>Info</li>
                                            </a>
                                            <form id="requestForm" action="{{ route('request.File') }}" method="POST">
                                                @csrf
                                                <input name="docID" value="{{$document->id}}" hidden>
                                                <input name="docURL" value="{{$originalFile->file_url}}" hidden>
                                                <button type="submit" style="background: none; color: inherit; border: none; padding: 0; margin: 0; font: inherit; cursor: pointer; outline: inherit;">
                                                    <li>Request</li>
                                                </button>
                                            </form>
                                            <a href="">
                                                <li>More</li>
                                            </a>
                                        </ul>
                                    </div>
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
    <!----------------------------TEST UI------------------------------>

    <div class="phDocs">
        <div class="docHeader d-flex">
            <h3>PhilHealth Documents</h3>
        </div>

        <div class="phwebFiles">
            <h4 style="padding: 0;">Membership</h4>
            <ul>
                <li>PMRF: PhilHealth Member Registration Form <a class="btn bg-info btn-info-hover" href="{{ route('try.This') }}">Download</a> </li>
                <li>PMRF-FN: PhilHealth Member Registration Form for Foreign Nationals</li>
            </ul>
        </div>
        <!-- <a href="{{ route('try.This') }}" class="btn bg-success btn-success-hover">Print this</a> -->
    </div>

    <!-- ----------------------------------------------------------- -->
</div>
<!-- -->
<!-- Add more rows as needed -->

@include('modals.addDoc')
@endsection


@section('scripts')
<script src="{{ asset('js/datatables/jquery.dataTables.js') }}"></script>


@if (session('success'))
<script>
    toastr.success('{{ session('
        success ') }}', 'Success');
</script>
@endif

@if (session('error'))
<script>
    toastr.error('{{ session('
        error ') }}', 'Error');
</script>
@endif

<script>
    $(document).ready(function() {
        // Your code to be executed when the DOM is ready
        $('#dataTable').DataTable({
            "lengthChange": false,
            "pageLength": 15,
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
</script>

<script>
    document.querySelector('[name="doc"]').addEventListener('change', function(e) {
        var fileName = e.target.files[0].name.toLowerCase();
        var allowedExtensions = /(\.pdf)$/i;

        if (!allowedExtensions.exec(fileName)) {
            alert('Please upload only PDF files.');
            e.target.value = ''; // Reset the input
        }
    });
</script>

<script>
    document.getElementById('doc').addEventListener('change', function(event) {
        var fileName = event.target.files[0].name;
        document.getElementById('file-chosen').textContent = fileName;
    });
</script>

@endsection