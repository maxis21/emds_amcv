@extends('layout.app')
@section('title', 'Documents')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/datatables/document.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('css/datatables/datatable_v2.css') }}">
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<link rel="stylesheet" href="{{ asset('css/dept-files.css') }}">

@endsection

@section('body-content')
<!-- -->
<div class="contentcon">
    <div class="container-fluid d-flex" style="justify-content: space-between;">
        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%">
            <p style="color: grey"><b>{{$dptData->name}}</b></p>
            <ul class="breadcrumbs">
                <li class="text-white"><a href="{{ route('to.Dashboard') }}">Dashboard</a></li>
                <li class="text-white"><a href="{{ route('to.Departments') }}"> Departments </a></li>
                <li class="text-white active"> {{$dptData->name}} </li>
            </ul>
        </div>
    </div>
    <!-- -->
    <div class="box-con">
        <div class="card-container d-flex">
            <div class="deptCard card1">
                <p style="margin: 0; padding: 0; font-size: 25px; font-weight: bold; color: #015581;">
                    {{$total_dptDocs}}
                </p>
                <small style="color: black; font-weight: bold; color: #1e96fc;">
                    <span style="color: #6E6E6E;">Total number of</span> DOCUMENTS
                </small>
            </div>
            <div class="deptCard card2">
                <p style="margin: 0; padding: 0; font-size: 25px; font-weight: bold; color: #015581;">
                    {{$total_dptRequest}}
                </p>
                <small style="color: black; font-weight: bold; color: #e63946;">
                    <span style="color: #6E6E6E;">Total number of</span> REQUEST
                </small>
            </div>
            <div class="deptCard card2">
                <p style="margin: 0; padding: 0; font-size: 25px; font-weight: bold; color: #015581;">
                    {{$total_dptUsers}}
                </p>
                <small style="color: black; font-weight: bold; color: #0a9396;">
                    <span style="color: #6E6E6E;">Total number of</span> USERS
                </small>
            </div>
        </div>
        <div class="table-box bg-light" style="border-radius: 1rem; margin-top: 1rem; padding: 1rem; box-shadow: 1px 1px 4px 1px rgba(0, 0, 0, 0.1);">
            <!-- -->
            <div class="table-wrap">
                <!-- -->
                <table id="dataTable" class="table-content display">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date modified</th>
                            <th>Date uploaded</th>
                            <!-- <th>Column 4</th>
                                <th>Column 5</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dptfiles as $file)
                        <tr>
                            <td>{{$file->name}}</td>
                            <td>
                                @php
                                $lastUpdated = $file->document_versions()->latest('updated_at')->first();
                                @endphp
                                {{$lastUpdated ? $lastUpdated->updated_at->format('F j, Y, g:i a') : 'N/A'}}
                            </td>
                            <td>{{ $file->created_at->format('F j, Y, g:i a') }}</td>
                            <!-- <td>Data 4</td>
                                <td>Data 5</td> -->
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

<script>
    $(document).ready(function() {
        // Your code to be executed when the DOM is ready
        $('#dataTable').DataTable({
            "lengthChange": false,
            "pageLength": 15,
            "searching": true
        });
    });



    $(document).ready(function() {
        // Your code to be executed when the DOM is ready
        $('#dataTable2').DataTable({
            "lengthChange": false,
            "pageLength": 10,
            "searching": true
        });
    });
</script>
@endsection