<div x-data="{ open: false }" class="fixed bottom-4 right-4 z-50">
    <button
        @click="open = true"
        x-show="!open"
        x-transition
        class="bg-blue-500 text-white p-5 text-2xl rounded-full shadow-lg hover:bg-blue-600 transition">
        💬
    </button>

    <div x-show="open" x-transition
        class="absolute bottom-0 right-0 w-[40vw] h-[60vh]  bg-white rounded-md shadow-lg border border-gray-300 flex flex-col">
        <div class="flex justify-between rounded-tl-md rounded-tr-md items-center border-b p-3 bg-gray-100">
            <h2 class="text-lg font-semibold">Chat</h2>
            <button @click="open = false" class="text-gray-500 hover:text-gray-700 text-lg">✖</button>
        </div>

        <div class="flex flex-1">
            <div x-data="{
        searchQuery: '',
        users: [],
        async fetchUsers() {
            try {
                const response = await fetch('/chat/users', {
                    headers: { 'Authorization': 'Bearer ' + localStorage.getItem('auth_token') }
                });
                this.users = await response.json();
            } catch (error) {
                console.error('Error fetching users:', error);
            }
        },
        get filteredUsers() {
            return this.searchQuery 
                ? this.users.filter(user => user.name.toLowerCase().includes(this.searchQuery.toLowerCase()))
                : this.users;
        },
        startChat(user) {
            alert(`Starting chat with ${user.name}`);
        }
    }"
                x-init="fetchUsers()"
                class="w-1/3 bg-gray-100 p-3 rounded-md border-r">

                <div class="relative mb-2">
                    <input type="text"
                        x-model="searchQuery"
                        placeholder="Search for users..."
                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <ul class="space-y-2 text-sm  overflow-y-auto">
                    <template x-for="user in filteredUsers" :key="user.id">
                        <li @click="startChat(user)"
                            class="p-2 bg-white rounded-md hover:bg-gray-200 cursor-pointer flex items-center space-x-2">
                            <img :src="user.avatar" class="w-8 h-8 rounded-full" alt="User Avatar">
                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <span class="font-semibold" x-text="user.name"></span>
                                    <span class="text-xs text-gray-500" x-text="user.lastMessageDate"></span>
                                </div>
                                <p class="text-gray-500 text-xs truncate w-full" x-text="user.lastMessage"></p>
                            </div>
                        </li>
                    </template>
                </ul>
            </div>


            <div class="w-2/3 flex flex-col">
                <div class="flex-1 overflow-y-auto p-2 space-y-2 w-full">
                    <div class="bg-gray-100 p-2 rounded-md text-sm max-w-[60%] w-fit">
                        Hello! How can I help?asdfas dfgasdfasdfasdfasdfas dfasfsdasdfasdfaasdfasdf
                    </div>
                    <div class="bg-blue-500 text-white p-2 rounded-md text-sm max-w-[60%] w-fit ml-auto">
                        Hi! I need assistance.
                    </div>
                </div>


                <div class="p-2 border-t flex">
                    <input type="text" placeholder="Type a message..."
                        class="w-full border rounded-l-md px-3 py-1 focus:outline-none">
                    <button class="bg-blue-500 text-white px-4 py-1 rounded-r-md hover:bg-blue-600 text-lg">
                        ➤
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>