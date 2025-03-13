<div x-data x-init="$store.chatSystem.init()" x-cloak wire:ignore>
    <!-- Floating Chat Button -->
    <button
        @click="$store.chatSystem.open = true"
        x-show="!$store.chatSystem.open"
        x-transition
        class="fixed bottom-4 right-4 z-50 bg-blue-500 text-white p-5 text-2xl rounded-full shadow-lg hover:bg-blue-600 transition">
        <template x-if="$store.chatSystem.totalUnreadCount > 0">
            <span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full" x-text="$store.chatSystem.totalUnreadCount"></span>
        </template>
        💬
    </button>

    <!-- Chat Box -->
    <div x-show="$store.chatSystem.open" x-transition class="fixed bottom-4 right-4 z-50 w-[40vw] ">
        <div class="flex flex-col bg-white border border-gray-300 rounded-md shadow-lg overflow-hidden h-[80vh] sm:h-[60vh]">
            <!-- Header -->
            <div class="flex justify-between items-center p-3 bg-gray-100 border-b">
                <h2 class="text-lg font-semibold">Chat</h2>
                <button @click="$store.chatSystem.closeChat()" class="text-gray-500 hover:text-gray-700 text-lg">
                    ✖
                </button>
            </div>
            <!-- Left side -->
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
                                :class="{
                'bg-blue-200': user.id == $store.chatSystem.currentChatUser?.id,
                'bg-white': user.id != $store.chatSystem.currentChatUser?.id
            }"
                                class="p-2 rounded-md hover:bg-gray-200 cursor-pointer flex items-center space-x-2">
                                <img :src="user.avatar" class="w-8 h-8 rounded-full" alt="User Avatar">
                                <div class="flex-1">
                                    <div class="flex justify-between items-center">
                                        <span class="font-semibold text-sm" x-text="user.name"></span>
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
                <!-- Right side -->
                <div class="flex flex-col w-full md:w-2/3">
                    <div class="flex-1 overflow-y-auto p-2 space-y-2 w-full"
                        id="chatContainer"
                        x-ref="chatContainer"
                        x-init="$nextTick(() => { if ($refs.chatContainer) $refs.chatContainer.scrollTop = $refs.chatContainer.scrollHeight; })">
                        <template x-if="$store.chatSystem.loadingMessages">
                            <div class="flex items-center justify-center h-full">
                                <x-spinner class="h-8 w-8 text-blue-500 mx-auto my-4" />
                            </div>
                        </template>
                        <template x-if="!$store.chatSystem.currentChatUser">
                            <div class="flex items-center justify-center h-5/6 text-gray-500">
                                Start chatting!
                            </div>
                        </template>
                        <template x-if="!$store.chatSystem.loadingMessages">
                            <template x-for="(message, index) in $store.chatSystem.messages" :key="message.id + '-' + index">
                                <div :class="message.from_id == $store.chatSystem.currentUserId ? 'flex justify-end' : 'flex justify-start'">
                                    <div :class="message.from_id == $store.chatSystem.currentUserId ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-800'"
                                        class="p-2 rounded-md text-sm max-w-[70%] break-words">
                                        <span x-text="message.body"></span>
                                        <!-- Attachment handling -->
                                        <template x-if="message.attachments && message.attachments.length">
                                            <div class="mt-2 space-y-2">
                                                <template x-for="(file, fileIndex) in message.attachments" :key="fileIndex">
                                                    <div>
                                                        <!-- If image: display clickable thumbnail -->
                                                        <template x-if="/\.(jpe?g|png|gif)$/i.test(file)">
                                                            <img :src="`/storage/${file}`"
                                                                class="max-w-full h-auto rounded border cursor-pointer"
                                                                alt="Attachment Image"
                                                                @click="$store.chatSystem.openModal(`/storage/${file}`)" />
                                                        </template>
                                                        <!-- If not image: display file icon and truncated file name -->
                                                        <template x-if="!/\.(jpe?g|png|gif)$/i.test(file)">
                                                            <a :href="`/storage/${file}`" target="_blank"
                                                                class="flex items-center border rounded p-2 hover:bg-gray-100"
                                                                :title="$store.chatSystem.getFileName(file)">
                                                                <!-- Inline file icon (SVG) -->
                                                                <svg class="w-4 h-4 text-gray-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path d="M4 2a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V8.414a2 2 0 00-.586-1.414l-3.414-3.414A2 2 0 0012.586 3H4z" />
                                                                </svg>
                                                                <span class="truncate" style="max-width: 150px;" x-text="$store.chatSystem.getFileName(file)"></span>
                                                            </a>
                                                        </template>
                                                    </div>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </template>
                    </div>


                    <div class="p-2 border-t">
                        <form @submit.prevent="$store.chatSystem.sendMessage()" class="flex items-center space-x-2">
                            <input type="text"
                                x-model="$store.chatSystem.newMessage"
                                placeholder="Type a message..."
                                class="flex-1 border rounded-l-md px-3 py-2 focus:outline-none" />

                            <input type="file" multiple
                                @change="$store.chatSystem.handleFileSelected($event)"
                                class="hidden"
                                id="attachmentInput"
                                accept="image/*, .pdf, .doc, .docx" />

                            <label for="attachmentInput"
                                class="bg-gray-300 text-gray-800 px-3 py-2 text-lg cursor-pointer rounded-md hover:bg-gray-400 transition-colors">
                                📎
                            </label>

                            <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded-r-md hover:bg-blue-600 text-lg"
                                :disabled="(!$store.chatSystem.newMessage.trim() && (!$store.chatSystem.selectedFile || $store.chatSystem.selectedFile.length === 0))">
                                ➤
                            </button>
                        </form>


                        <template x-if="$store.chatSystem.selectedFile && $store.chatSystem.selectedFile.length > 0">
                            <div class="mt-1 flex flex-wrap items-center bg-white border rounded-md p-2 shadow-sm space-x-2">
                                <template x-for="(file, index) in $store.chatSystem.selectedFile" :key="index">
                                    <div class="relative">
                                        <!-- If the file is an image, show an image preview that is clickable to open modal -->
                                        <template x-if="file.type && file.type.match(/^image\//)">
                                            <img :src="$store.chatSystem.filePreviewUrls[index]"
                                                class="w-16 h-16 object-cover rounded border cursor-pointer"
                                                alt="Preview Image"
                                                @click="$store.chatSystem.openModal($store.chatSystem.filePreviewUrls[index])" />
                                        </template>
                                        <!-- If not an image, show a file icon and file name -->
                                        <template x-if="!file.type || !file.type.match(/^image\//)">
                                            <div class="flex items-center border rounded p-2 hover:bg-gray-100">
                                                <!-- File icon -->
                                                <svg class="w-4 h-4 text-gray-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M4 2a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V8.414a2 2 0 00-.586-1.414l-3.414-3.414A2 2 0 0012.586 3H4z" />
                                                </svg>
                                                <!-- File name, truncated -->
                                                <span class="truncate" style="max-width: 150px;" x-text="$store.chatSystem.getFileName(file)"></span>
                                            </div>
                                        </template>
                                        <!-- Remove button for this file -->
                                        <button type="button"
                                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 text-xs"
                                            @click="$store.chatSystem.removeSelectedFileAt(index)">
                                            ✕
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </template>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<template x-data x-if="$store.chatSystem.showModal">
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75" @click="$store.chatSystem.closeModal()">
        <img :src="$store.chatSystem.modalImage"
            @click.stop
            class="max-w-full max-h-full rounded shadow-lg"
            alt="Expanded Attachment" />
    </div>
</template>

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
            loadingMessages: false,
            showModal: false,
            modalImage: null,

            init() {
                if (this.currentUserId) {
                    this.fetchUsers();
                    setInterval(() => {
                        this.fetchUsers();
                    }, 5000);
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
                this.loadingMessages = true; // Start loading indicator
                try {
                    const response = await fetch(`/chat/messages/${user.id}`);
                    this.messages = await response.json();
                    this.markMessagesAsSeen();
                    this.fetchUsers();
                } catch (error) {
                    console.error("Error fetching messages:", error);
                } finally {
                    this.loadingMessages = false; // Stop loading indicator
                }

                this.scrollChatContainer();

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
                        this.scrollChatContainer();
                    });
                this.scrollChatContainer();
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
                const files = Array.from(event.target.files);
                if (files.length > 0) {
                    this.selectedFile = files; // Array of File objects
                    this.filePreviewUrls = [];
                    files.forEach(file => {
                        if (file.type.match(/^image\//)) {
                            this.filePreviewUrls.push(URL.createObjectURL(file));
                        } else {
                            // For non-images, push null so we know not to render an image preview
                            this.filePreviewUrls.push(null);
                        }
                    });
                }
            },
            removeSelectedFileAt(index) {
                if (this.selectedFile && this.selectedFile.length > index) {
                    this.selectedFile.splice(index, 1);
                    this.filePreviewUrls.splice(index, 1);
                    if (this.selectedFile.length === 0) {
                        document.getElementById('attachmentInput').value = "";
                    }
                }
            },

            removeSelectedFile() {
                this.selectedFile = null;
                this.filePreviewUrls = null;
                document.getElementById('attachmentInput').value = "";
            },

            async sendMessage() {
                if (!this.currentChatUser) return;

                if ((!this.newMessage || !this.newMessage.trim()) && (!this.selectedFile || this.selectedFile.length === 0)) {
                    return;
                }
                const formData = new FormData();
                formData.append('to_id', this.currentChatUser.id);
                formData.append('body', this.newMessage);
                if (this.selectedFile && Array.isArray(this.selectedFile)) {
                    this.selectedFile.forEach(file => {
                        console.log(this.selectedFile);
                        formData.append('attachment[]', file);
                    });
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
                    console.log(message);
                    this.messages.push(message);

                    this.newMessage = "";
                    this.removeSelectedFile();

                    this.scrollChatContainer();
                } catch (error) {
                    console.error("Error sending message:", error);
                }
            },

            get filteredUsers() {
                return this.searchQuery ?
                    this.users.filter(user =>
                        user.name.toLowerCase().includes(this.searchQuery.toLowerCase())) :
                    this.users;
            },
            get totalUnreadCount() {
                return this.users.reduce((acc, user) => acc + (user.unreadCount || 0), 0);
            },

            closeChat() {
                this.open = false;
                if (this.channelSubscription) {
                    this.channelSubscription.stopListening('.message.sent');
                    this.channelSubscription = null;
                }
                this.currentChatUser = null;
                this.messages = [];
            },

            openModal(src) {
                this.modalImage = src;
                this.showModal = true;
            },
            closeModal() {
                this.showModal = false;
                this.modalImage = null;
            },

            getFileName(file) {
                // If file is a File object, return its name
                if (file && file.name) {
                    return file.name;
                }
                if (typeof file === 'string') {
                    return file.split('/').pop();
                }
                return 'File';
            },

            scrollChatContainer() {
                setTimeout(() => {
                    const chatContainer = document.getElementById('chatContainer');
                    if (chatContainer) {
                        chatContainer.scrollTop = chatContainer.scrollHeight;
                    }
                }, 100);
            },

        });
    });
</script>