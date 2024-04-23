<div id="create-file" class="create-file">
    <div class="modal">
        <div class="header-modal">
            <p>Create Folder</p>
            <!-- Close Layout - Commented -->
            <span class="modal-close">&times;</span>
        </div>
        <div class="modal-content">
            @php
            $roleName = Auth::user()->role->role->name;
            if($roleName == "user")
            {
            $thisRoute = "route('user.upload.file')";
            }
            else
            {
            $thisRoute = route('create.folder');
            }
            @endphp
            <form action="{{ $thisRoute }}" method="POST" enctype="multipart/form-data">
                @method('POST')
                @csrf
                <div class="form-group">
                    <input type="hidden" name="parent_id" class="form-control" placeholder="Enter Parent ID" type="number" value="">
                    <input name="name" class="form-control" placeholder="Enter folder name" type="text" style="margin-bottom: 0.5rem;" required>
                    <select name="dptFolder" class="form-control" placeholder="Enter folder name">
                        <option value="" selected>Department</option>
                        @foreach($departments as $department)
                        <option value="{{$department->id}}">{{$department->name}}</option>
                        @endforeach
                    </select>
                </div>
        </div>
        <div class="modal-footer">
            <button class="btn btnCustom" type="submit" style="font-weight: bold;">Create</button>
            </form>
        </div>
    </div>
</div>