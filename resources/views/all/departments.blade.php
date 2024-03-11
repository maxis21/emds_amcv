@extends('layout.app')
@section('title', 'Departments')

@section('styles')
<!-- <link rel="stylesheet" href="{{ asset('css/datatables/jquery.dataTables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datatables/datatable_v2.css') }}"> -->
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<link rel="stylesheet" href="{{ asset('css/department.css') }}">
<link rel="stylesheet" href="{{ asset('css/add-dept.css') }}">
@endsection

@section('body-content')
<!-- -->
<div class="contentcon">
    <div class="container-fluid d-flex" style="justify-content: space-between;">
        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%">
            <p style="color: grey"><b>{{Auth()->user()->username}}</b></p>
            <ul class="breadcrumbs">
                <li class="text-white"><a href="{{ route('to.Dashboard') }}">Dashboard</a></li>
                <li class="text-white active"> Departments </li>
            </ul>
        </div>
    </div>
    <!-- -->
    <div class="list-con container-fluid d-flex">
        <div class="dept-buttons">
            <a id="open-modal-btn" class="btn" onclick="location.href='#add-department'">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                </svg>
                Add Deparment
            </a>
        </div>
        <div class="list-group d-flex">
            @foreach($departments as $department)
            <a href="{{ route('show.deptFiles', $department->id) }}" class="btn">
                <div class="btn-name">
                    <h3 style="margin: 0;">{{$department->name}}</h3>

                </div>
                <div class="btn-footer">
                </div>
            </a>
            @endforeach
        </div>
    </div>
    <!-- -->
</div>
<!-- -->

@include('modals.department-form')
@endsection


@section('scripts')
<script src="{{ asset('js/datatables/jquery.dataTables.js') }}"></script>

@if(session('success'))
<script>
    toastr.success('{{ session(' success ') }}', 'Success');
</script>
@endif
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