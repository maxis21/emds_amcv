<div id="add-account" class="add-account">
    <div class="modal">
        <div class="header-modal">
            <p>Logout</p>
            <!-- Close Layout - Commented -->
            <!-- <span class="modal-close" onclick="location.href='#'">&times;</span> --> 
        </div>
        <div class="modal-content">
            <p>Add User Account</p>
        </div>
        <div class="modal-footer">
            <form action="{{route('to.Add')}}" method="POST">
                @csrf
                <button class="btn bg-success btn-success-hover" type="submit">Yes</button>
            </form>
            <button class="btn bg-danger btn-danger-hover" onclick="location.href=''">No</button>
        </div>
    </div>
</div>
