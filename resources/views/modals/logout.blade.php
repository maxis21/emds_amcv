<div id="logout-account" class="logout-account">
    <div class="modal">
        <div class="header-modal">
            <p>Logout</p>
            <!-- Close Layout - Commented -->
            <!-- <span class="modal-close" onclick="location.href='#'">&times;</span> --> 
        </div>
        <div class="modal-content d-flex">
            <p>Are you sure you want to logout?</p>
        </div>
        <div class="modal-footer bg-info">
            <a style="text-decoration: none" class="btn bg-success btn-success-hover" href="{{route('to.Logout')}}">Yes</a>
            <a style="text-decoration: none" class="btn bg-danger btn-danger-hover" onclick="location.href=''">No</a>
        </div>
    </div>
</div>
