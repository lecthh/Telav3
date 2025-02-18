<button x-data
    @click="$store.chatSystem.open = true; $store.chatSystem.startChat({ id: '{{ $user->user_id }}' })"
    class="bg-cPrimary text-white px-2 py-1 rounded ">
    💬
</button>