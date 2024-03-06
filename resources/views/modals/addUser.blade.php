<div id="add-account" class="add-account">
    <div class="modal">
        <div class="header-modal">
            <p>Add User Account</p>
            <!-- Close Layout - Commented -->
            <!-- <span class="modal-close" onclick="location.href='#'">&times;</span> -->
        </div>
        <div class="modal-content">
            <form action="{{ route('to.Add') }}" method="POST">
                @csrf
                @method('POST')
                <div class="d-flex" style="gap: 0.5rem;">
                    <div class="form-group">
                        <label for="First-Name" class="form-label">First Name</label>
                        <input type="text" class="form-control" name="fname" id="fname" required>
                    </div>
                    <div class="form-group">
                        <label for="Middle-Name" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" name="mname" id="mname" required>
                    </div>
                    <div class="form-group">
                        <label for="Last-Name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="lname" id="lname" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="role" class="form-label">Department</label>
                    <select style="height: 38px; padding-left: 0.5rem;" name="department" id="department"
                        class="form-control">
                        @foreach ($departments as $dept)
                        <option value="{{$dept->id}}">{{$dept->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="role" class="form-label">Role</label>
                    <select style="height: 38px; padding-left: 0.5rem;" name="role" id="role"
                        class="form-control">
                        <option value="3">Super Admin</option>
                        <option value="2">Admin</option>
                        <option value="1">User</option>
                    </select>
                </div>
        </div>
        <div class="modal-footer">
            <button class="btn bg-success btn-success-hover" type="submit">Yes</button>
            </form>
            <button class="btn bg-danger btn-danger-hover" onclick="location.href=''">No</button>
        </div>
    </div>
</div>
