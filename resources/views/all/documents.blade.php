@extends('layout.app')
@section('title', 'Documents')

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
                <p style="color: grey"><b>DOCUMENTS</b></p>
                <ul class="breadcrumbs">
                    <li class="text-white"><a href="#">Dashboard</a></li>
                    <li class="text-white active"> Documents </li>
                </ul>
            </div>
        </div>
        <!-- -->
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
                            <tr>
                                <td>Data 1</td>
                                <td>Data 2</td>
                                <td>Data 3</td>
                                <td>Data 4</td>
                                <td style="align-content: center">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle action-button" role="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                                <path
                                                    d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                            </svg>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <ul>
                                                <a href=""><li>Info</li></a>
                                                <a href=""><li>Request</li></a>
                                                <a href=""><li>More</li></a>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
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
        <!-- Add more rows as needed -->
    </table>
@endsection


@section('scripts')
    <script src="{{ asset('js/datatables/jquery.dataTables.js') }}"></script>

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
@endsection
