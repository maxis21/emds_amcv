@extends('layout.app')


@section('styles')
    <link rel="stylesheet" href="{{ asset('css/datatables/jquery.dataTables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datatables/datatable_v2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('body-content')
<div class="contentcon">
    <div class="container-fluid d-flex" style="justify-content: space-between;">
        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%">
            <p style="color: grey"><b>DOCUMENT TYPES</b></p>
            <ul class="breadcrumbs">
                <li class="text-white"><a href="#">Dashboard</a></li>
                <li class="text-white active"> Documents </li>
            </ul>
        </div>
    </div>
    <div class="box-con">
        <div class="table-box">
            <div class="table-wrap">
                <table id="dataTable" class="table-content display">
                    <thead>
                        <tr>
                            <th>Column 1</th>
                            <th>Column 2</th>
                            <th>Column 3</th>
                            <th>Column 4</th>
                            <th>Column 5</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Data 1</td>
                            <td>Data 2</td>
                            <td>Data 3</td>
                            <td>Data 4</td>
                            <td>Data 5</td>
                        </tr>
                        <tr>
                            <td>Data 1</td>
                            <td>Data 2</td>
                            <td>Data 3</td>
                            <td>Data 4</td>
                            <td>Data 5</td>
                        </tr>
                        <tr>
                            <td>Data 1</td>
                            <td>Data 2</td>
                            <td>Data 3</td>
                            <td>Data 4</td>
                            <td>Data 5</td>
                        </tr>
                        <tr>
                            <td>Data 1</td>
                            <td>Data 2</td>
                            <td>Data 3</td>
                            <td>Data 4</td>
                            <td>Data 5</td>
                        </tr>
                        <tr>
                            <td>Data 1</td>
                            <td>Data 2</td>
                            <td>Data 3</td>
                            <td>Data 4</td>
                            <td>Data 5</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script src="{{ asset('js/datatables/jquery.dataTables.js') }}"></script>

<script>
    $(document).ready(function() {
        // Your code to be executed when the DOM is ready
        $('#dataTable').DataTable({
            "lengthChange": false,
            "pageLength": 10,
            "searching": true
        });

    });
</script>
@endsection