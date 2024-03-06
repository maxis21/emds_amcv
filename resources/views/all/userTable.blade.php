<div class="box-con">
    <!-- -->
    <div class="table-box">
        <!-- -->
        <div class="table-wrap">
            <!-- -->
            <table id="dataTable" class="table-content display">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Username</th>
                        <th>Fullname</th>
                        <th>Department</th>
                        <th>Date registered</th>
                        <th style="max-width: 10px"></th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($users))
                        @foreach ($users as $collection)
                            @php
                                $color = 'none';
                                if (!$collection->isActive) {
                                    # code...
                                    $color ='#dddddd';
                                }
                            @endphp
                            <tr style="background-color: {{$color}}">
                                @if ($collection->isActive)
                                    <td style="width: 25px">
                                        <p id="idActive{{ $collection->id }}" class="rounded-pill bg-success"
                                            style="text-align: center; padding: 5px"> Active </p>
                                    </td>
                                @else
                                    <td style="width: 25px">
                                        <p id="idActive{{ $collection->id }}" class="rounded-pill"
                                            style="text-align: center; padding: 5px; background-color: rgb(180, 180, 180); color: whitesmoke">
                                            Disabled </p>
                                    </td>
                                @endif
                                <td>{{ $collection->username }}</td>
                                @php
                                    $fullname =
                                        $collection->fname . ' ' . $collection->mname . ' ' . $collection->lname;
                                @endphp
                                <td>{{ $fullname }}</td>
                                <td>{{ $collection->department->name }}</td>
                                <td>{{ date('d M Y', strtotime($collection->created_at)) }}</td>
                                <td style="align-content: center">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle action-button" role="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-three-dots-vertical"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                            </svg>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <ul>
                                                <a href="">
                                                    <li>View info</li>
                                                </a>
                                                <a href="">
                                                    <li>Edit</li>
                                                </a>
                                                <form action="{{ route('to.Set') }}" method="POST"
                                                    id="formUser{{ $collection->id }}">
                                                    @csrf
                                                    <input type="hidden" value="{{ $collection->id }}" name="id">
                                                    <input type="hidden"
                                                        value="{{ $collection->isActive == 1 ? 0 : 1 }}" name="status">
                                                </form>
                                                <a onclick="submitForm('{{ $collection->id }}')">
                                                    @if ($collection->isActive)
                                                        <li>Disable</li>
                                                    @else
                                                        <li>Enable</li>
                                                    @endif
                                                </a>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <!-- -->
        </div>
        <!-- -->
    </div>
    <!-- -->
</div>
