<div x-data="{ open: false }" class="fixed bottom-4 right-4 z-50">
    <button
        @click="open = !open"
        class="bg-blue-500 text-white p-4 rounded-full shadow-lg hover:bg-blue-600 transition">
        💬
    </button>

    <div x-show="open" x-transition
        class="absolute bottom-16 right-0 w-80 bg-white rounded-lg shadow-lg p-4 border border-gray-300">
        <div class="flex justify-between items-center border-b pb-2">
            <h2 class="text-lg font-semibold">Chat</h2>
            <button @click="open = false" class="text-gray-500 hover:text-gray-700">✖</button>
        </div>
        <div class="h-60 overflow-y-auto p-2 space-y-2">
            <div class="bg-gray-100 p-2 rounded-md text-sm">Hello! How can I help?</div>
            <div class="bg-blue-500 text-white p-2 rounded-md text-sm self-end">Hi! I need assistance.</div>
        </div>
        <div class="mt-2 flex">
            <input type="text" placeholder="Type a message..."
                class="w-full border rounded-l-md px-2 py-1 focus:outline-none">
            <button class="bg-blue-500 text-white px-3 py-1 rounded-r-md hover:bg-blue-600">
                ➤
            </button>
        </div>
    </div>
</div>