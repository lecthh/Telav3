<button
    @click="$store.chatSystem.open = true; $store.chatSystem.startChat({ id: '{{ $user->user_id }}' })"
    class="w-10 h-10 flex items-center justify-center rounded-full transition-colors duration-200 hover:bg-cPrimary hover:bg-opacity-20 hover:text-white focus:outline-none mx-2"
    aria-label="Start Chat">
    @include('svgs.chat-bubble')
</button>