<div x-data="chatSystem()" x-init="init()" wire:ignore class="fixed bottom-4 right-4 z-50">
    <!-- Floating Chat Button -->
    <button
        @click="open = true"
        x-show="!open"
        x-transition
        class="bg-blue-500 text-white p-5 text-2xl rounded-full shadow-lg hover:bg-blue-600 transition">
        💬
    </button>

    <!-- Chat Box -->
    <div x-show="open" x-transition
        class="absolute bottom-0 right-0 w-[40vw] h-[60vh] bg-white rounded-md shadow-lg border border-gray-300 flex flex-col">
        <div class="flex justify-between rounded-tl-md rounded-tr-md items-center border-b p-3 bg-gray-100">
            <h2 class="text-lg font-semibold">Chat</h2>
            <button @click="open = false" class="text-gray-500 hover:text-gray-700 text-lg">✖</button>
        </div>

        <!-- Chat Content -->
        <div class="flex flex-1">
            <!-- If authenticated, show full chat UI -->
            <template x-if="currentUserId">
                <div class="flex w-full">
                    <!-- Left Sidebar: Users -->
                    <div class="w-1/3 bg-gray-100 p-3 rounded-md border-r">
                        <div class="relative mb-2">
                            <input type="text"
                                x-model="searchQuery"
                                placeholder="Search for users..."
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                        <ul class="space-y-2 text-sm overflow-y-auto">
                            <template x-for="(user, index) in filteredUsers" :key="user.id || index">
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

                    <!-- Right Side: Chat Area -->
                    <div class="w-2/3 flex flex-col h-full">
                        <!-- Messages Container -->
                        <div class="flex-1 max-h-[50vh] overflow-y-auto p-2 space-y-2 w-full"
                            x-ref="chatContainer"
                            x-init="$nextTick(() => { 
                                let chatContainer = $refs.chatContainer; 
                                if (chatContainer) chatContainer.scrollTop = chatContainer.scrollHeight; 
                            })">
                            <template x-for="(message, index) in messages" :key="message.id + '-' + index">
                                <div :class="message.from_id == currentUserId ? 'bg-blue-500 text-white ml-auto' : 'bg-gray-100'"
                                    class="p-2 rounded-md text-sm max-w-[60%] w-fit">
                                    <span x-text="message.body"></span>
                                </div>
                            </template>
                        </div>

                        <!-- Chat Input -->
                        <form @submit.prevent="sendMessage()">
                            @csrf
                            <div class="p-2 border-t flex">
                                <input type="text" x-model="newMessage" placeholder="Type a message..."
                                    class="w-full border rounded-l-md px-3 py-1 focus:outline-none">
                                <button type="submit"
                                    class="bg-blue-500 text-white px-4 py-1 rounded-r-md hover:bg-blue-600 text-lg">
                                    ➤
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </template>

            <!-- If not authenticated, show a sign-in prompt inside the chat box -->
            <template x-if="!currentUserId">
                <div class="flex items-center justify-center flex-1">
                    <p class="text-center">Sign in / Sign up to start chatting</p>
                </div>
            </template>
        </div>
    </div>

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("chatSystem", () => ({
                open: false,
                searchQuery: "",
                users: [],
                messages: [],
                currentChatUser: null,
                newMessage: "",
                // Set currentUserId from Laravel; if not authenticated, this will be falsy.
                currentUserId: "{{ auth()->id() }}",
                channelSubscription: null,

                // Initialize the component.
                init() {
                    if (this.currentUserId) {
                        this.fetchUsers();
                    }
                },

                async fetchUsers() {
                    try {
                        const response = await fetch("/chat/users");
                        this.users = await response.json();
                    } catch (error) {
                        console.error("Error fetching users:", error);
                    }
                },

                async startChat(user) {
                    this.currentChatUser = user;
                    console.log("Current Chat User:", this.currentChatUser);
                    try {
                        const response = await fetch(`/chat/messages/${user.id}`);
                        this.messages = await response.json();
                        this.markMessagesAsSeen();
                    } catch (error) {
                        console.error("Error fetching messages:", error);
                    }
                    this.$nextTick(() => {
                        let chatContainer = this.$refs.chatContainer;
                        if (chatContainer) chatContainer.scrollTop = chatContainer.scrollHeight;
                    });

                    const sortedIds = [String(this.currentUserId), String(this.currentChatUser.id)].sort();
                    const channelName = `chat.${sortedIds[0]}.${sortedIds[1]}`;
                    console.log("Subscribing to channel:", channelName);

                    // Unsubscribe any existing subscription before subscribing again.
                    if (this.channelSubscription) {
                        this.channelSubscription.stopListening('.message.sent');
                    }

                    this.channelSubscription = window.Echo.private(channelName)
                        .listen(".message.sent", (event) => {
                            console.log("New message received:", event.message);
                            if (!this.messages.some(m => m.id === event.message.id)) {
                                this.messages.push(event.message);
                                if (event.message.to_id == this.currentUserId && !event.message.seen) {
                                    this.markMessageAsSeen(event.message);
                                }
                            }
                            this.$nextTick(() => {
                                let chatContainer = this.$refs.chatContainer;
                                if (chatContainer) chatContainer.scrollTop = chatContainer.scrollHeight;
                            });
                        });
                },
                markMessagesAsSeen() {
                    this.messages.forEach(message => {
                        if (message.to_id == this.currentUserId && !message.seen) {
                            this.markMessageAsSeen(message);
                        }
                    });
                },
                markMessageAsSeen(message) {
                    fetch(`/chat/mark-as-seen/${message.id}`, {
                            method: 'PATCH',
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log("Message marked as seen:", message.id);
                            message.seen = true;
                        })
                        .catch(error => console.error("Error marking message as seen", error));
                },

                async sendMessage() {
                    if (this.newMessage.trim() === "") return;
                    try {
                        const response = await fetch("/chat/send/message", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                            },
                            body: JSON.stringify({
                                to_id: this.currentChatUser.id,
                                body: this.newMessage
                            }),
                        });
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        const message = await response.json();
                        this.messages.push(message);
                        this.newMessage = "";
                        this.$nextTick(() => {
                            let chatContainer = this.$refs.chatContainer;
                            if (chatContainer) {
                                chatContainer.scrollTop = chatContainer.scrollHeight;
                            } else {
                                console.error("Chat container not found.");
                            }
                        });
                    } catch (error) {
                        console.error("Error sending message:", error);
                    }
                },

                get filteredUsers() {
                    return this.searchQuery ?
                        this.users.filter(user =>
                            user.name.toLowerCase().includes(this.searchQuery.toLowerCase())) :
                        this.users;
                }
            }));
        });
    </script>