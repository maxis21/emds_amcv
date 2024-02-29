<div id="add-department" class="add-department">
    <div class="modal">
        <div class="header-modal">
            <p>Add Department</p>
            <!-- Close Layout - Commented -->
            <!-- <span class="modal-close" onclick="location.href='#'">&times;</span> -->
        </div>
        <div class="modal-content">
            <form action="{{ route('add.dept') }}" method="POST">
                @method('POST')
                @csrf
                <div class="form-group d-flex dept-form">
                    <label for="">Name: </label>
                    <input class="form-control" name="name" type="text" required>
                </div>
        </div>
        <div class="modal-footer">


                <button class="btn bg-success btn-success-hover" type="submit">Submit</button>
            </form>
            <button class="btn bg-danger btn-danger-hover" onclick="location.href=''">Cancel</button>
        </div>
    </div>
</div>