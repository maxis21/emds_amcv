<div id="logout-account" class="logout-account">
    <div class="modal">
        <div class="header-modal">
            <p>Logout</p>
            <!-- Close Layout - Commented -->
            <!-- <span class="modal-close" onclick="location.href='#'">&times;</span> --> 
        </div>
        <div class="modal-content">
            <p>Are you sure you want to logout?</p>
        </div>
        <div class="modal-footer">
            <a class="btn bg-success btn-success-hover" type="submit" href="{{route('to.Logout')}}">Yes</a>
            <a class="btn bg-danger btn-danger-hover" onclick="location.href=''">No</a>
        </div>
    </div>
</div>
