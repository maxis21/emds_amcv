<div id="add-doc" class="add-doc">
    <div class="modal">
        <div class="header-modal">
            <p>Add File</p>
            <!-- Close Layout - Commented -->
            <!-- <span class="modal-close" onclick="location.href='#'">&times;</span> -->
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
                    $thisRoute = route('upload.file');
                }
            @endphp
            <form action="{{ $thisRoute }}" method="POST" enctype="multipart/form-data">
                @method('POST')
                @csrf
                <div class="form-group">
                    <label class="form-label" for="name">Name:</label>
                    <input name="name" class="form-control" type="text" required>
                </div>
                <div class="file-upload">
                    <input type="file" id="doc" name="docfile" accept=".pdf" style="display:none;" required>
                    <label for="doc" class="upload-btn">Upload a file</label>
                    <span id="file-chosen">No file chosen</span>
                </div>
        </div>
        <div class="modal-footer">


            <button class="btn bg-success btn-success-hover" type="submit">Submit</button>
            </form>
            <button class="btn bg-danger btn-danger-hover" onclick="location.href=''">Cancel</button>
        </div>
    </div>
</div>