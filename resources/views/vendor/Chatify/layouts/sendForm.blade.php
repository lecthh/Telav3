<div class="messenger-sendCard">
    <form id="message-form" method="POST" action="{{ route('chatify.send') }}" enctype="multipart/form-data">
        @csrf
        <div class="attachment-preview"></div>
        <label>
            <span class="fas fa-plus-circle"></span>
            <input type="file" class="upload-attachment" name="file" 
                accept=".{{implode(', .',config('chatify.attachments.allowed_images'))}}, .{{implode(', .',config('chatify.attachments.allowed_files'))}}" />
        </label>
        <button class="emoji-button"><span class="fas fa-smile"></span></button>
        <textarea name="message" class="m-send app-scroll" placeholder="Type a message.."></textarea>
        <button class="send-button"><span class="fas fa-paper-plane"></span></button>
    </form>
</div>
