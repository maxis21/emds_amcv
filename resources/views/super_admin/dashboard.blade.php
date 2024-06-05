@extends('layout.app')
@section('title', 'Home')

@section('styles')
<!-- <link rel="stylesheet" href="{{ asset('css/datatables/jquery.dataTables.css') }}">
                                                                                            <link rel="stylesheet" href="{{ asset('css/datatables/datatable_v2.css') }}"> -->
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<style>
    .chart-detail {
        border-radius: 10px;
        background-color: white;
        width: 100%;
    }
</style>
@endsection

@section('body-content')
<!-- -->
<div class="contentcon">
    <div class="container-fluid d-flex" style="justify-content: space-between;">
        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%">
            <p style="color: grey"><b>DASHBOARD</b></p>
            <ul class="breadcrumbs">
                <li class="text-white"><a href="#">Dashboard</a></li>
                <!-- <li class="text-white active"> Deparments </li> -->
            </ul>
        </div>
        <!-- -->
    </div>

    <div class="body-container container-fluid d-flex">
        <div class="card-group d-flex">
            <div class="dash-card dash-1">
                <h5 style="display: flex; flex-direction: column; gap: 0.4rem;">DEPARTMENTS<br><span style="font-size: 25px;">{{ $totalDpt->count() }}</span> </h5>
                <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-building-fill card-icon" viewBox="0 0 16 16">
                    <path d="M3 0a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h3v-3.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V16h3a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1zm1 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5M4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM7.5 5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5m2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM4.5 8h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5m2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5" />
                </svg>
            </div>
            <div class="dash-card dash-2">
                <h5 style="display: flex; flex-direction: column; gap: 0.4rem;">REQUESTS<br><span style="font-size: 25px;">{{ $totalreq }}</span> </h5>
                <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-chat-fill card-icon" viewBox="0 0 16 16">
                    <path d="M8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6-.097 1.016-.417 2.13-.771 2.966-.079.186.074.394.273.362 2.256-.37 3.597-.938 4.18-1.234A9 9 0 0 0 8 15" />
                </svg>
            </div>
            <div class="dash-card dash-3">
                <h5 style="display: flex; flex-direction: column; gap: 0.4rem;">DOCUMENTS<br><span style="font-size: 25px;">{{ $totalDocs->count() }}</span> </h5>
                <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-folder-fill card-icon" viewBox="0 0 16 16">
                    <path d="M9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.825a2 2 0 0 1-1.991-1.819l-.637-7a2 2 0 0 1 .342-1.31L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3m-8.322.12q.322-.119.684-.12h5.396l-.707-.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981z" />
                </svg>
            </div>
            <div class="dash-card dash-4">
                <h5 style="display: flex; flex-direction: column; gap: 0.4rem;">TOTAL UPLOADS:<br><span style="font-size: 25px;">{{ $totalUploads->count() }}</span> </h5>
                <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-building-fill card-icon" viewBox="0 0 16 16">
                    <path d="M3 0a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h3v-3.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V16h3a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1zm1 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5M4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM7.5 5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5m2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM4.5 8h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5m2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5" />
                </svg>
            </div>
        </div>

        

        <div class="notif-box d-flex" style="margin-top: 1rem;">
            <span style="color: gray;">Notifications</span>
            @forelse($notifs as $notif)
            <div class="notif-content d-flex">
                @if ($notif->is_read == true)
                <div class="notif-indicator bg-gray"></div>
                @else
                <div class="notif-indicator bg-success"></div>
                @endif
                <div class="notif-message d-flex">
                    <div class="d-flex" style="flex-direction: column; gap: 0.3rem; width: 450px; flex-wrap: wrap;">
                        <h4 style="color:#252525;">{{ $notif->type }}</h4>
                        <p style="font-size: 14px; color: #5c5c5c;">{{ $notif->message }}</p>
                    </div>
                    <div class="d-flex" style="flex-direction: column; gap: 0.3rem; justify-content: left; text-align: left; width: 200px; flex-wrap: wrap;">
                        &nbsp;
                        <p style="font-size: 14px; color: #5c5c5c; align-self: left;">user: {{$notif->user->lname}}, {{$notif->user->fname}}</p>
                    </div>
                    <div class="d-flex" style="flex-direction: column; gap: 0.3rem; justify-content: left; text-align: left; width: 200px; flex-wrap: wrap;">
                        &nbsp;
                        @if($notif->documents->document)
                        <p style="font-size: 14px; color: #5c5c5c; align-self: left;">Document: {{$notif->documents->document->id}}</p>
                        @else
                        <p style="font-size: 14px; color: #5c5c5c; align-self: left;">No document associated</p>
                        @endif
                    </div>
                    <div class="d-flex" style="gap: 0.5rem;">
                        <a onclick="markasRead('{{ $notif->id }}')">
                            <h5>Mark as read</h5>
                        </a>
                        <!-- <a href="javascript:void(0)" class="view-button" data-id="{{ $notif->id }}" data-type="{{ $notif->type }}" data-message="{{ $notif->message }}" data-is-read="{{ $notif->is_read }}">
                                <h5>View</h5>
                            </a> -->
                    </div>
                </div>
            </div>
            @empty
            <div class="notif-content d-flex">
                <div class="notif-indicator bg-success"></div>
                <div class="notif-message d-flex">
                    <div class="d-flex" style="flex-direction: column; gap: 0.3rem; ">
                        <h4></h4>
                        <p style="font-size: 14px;">No new notifications.</p>
                    </div>
                </div>
            </div>
            @endforelse
        </div>



        <div class="body-content d-flex row">
            <div class="chart1">
                <canvas id="myChart" width="1000" height="525"></canvas>
            </div>
            &nbsp;
            <div class="container chart-detail row">
                <div class="container">
                    <p class="fs-2 fw-2">Number of approved request</p>
                    <span> number something something </span>
                </div>
                <div class="container">
                    <p class="fs-2 fw-2">Number of document versions</p>
                    <span> number something something </span>
                </div>
                <div class="container">
                    <p class="fs-2 fw-2">Number of con-current requests</p>
                    <span> number something something </span>
                </div>
            </div>
        </div>
    </div>





</div>
<!-- -->


<form action="{{ route('mark.read') }}" id='markread' method="POST">
    @CSRF
    <input type="hidden" value="" name="markAsRead" id="markAsRead">
</form>



@endsection


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


@if (session('success'))
<script>
    toastr.success('{{ session('
        success ') }}', 'Success');
</script>
@endif
@if (session('fail'))
<script>
    toastr.error('{{ session('
        fail ') }}', $message);
</script>
@endif



<script>
    const monthsWithData = {
        !!json_encode($totalUploadsByMonth - > pluck('month')) !!
    };
    const uploadCounts = {
        !!json_encode($totalUploadsByMonth - > pluck('total_uploads')) !!
    };

    const generateMonthLabels = () => {
        const currentYear = new Date().getFullYear();
        const monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
        const allMonths = [];
        const formattedMonths = [];
        for (let i = 1; i <= 12; i++) {
            const month = i < 10 ? '0' + i : i;
            const formattedMonth = `${currentYear}-${month}`;
            const label = `${monthLabels[i - 1]} ${currentYear}`;
            allMonths.push(label);
            formattedMonths.push(formattedMonth);
        }
        return {
            labels: allMonths,
            formattedMonths: formattedMonths
        };
    };

    const mapMonthsWithData = () => {
        const map = new Map();
        allMonths.forEach((monthLabel, index) => {
            const formattedMonth = formattedMonths[index];
            const countIndex = monthsWithData.indexOf(formattedMonth);
            if (countIndex !== -1) {
                map.set(monthLabel, uploadCounts[countIndex]);
            } else {
                map.set(monthLabel, 0);
            }
        });
        return map;
    };


    const {
        labels: allMonths,
        formattedMonths
    } = generateMonthLabels();

    const monthsWithDataMap = mapMonthsWithData();
    var ctx = document.getElementById('myChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: allMonths,
            datasets: [{
                label: 'Total Number of Uploads',
                data: Array.from(monthsWithDataMap.values()), // Using values from the map
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            responsive: true,
            maintainAspectRatio: true,
            legend: {
                display: false // Hide the default legend
            }
        }
    });
</script>
<script>
    function markasRead(id) {
        var form = document.getElementById('markread');
        var inputform = document.getElementById('markAsRead');
        inputform.value = id;
        form.submit();
    }
</script>

@endsection