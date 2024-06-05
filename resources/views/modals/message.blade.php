<div id="create-message" class="create-message">
    <div class="modal">
        <div class="header-modal">
            <p>Message</p>
            <!-- Close Layout - Commented -->
            <span class="modal-close">&times;</span>
        </div>
        <div class="modal-content">
            <form method="POST">
            @csrf
            @method('PUT')
                <textarea name="message" id="message" style="width: 100%; color: #525252; outline: none; border: 1px solid #9a9a9a;"></textarea>
        </div>
        <div class="modal-footer">
                <button class="btn btnCustom" type="submit" style="font-weight: bold;">Submit</button>
            </form>
        </div>
    </div>
</div>