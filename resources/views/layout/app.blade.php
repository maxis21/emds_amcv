<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <!-- CSS Links -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/logout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toastr.css') }}">

    @yield('styles')

    <!-- Jquery -->
    <script src="{{ asset('js/jquery3.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>

</head>

<body>
    <header>
        <div class="top-content d-flex">
            <div class="img-logo d-flex">
                <a href="{{-- route('goto.dashboard') --}}">
                    <img src="{{ asset('img/amcvLogo.png') }}" alt="AMCV Logo" style="width: 55px; height: 55px">
                </a>
            </div>
            <div class="top-text d-flex">
                <p>
                    <span class="fs-3 fw-2">A</span>DVENTIST
                    <span class="fs-3 fw-2">M</span>EDICAL
                    <span class="fs-3 fw-2">C</span>ENTER-
                    <span class="fs-3 fw-2">V</span>ALENCIA
                </p>
                <p class="brand-sys">Electronic Document Management System</p>
            </div>
        </div>
    </header>
    <div class="d-flex">
        <aside>
            @auth
                @if (Auth::user()->role->role->name == 'super-admin')
                    @include('super_admin.sidenav')
                @elseif(Auth::user()->role->role->name == 'admin')
                    @include('admin.sidenav')
                @else
                    @include('users.sidenav')
                @endif
            @endauth
        </aside>

        <main>
            <div class="container-fluid">
                @yield('body-content')
            </div>
        </main>
    </div>
    @include('modals.logout')

    @yield('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('contextmenu', function(event) {
                event.preventDefault();
            });
            document.addEventListener('keydown', function(event) {
                // Check if the key pressed is F12
                if (event.keyCode == 123) {
                    event.preventDefault(); // Prevent the default action (opening developer tools)
                }
            });
        });
    </script>
    <!-- <script>
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
                        /*  alert('Open action triggered for row: ' + rowIndex); */
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

                    var tableRect = table.getBoundingClientRect();
                    // Get the position of the click relative to the viewport
                    var clickX = e.clientX;
                    var clickY = e.clientY;

                    // Account for the scroll position of the table
                    var tableScrollLeft = table.scrollLeft;
                    var tableScrollTop = table.scrollTop;

                    // Adjust the click position by subtracting the table's scroll offsets
                    var adjustedClickX = clickX - tableScrollLeft;
                    var adjustedClickY = clickY - tableScrollTop;

                    // Calculate the position of the context menu relative to the table
                    var contextMenuLeft = tableRect.left + adjustedClickX;
                    var contextMenuTop = tableRect.top + adjustedClickY;

                    // Create a new context menu
                    var contextMenu = document.createElement('ul');
                    contextMenu.id = 'contextMenu';
                    contextMenu.style.position = 'absolute';
                    contextMenu.style.left = contextMenuLeft +
                        'px'; // Set left position relative to the table
                    contextMenu.style.top = contextMenuTop + 'px'; // Set top position relative to the table
                    contextMenu.style.borderRadius = '10px';
                    contextMenu.style.backgroundColor = 'white';
                    contextMenu.style.zIndex = '9999';

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
                        li.style.padding = "10px";
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

        });

        function togglePasswordShow() {
            var passwordInput = document.getElementById('password');
            var toggleShow = document.querySelector('.password-show');
            const passShow = document.getElementById('password-btnShow');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passShow.innerHTML = getSvgIconSlash("bi-eye", "#000000");
            } else {
                passwordInput.type = 'password';
                passShow.innerHTML = getSvgIconEye("bi-eye-slash", "#000000");
            }
        }

        function getSvgIconSlash(iconName, fill) {
            return `
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="${fill}" class="bi ${iconName}" viewBox="0 0 16 16">
                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
            </svg>
        `;
        }

        function getSvgIconEye(iconName, fill) {
            return `
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="${fill}" class="bi ${iconName}" viewBox="0 0 16 16">
            <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z"/>
            <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829"/>
            <path d="M3.35 5.47q-.27.24-.518.487A13 13 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7 7 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z"/>
        </svg>
        `;
        }
    </script> -->

</body>

</html>
