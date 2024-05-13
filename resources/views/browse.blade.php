@extends('layout.app')
@section('title', 'Directory Browser')

@section('styles')
    <style>
        .browser {

            width: 100%;
            text-align: left;
            border-collapse: collapse;
        }

        .browser thead>tr>th {
            background-color: #012f46;
            color: white;
            padding: 5px
        }

        .browser tbody>tr>td {
            font-family: Arial, Helvetica, sans-serif;
            padding: 10px;
        }

        .browser tr:hover {
            background-color: rgba(0, 0, 0, 0.15);
            cursor: pointer;
        }

        .options {
            padding: 5px;
        }

        .options:hover {
            background-color: rgba(0, 0, 0, 0.35);
        }
    </style>
@endsection

@section('body-content')
    <div class="container">
        <h1>Directory Listing</h1>
        @php
            // Function to get original file type
            if (!function_exists('getOriginalFileType')) {
                function getOriginalFileType($extension)
                {
                    switch ($extension) {
                        case 'pdf':
                            return 'PDF Document';
                        case 'doc':
                        case 'docx':
                            return 'Word Document';
                        case 'xls':
                        case 'xlsx':
                            return 'Excel Document';
                        // Add more cases for other file types as needed
                        default:
                            return 'File';
                    }
                }
            }
        @endphp

        <table id="dataTable" class="browser">
            <thead>
                <tr>
                    <th>Filename</th>
                    <th>Type</th>
                    <th>Date modified</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($directories as $directory)
                    <tr data-href="{{ url('/browse?folder=' . urlencode($directory)) }}">
                        <td> {{ basename($directory) }}</td>
                    </tr>
                @endforeach
                @foreach ($contents as $item)
                    @php
                        // Get the file extension using pathinfo
                        $extension = pathinfo($item, PATHINFO_EXTENSION);

                        try {
                            // Get the file modification time
                            $modificationTime = filemtime($item);

                            // Format the modification time
                            $formattedModificationTime = date('F d Y H:i:s A', $modificationTime);
                        } catch (\Throwable $th) {
                            // Handle exception
                        }
                    @endphp

                    <tr data-href="{{ asset('storage/' . $item) }}">
                        <td style="width: 66%">
                            {{ $item }}
                        </td>
                        <td style="width: 16.5%;">
                            @if (is_dir($item))
                                Folder
                            @else
                                {{ getOriginalFileType($extension) }}
                            @endif
                        </td>
                        <td style="width: 16.5%">
                            {{ $formattedModificationTime ?? '' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var table = document.getElementById('dataTable');
            var rows = table.getElementsByTagName('tr');

            for (var i = 0; i < rows.length; i++) {
                rows[i].addEventListener('contextmenu', function(e) {
                    e.preventDefault(); // Prevent default right-click behavior

                    console.log('Clicked element:', e.target); // Log the clicked element

                    // Find the closest table row from the clicked element
                    var closestRow = this.closest('tr');
                    console.log('Closest table row:', closestRow); // Log the closest table row

                    if (closestRow !== null) {
                        // If a table row is found, retrieve its rowIndex
                        var rowIndex = closestRow.rowIndex;
                        alert('Open action triggered for row: ' + rowIndex);
                    } else {
                        // If no table row is found, display an error message
                        alert(
                            'Failed to retrieve row index. The clicked element is not within a table row.'
                        );
                    }

                    // Remove any existing context menu
                    var existingContextMenu = document.getElementById('contextMenu');
                    if (existingContextMenu) {
                        existingContextMenu.parentNode.removeChild(existingContextMenu);
                    }

                    // Create a new context menu
                    var contextMenu = document.createElement('div');
                    contextMenu.id = 'contextMenu';
                    contextMenu.style.position = 'absolute';
                    contextMenu.style.left = e.clientX + 'px';
                    contextMenu.style.top = e.clientY + 'px';
                    contextMenu.style.display = 'block';
                    contextMenu.style.borderRadius ="10px";
                    contextMenu.style.backgroundColor = "white";

                    // Create and append context menu options
                    var ul = document.createElement('div');
                    var options = ['Open', 'Delete', 'Move', 'Copy', 'Rename', 'Create new folder',
                        'Properties'
                    ];
                    var optionID = ['view-item', 'delete-item', 'move-item', 'copy-item', 'edit-item',
                        'new-item', 'info-item'
                    ];
                    var count = 0;
                    options.forEach(function(option) {
                        var li = document.createElement('div');
                        li.classList.add('text-decoration-none');
                        li.classList.add('options');
                        li.style.padding ="10px";
                        li.style.borderRadius = "5px";
                        // Capitalize the first letter of each option
                        var capitalizedOption = option.charAt(0).toUpperCase() + option.slice(1)
                            .toLowerCase();

                        li.textContent = capitalizedOption;
                        li.id = optionID[count];
                        li.style.cursor = "pointer";

                        ul.appendChild(li);
                        count++;
                    });
                    contextMenu.appendChild(ul);

                    // Append context menu to document body
                    document.body.appendChild(contextMenu);

                    // Event listeners for context menu options
                    document.getElementById('view-item').addEventListener('click', function() {
                        //alert('View action triggered for row: ' + closestRow.rowIndex);
                    });

                    document.getElementById('delete-item').addEventListener('click', function() {
                        //alert('Delete action triggered for row: ' + closestRow.rowIndex);
                    });

                    document.getElementById('move-item').addEventListener('click', function() {
                        // alert('Move action triggered for row: ' + closestRow.rowIndex);
                    });

                    document.getElementById('copy-item').addEventListener('click', function() {
                        // alert('Copy action triggered for row: ' + closestRow.rowIndex);
                    });

                    document.getElementById('edit-item').addEventListener('click', function() {
                        //alert('Rename action triggered for row: ' + closestRow.rowIndex);
                    });

                    document.getElementById('new-item').addEventListener('click', function() {
                        //alert('Create New Folder action triggered for row: ' + closestRow.rowIndex);
                    });

                    document.getElementById('info-item').addEventListener('click', function() {
                        //alert('Properties action triggered for row: ' + closestRow.rowIndex);
                    });
                });
            }
            // Event listener to close context menu on click outside
            window.addEventListener('click', function(event) {
                var contextMenu = document.getElementById('contextMenu');
                if (contextMenu && !contextMenu.contains(event.target)) {
                    contextMenu.parentNode.removeChild(contextMenu);
                }
            });

            document.querySelectorAll('tr[data-href]').forEach(function(row) {
                // Attach click event listener to table rows with data-href attribute
                $('table tbody tr[data-href]').click(function(event) {
                    // Prevent default link behavior
                    event.preventDefault();
                    // Get the URL from the data-href attribute
                    var url = $(this).data('href');
                    // Send AJAX request to fetch folder contents
                    $.get(url, function(response) {
                        // Update page content with fetched data
                        $('table tbody').html(response);
                    });
                });
            });
        });
    </script>
@endsection
