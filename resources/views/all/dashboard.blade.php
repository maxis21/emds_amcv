@extends('layout.app')
@section('title', 'Home')

@section('styles')
<!-- <link rel="stylesheet" href="{{ asset('css/datatables/jquery.dataTables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datatables/datatable_v2.css') }}"> -->
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('body-content')
<!-- -->
<div class="contentcon">
    <div class="container-fluid d-flex" style="justify-content: space-between;">
        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%">
            <p style="color: grey"><b>Dashboard</b></p>
            <ul class="breadcrumbs">
                <li class="text-white"><a href="#">Dashboard</a></li>
                <!-- <li class="text-white active"> Deparments </li> -->
            </ul>
        </div>
    </div>
    <!-- -->
    <div class="body-container container-fluid d-flex">
        <div class="card-group d-flex">
            <div class="dash-card">
                1
            </div>
            <div class="dash-card">
                2
            </div>
            <div class="dash-card">
                3
            </div>
            <div class="dash-card">
                4
            </div>
        </div>
        <div class="body-content">

        </div>
    </div>
    <!-- -->
</div>
<!-- -->
@endsection


@section('scripts')
<!-- <script src="{{ asset('js/datatables/jquery.dataTables.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Your code to be executed when the DOM is ready
            $('#dataTable').DataTable({
                "lengthChange": false,
                "pageLength": 10,
                "searching": true
            });

        });
    </script> -->
@endsection