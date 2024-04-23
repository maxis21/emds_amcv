@extends('layout.app')
@section('title', 'Documents')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/nav-doc.css') }}">
<link rel="stylesheet" href="{{ asset('css/datatables/jquery.dataTablesManager.css') }}">
@endsection

@section('body-content')
<div class="container-fluid d-flex" style="justify-content: space-between;">
    <div style="display: flex; justify-content: space-between; align-items: center; width: 100%">
        <!-- <ul class="breadcrumbs">
            <li class="active"><a href="{{route('to.Documents')}}">Documents</a></li>
        </ul> -->
        <div class="breadcrumbs">
            <a href="/documents">Documents </a>
            @foreach ($breadcrumbs as $breadcrumb)
            <a href="{{ route('folders.show', ['name' => $breadcrumb->name, 'folderId' => $breadcrumb->id]) }}"> &nbsp;> {{ $breadcrumb->name }} </a>
            @endforeach
        </div>

    </div>
</div>

<div class="nav-box d-flex">
    <div class="top-box d-flex">
        <a class="open-cf-modal">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-folder-plus" viewBox="0 0 16 16">
                <path d="m.5 3 .04.87a2 2 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2m5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19q-.362.002-.683.12L1.5 2.98a1 1 0 0 1 1-.98z" />
                <path d="M13.5 9a.5.5 0 0 1 .5.5V11h1.5a.5.5 0 1 1 0 1H14v1.5a.5.5 0 1 1-1 0V12h-1.5a.5.5 0 0 1 0-1H13V9.5a.5.5 0 0 1 .5-.5" />
            </svg>Create Folder
        </a>
        <a class="open-ud-modal">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-file-earmark-arrow-up" viewBox="0 0 16 16">
                <path d="M8.5 11.5a.5.5 0 0 1-1 0V7.707L6.354 8.854a.5.5 0 1 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 7.707z" />
                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
            </svg>Upload File
        </a>
    </div>

    <div class="body-box d-flex">
        <div class="file-box">
            <table id="dataTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Department</th>
                        <!-- <th style="max-width: 10px;"></th> -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($folders as $folder)
                    <tr class="folder" data-folder-id="{{ $folder->id }}" data-href="{{ route('folders.show', ['name' => $folder->name, 'folderId' => $folder->id]) }}" style="cursor: pointer;">
                        <td class="tdCustom d-flex" style="position: relative;">
                            <div class="fileIcon" style="border: none; margin: none; padding: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor" class="bi bi-folder-fill" viewBox="0 0 16 16">
                                    <path d="M9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.825a2 2 0 0 1-1.991-1.819l-.637-7a2 2 0 0 1 .342-1.31L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3m-8.322.12q.322-.119.684-.12h5.396l-.707-.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981z" />
                                </svg>
                            </div>
                            <div class="fileText">{{ $folder->name }}</div>
                        </td>
                        <td>{{ $folder->department->name ?? 'No Department' }}</td>
                        <!-- <td style="display: flex; justify-content: right;">
                            <div class="dropdown">
                                
                            </div>
                        </td> -->
                    </tr>
                    @endforeach

                    @foreach ($documents as $document)
                    @php
                        $originalFile = $document->document_versions()->first();
                    @endphp
                    <tr class="docu" data-docu-id="{{ $document->id }}" data-dhref="{{ route('view.file', ['originalFile' => $originalFile]) }}" style="cursor: pointer;" target="_blank">
                        <td class="tdCustom d-flex" style="position: relative;">
                            <div class="fileIcon" style="border: none; margin: none; padding: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m1.217-1.333v3.999h1.46q.602 0 .998-.237a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.589-.68q-.396-.234-1.005-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082h-.563zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638z" />
                                </svg>
                            </div>
                            <div class="fileText">{{ $document->name }}</div>
                        </td>
                        <td>{{ $document->department->name ?? 'No Department' }}</td>
                        <!-- <td style="display: flex; justify-content: right;">
                            <div class="dropdown">
                                
                            </div>
                        </td> -->
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="dropdown-content">
                <a href="#">Edit</a>
                <a href="#">Delete</a>
                <a href="#">Move</a>
            </div>
        </div>
    </div>
</div>


@include('modals.createFolder')
@include('modals.addDoc')
@endsection


@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="{{ asset('js/datatables/jquery.dataTables.js') }}"></script>
<script>
    $(document).ready(function() {
        // Your code to be executed when the DOM is ready
        $('#dataTable').DataTable({
            "lengthChange": false,
            "pageLength": 10,
            "searching": true,
            "paging": false,
            "ordering": false,
            "info": false,
            "language": {
                "search": "",
                "searchPlaceholder": "Search files..."
            },
            "columnDefs": [{
                "targets": -1, // Target the last column
                "orderable": false // Disable sorting for the last column
            }]
        });
    });
</script>


<script>
    // Assuming you have jQuery
    $(document).ready(function() {

        if (window.location.pathname === '/documents' || window.location.pathname === '/') {
            sessionStorage.removeItem('current_folder_id');
        }

        // When a folder is clicked, update the current folder context
        $('.folder').click(function() {
            var folderId = $(this).data('folder-id');
            var url = $(this).data('href');
            // Store the folderId in the session using an AJAX call or store it in a hidden input field
            sessionStorage.setItem('current_folder_id', folderId);

            window.location.href = url;

        });

        // When a docu is clicked, update the current folder context
        $('.docu').click(function() {
            var docuId = $(this).data('docu-id');
            var url = $(this).data('dhref');
            // Store the folderId in the session using an AJAX call or store it in a hidden input field

            window.location.href = url;

        });

        $('.open-cf-modal').click(function() {
            var currentFolderId = sessionStorage.getItem('current_folder_id');
            if (currentFolderId != null) {
                $('#create-file').find('input[name="parent_id"]').val(currentFolderId);
            } else {
                $('#create-file').find('input[name="parent_id"]').val(null);
            }
            $('#create-file').css('display', 'flex');
        });

        $('.open-ud-modal').click(function() {
            var currentFolderId = sessionStorage.getItem('current_folder_id');
            if (currentFolderId != null) {
                $('#add-doc').find('input[name="parent_id"]').val(currentFolderId);
            } else {
                $('#add-doc').find('input[name="parent_id"]').val(null);
            }
            $('#add-doc').css('display', 'flex');
        });

        $('.modal-close').click(function() {
            $('#create-file').css('display', 'none');
            $('#add-doc').css('display', 'none');
            // Hide modal
        });


        // for context Menu
        // $('tr.folder').on('contextmenu', function(e) {
        //     e.preventDefault(); // Prevent the default right-click menu

        //     // Calculate position relative to the nearest positioned ancestor
        //     var posX = e.pageX;
        //     var posY = e.pageY;

        //     $('.dropdown-content').css({
        //         display: 'block',
        //         left: posX + 'px',
        //         top: posY + 'px'
        //     });

        //     // // Optional: Update links or actions based on the clicked row
        //     // var folderId = $(this).data('folder-id');
        //     // $('#edit').attr('href', '/edit-folder/' + folderId);
        //     // $('#delete').attr('href', '/delete-folder/' + folderId);
        //     // $('#move').attr('href', '/move-folder/' + folderId);
        // });

        // Hide the dropdown when clicking anywhere else on the page
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.folder').length) {
                $('.dropdown-content').hide();
            }
        });

    });
</script>


<!-- <script>
    $(document).on('contextmenu', '.folder', function(e){

        e.preventDefault();

        $('.dropdown-content').hide();

        $(this).find('.dropdown-content').css({
            display: "block",
            left: e.pageX,
            top: e.pageY
        })
    })
</script> -->

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