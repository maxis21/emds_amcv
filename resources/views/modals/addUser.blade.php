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
                <div class="d-flex" style="gap: 0.5rem;">
                    <div class="form-group">
                        <label for="First-Name" class="form-label">First Name</label>
                        <input type="text" class="form-control" name="fname" id="fname">
                    </div>
                    <div class="form-group">
                        <label for="Middle-Name" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" name="mname" id="mname">
                    </div>
                    <div class="form-group">
                        <label for="Last-Name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="lname" id="lname">
                    </div>
                </div>
                <div class="form-group">
                    <label for="role" class="form-label">Department</label>
                    <select style="height: 38px; padding-left: 0.5rem;" name="department" id="department" class="form-control">
                        <option value="super-admin">Super Admin</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="role" class="form-label">Role</label>
                    <select style="height: 38px; padding-left: 0.5rem;" name="userrole" id="userrole" class="form-control">
                        <option value="super-admin">Super Admin</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="Username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="username">
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="form-group">
                        <input type="password" name="password" id="password" class="form-control">
                        <a class="password" onclick="togglePasswordShow()" style="text-decoration: none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" id="password-btnShow" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16">
                                <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z" />
                                <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829" />
                                <path d="M3.35 5.47q-.27.24-.518.487A13 13 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7 7 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z" />
                            </svg>
                        </a>
                    </div>
                </div>

        </div>
        <div class="modal-footer">
            <button class="btn bg-success btn-success-hover" type="submit">Yes</button>
            </form>
            <button class="btn bg-danger btn-danger-hover" onclick="location.href=''">No</button>
        </div>
    </div>
</div>