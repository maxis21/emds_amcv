@extends('layout.app')
@section('title', 'Documents')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/nav-doc.css') }}">
@endsection

@section('body-content')
<div class="container-fluid d-flex" style="justify-content: space-between;">
    <div style="display: flex; justify-content: space-between; align-items: center; width: 100%">
        <p style="color: grey"><b>DOCUMENTS</b></p>
        <ul class="breadcrumbs">
            <li class="text-white"><a href="#">Dashboard</a></li>
            <li class="text-white active"> Documents </li>
        </ul>
    </div>
</div>

<div class="nav-box d-flex">
    <div class="top-box d-flex">
        
    </div>

    <div class="body-box d-flex">
        <div class="item-box">
            Hello World adasdsadasd 
        </div>
        <div class="item-box">

        </div>
        <div class="item-box">

        </div>
        <div class="item-box">

        </div>
    </div>
</div>



@endsection


@section('scripts')


@endsection