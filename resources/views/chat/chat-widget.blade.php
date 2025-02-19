<div x-data x-init="$store.chatSystem.init()" x-cloak wire:ignore>
    <!-- Floating Chat Button -->
    <button
        @click="$store.chatSystem.open = true"
        x-show="!$store.chatSystem.open"
        x-transition
        class="fixed bottom-4 right-4 z-50 bg-blue-500 text-white p-5 text-2xl rounded-full shadow-lg hover:bg-blue-600 transition">
        💬
    </button>

    <!-- Chat Box -->
    <div x-show="$store.chatSystem.open" x-transition class="fixed bottom-4 right-4 z-50 w-[40vw] ">
        <div class="flex flex-col bg-white border border-gray-300 rounded-md shadow-lg overflow-hidden h-[80vh] sm:h-[60vh]">
            <!-- Header -->
            <div class="flex justify-between items-center p-3 bg-gray-100 border-b">
                <h2 class="text-lg font-semibold">Chat</h2>
                <button @click="$store.chatSystem.open = false" class="text-gray-500 hover:text-gray-700 text-lg">
                    ✖
                </button>
            </div>

            <div class="flex flex-1 overflow-hidden">
                <div class="w-1/3 border-r bg-gray-50 p-3 hidden md:block">
                    <div class="relative mb-2">
                        <input type="text"
                            x-model="$store.chatSystem.searchQuery"
                            placeholder="Search for users..."
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" />
                    </div>
                    <ul class="space-y-2 text-sm overflow-y-auto h-full">
                        <template x-for="(user, index) in $store.chatSystem.filteredUsers" :key="user.id || index">
                            <li @click="$store.chatSystem.startChat(user)"
                                class="p-2 bg-white rounded-md hover:bg-gray-200 cursor-pointer flex items-center space-x-2">
                                <img :src="user.avatar" class="w-8 h-8 rounded-full" alt="User Avatar">
                                <div class="flex-1">
                                    <div class="flex justify-between items-center">
                                        <span class="font-semibold" x-text="user.name"></span>
                                        <span class="text-xs text-gray-500" x-text="user.lastMessageDate"></span>
                                    </div>
                                    <div class="flex items-center">
                                        <p class="text-gray-500 text-xs truncate" x-text="user.lastMessage"></p>
                                        <template x-if="user.unreadCount > 0">
                                            <span class="ml-2 bg-red-500 text-white text-xs rounded-full px-2" x-text="user.unreadCount"></span>
                                        </template>
                                    </div>
                                </div>
                            </li>
                        </template>
                    </ul>
                </div>

                <div class="flex flex-col w-full md:w-2/3">
                    <div class="flex-1 overflow-y-auto p-2 space-y-2" x-ref="chatContainer"
                        x-init="$nextTick(() => { if ($refs.chatContainer) $refs.chatContainer.scrollTop = $refs.chatContainer.scrollHeight; })">
                        <template x-for="(message, index) in $store.chatSystem.messages" :key="message.id + '-' + index">
                            <div :class="message.from_id == $store.chatSystem.currentUserId ? 'flex justify-end' : 'flex justify-start'">
                                <div :class="message.from_id == $store.chatSystem.currentUserId ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-800'"
                                    class="p-2 rounded-md text-sm max-w-[70%] break-words">
                                    <span x-text="message.body"></span>
                                    <template x-if="message.attachment">
                                        <div class="mt-2">
                                            <template x-if="/\.(jpe?g|png|gif)$/i.test(message.attachment)">
                                                <img :src="`/storage/${message.attachment}`"
                                                    class="max-w-full h-auto rounded border"
                                                    alt="Attachment" />
                                            </template>
                                            <template x-if="!/\.(jpe?g|png|gif)$/i.test(message.attachment)">
                                                <a :href="`/storage/${message.attachment}`"
                                                    target="_blank"
                                                    class="text-blue-600 underline">View Attachment</a>
                                            </template>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="p-2 border-t">
                        <form @submit.prevent="$store.chatSystem.sendMessage()" class="flex items-center space-x-2">
                            <input type="text"
                                x-model="$store.chatSystem.newMessage"
                                placeholder="Type a message..."
                                class="flex-1 border rounded-l-md px-3 py-2 focus:outline-none" />

                            <input type="file"
                                @change="$store.chatSystem.handleFileSelected($event)"
                                class="hidden"
                                id="attachmentInput"
                                accept="image/*, .pdf, .doc, .docx" />

                            <label for="attachmentInput"
                                class="bg-gray-300 text-gray-800 px-3 py-2 text-lg cursor-pointer rounded-md">
                                📎
                            </label>

                            <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded-r-md hover:bg-blue-600 text-lg">
                                ➤
                            </button>
                        </form>

                        <template x-if="$store.chatSystem.selectedFile">
                            <div class="mt-2 flex items-center bg-white border rounded-md p-2 shadow-sm">
                                <template x-if="$store.chatSystem.filePreviewUrl">
                                    <img :src="$store.chatSystem.filePreviewUrl"
                                        class="w-16 h-16 object-cover rounded"
                                        alt="Preview" />
                                </template>
                                <template x-if="!$store.chatSystem.filePreviewUrl">
                                    <div class="text-sm ml-2">
                                        <strong>File:</strong> <span x-text="$store.chatSystem.selectedFile.name"></span>
                                    </div>
                                </template>
                                <button type="button"
                                    @click="$store.chatSystem.removeSelectedFile()"
                                    class="ml-auto text-red-500 font-bold">
                                    ✕
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener("alpine:init", () => {
        Alpine.store("chatSystem", {
            open: false,
            searchQuery: "",
            users: [],
            messages: [],
            currentChatUser: null,
            newMessage: "",
            currentUserId: "{{ auth()->id() }}",
            channelSubscription: null,
            selectedFile: null,

            init() {
                if (this.currentUserId) {
                    this.fetchUsers();
                    setInterval(() => {
                        this.fetchUsers();
                    }, 30000);
                }
            },


            async fetchUsers() {
                try {
                    const response = await fetch("/chat/users");
                    this.users = await response.json();
                    console.log(this.users);
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

                setTimeout(() => {
                    let chatContainer = document.querySelector('[x-ref="chatContainer"]');
                    if (chatContainer) {
                        chatContainer.scrollTop = chatContainer.scrollHeight;
                    }
                }, 0);

                const sortedIds = [String(this.currentUserId), String(this.currentChatUser.id)].sort();
                const channelName = `chat.${sortedIds[0]}.${sortedIds[1]}`;
                console.log("Subscribing to channel:", channelName);

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
                        this.fetchUsers();
                        setTimeout(() => {
                            let chatContainer = document.querySelector('[x-ref="chatContainer"]');
                            if (chatContainer) {
                                chatContainer.scrollTop = chatContainer.scrollHeight;
                            }
                        }, 0);
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


            handleFileSelected(event) {
                const file = event.target.files[0];
                if (file) {
                    this.selectedFile = file;

                    if (file.type.match(/^image\//)) {
                        this.filePreviewUrl = URL.createObjectURL(file);
                    } else {
                        this.filePreviewUrl = null;
                    }
                }
            },

            removeSelectedFile() {
                this.selectedFile = null;
                this.filePreviewUrl = null;
                document.getElementById('attachmentInput').value = "";
            },

            async sendMessage() {
                if (!this.currentChatUser) return;

                const formData = new FormData();
                formData.append('to_id', this.currentChatUser.id);
                formData.append('body', this.newMessage);
                if (this.selectedFile) {
                    formData.append('attachment', this.selectedFile);
                }

                try {
                    const response = await fetch("/chat/send/message", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                        },
                        body: formData
                    });
                    if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

                    const message = await response.json();
                    this.messages.push(message);

                    this.newMessage = "";
                    this.removeSelectedFile();

                    setTimeout(() => {
                        let chatContainer = document.querySelector('[x-ref="chatContainer"]');
                        if (chatContainer) {
                            chatContainer.scrollTop = chatContainer.scrollHeight;
                        }
                    }, 0);
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
        });
    });
</script>