<div x-data x-init="$store.chatSystem.init()" x-cloak wire:ignore>
    <!-- Floating Chat Button with more modern styling -->
    <button
        @click="$store.chatSystem.open = true"
        x-show="!$store.chatSystem.open"
        x-transition
        class="fixed bottom-6 right-6 z-50 bg-cPrimary text-white p-4 rounded-full shadow-lg hover:bg-[#9700fd] transition-all duration-300 flex items-center justify-center">
        <template x-if="$store.chatSystem.totalUnreadCount > 0">
            <span class="absolute -top-2 -right-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full" x-text="$store.chatSystem.totalUnreadCount"></span>
        </template>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
    </button>

    <!-- Chat Box Container with improved layout -->
    <div x-show="$store.chatSystem.open" x-transition.opacity.duration.300ms class="fixed bottom-6 right-6 z-50 w-11/12 sm:w-[450px] md:w-[600px] lg:w-[800px]">
        <div class="flex flex-col bg-white rounded-lg shadow-2xl overflow-hidden h-[80vh] sm:h-[70vh] border border-gray-200">
            <!-- Header with improved styling -->
            <div class="flex justify-between items-center p-4 bg-cPrimary text-white">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <h2 class="text-lg font-semibold">TEL-A Messages</h2>
                </div>
                <button @click="$store.chatSystem.closeChat()" class="text-white hover:bg-blue-700 rounded-full p-1 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Main Chat Area -->
            <div class="flex flex-1 overflow-hidden">
                <!-- Left sidebar - Contacts -->
                <div class="w-1/3 border-r bg-gray-50 flex flex-col hidden md:flex">
                    <div class="p-3 border-b">
                        <div class="relative">
                            <input type="text"
                                x-model="$store.chatSystem.searchQuery"
                                placeholder="Search contacts..."
                                class="w-full px-3 py-2 pl-10 border rounded-lg focus:outline-none focus:ring-2 focus:ring-cPrimary text-sm" />
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-2.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Contacts List -->
                    <div class="flex-1 overflow-y-auto">
                        <ul class="space-y-1 p-2">
                            <template x-for="(user, index) in $store.chatSystem.filteredUsers" :key="user.id || index">
                                <li @click="$store.chatSystem.startChat(user)"
                                    :class="{
                                        'bg-cSecondary bg-opacity-30 border-l-4 border-cPrimary': user.id == $store.chatSystem.currentChatUser?.id,
                                        'hover:bg-gray-100': user.id != $store.chatSystem.currentChatUser?.id
                                    }"
                                    class="p-3 rounded-md cursor-pointer flex items-center space-x-3 transition-all">
                                    <div class="relative">
                                        <img :src="user.avatar" class="w-10 h-10 rounded-full object-cover border border-gray-200" alt="User Avatar">
                                        <template x-if="user.unreadCount > 0">
                                            <span class="absolute -top-1 -right-1 bg-cAccent text-white text-xs rounded-full w-5 h-5 flex items-center justify-center" x-text="user.unreadCount"></span>
                                        </template>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between items-center">
                                            <span class="font-medium text-gray-900 truncate" x-text="user.name"></span>
                                            <span class="text-xs text-gray-500" x-text="user.lastMessageDate"></span>
                                        </div>
                                        <p class="text-gray-600 text-sm truncate" x-text="user.lastMessage"></p>
                                    </div>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>

                <!-- Right side - Chat Content -->
                <div class="flex flex-col w-full md:w-2/3 bg-gray-50">
                    <!-- Mobile view - show current chat user in header -->
                    <div x-show="$store.chatSystem.currentChatUser" class="md:hidden flex items-center space-x-3 p-3 border-b bg-white">
                        <button @click="$store.chatSystem.currentChatUser = null; $store.chatSystem.messages = []" class="text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <img :src="$store.chatSystem.currentChatUser?.avatar" class="w-8 h-8 rounded-full" alt="User Avatar">
                        <span class="font-medium text-gray-900" x-text="$store.chatSystem.currentChatUser?.name"></span>
                    </div>

                    <!-- Mobile view - show user list if no chat selected -->
                    <div x-show="!$store.chatSystem.currentChatUser" class="md:hidden flex flex-col h-full">
                        <div class="p-3 border-b">
                            <div class="relative">
                                <input type="text"
                                    x-model="$store.chatSystem.searchQuery"
                                    placeholder="Search contacts..."
                                    class="w-full px-3 py-2 pl-10 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm" />
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-2.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 overflow-y-auto">
                            <ul class="space-y-1 p-2">
                                <template x-for="(user, index) in $store.chatSystem.filteredUsers" :key="user.id || index">
                                    <li @click="$store.chatSystem.startChat(user)"
                                        class="p-3 rounded-md cursor-pointer flex items-center space-x-3 hover:bg-gray-100 transition-all">
                                        <div class="relative">
                                            <img :src="user.avatar" class="w-10 h-10 rounded-full object-cover border border-gray-200" alt="User Avatar">
                                            <template x-if="user.unreadCount > 0">
                                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center" x-text="user.unreadCount"></span>
                                            </template>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex justify-between items-center">
                                                <span class="font-medium text-gray-900 truncate" x-text="user.name"></span>
                                                <span class="text-xs text-gray-500" x-text="user.lastMessageDate"></span>
                                            </div>
                                            <p class="text-gray-600 text-sm truncate" x-text="user.lastMessage"></p>
                                        </div>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>

                    <!-- Chat Messages Container -->
                    <div class="flex-1 overflow-y-auto p-4 space-y-3 bg-white"
                        id="chatContainer"
                        x-ref="chatContainer"
                        x-show="$store.chatSystem.currentChatUser"
                        x-init="$nextTick(() => { if ($refs.chatContainer) $refs.chatContainer.scrollTop = $refs.chatContainer.scrollHeight; })">
                        <template x-if="$store.chatSystem.loadingMessages">
                            <div class="flex items-center justify-center h-full">
                                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-cPrimary"></div>
                            </div>
                        </template>

                        <template x-if="!$store.chatSystem.loadingMessages && $store.chatSystem.messages.length === 0">
                            <div class="flex flex-col items-center justify-center h-full text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                                <p>No messages yet. Start the conversation!</p>
                            </div>
                        </template>

                        <template x-if="!$store.chatSystem.loadingMessages">
                            <template x-for="(message, index) in $store.chatSystem.messages" :key="message.id + '-' + index">
                                <div :class="message.from_id == $store.chatSystem.currentUserId ? 'flex justify-end' : 'flex justify-start'" class="group">
                                    <div class="max-w-[75%] flex flex-col">
                                        <div :class="message.from_id == $store.chatSystem.currentUserId ? 'bg-cPrimary text-white rounded-tl-lg rounded-tr-lg rounded-bl-lg' : 'bg-gray-200 text-gray-800 rounded-tl-lg rounded-tr-lg rounded-br-lg'"
                                            class="px-4 py-2 shadow-sm">
                                            <p x-text="message.body" class="break-words"></p>
                                        </div>

                                        <!-- Time stamp shown on hover -->
                                        <div class="text-xs text-gray-500 mt-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <span x-text="new Date(message.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})"></span>
                                        </div>

                                        <!-- Attachment handling -->
                                        <template x-if="message.attachments && message.attachments.length">
                                            <div class="mt-2 space-y-2">
                                                <template x-for="(file, fileIndex) in message.attachments" :key="fileIndex">
                                                    <div :class="message.from_id == $store.chatSystem.currentUserId ? 'bg-cSecondary bg-opacity-20 border-cSecondary' : 'bg-gray-50 border-gray-200'" class="rounded-lg border p-2">
                                                        <!-- If image: display clickable thumbnail -->
                                                        <template x-if="/\.(jpe?g|png|gif)$/i.test(file)">
                                                            <div class="relative">
                                                                <img :src="`/storage/${file}`"
                                                                    class="max-w-full h-auto rounded-lg border cursor-pointer hover:opacity-90 transition-opacity"
                                                                    alt="Attachment Image"
                                                                    @click="$store.chatSystem.openModal(`/storage/${file}`)" />
                                                                <div class="absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                                                    <div class="bg-black bg-opacity-50 rounded-full p-2">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </template>

                                                        <!-- If not image: display file icon and truncated file name -->
                                                        <template x-if="!/\.(jpe?g|png|gif)$/i.test(file)">
                                                            <a :href="`/storage/${file}`" target="_blank"
                                                                class="flex items-center rounded-lg p-2 hover:bg-white transition-colors"
                                                                :title="$store.chatSystem.getFileName(file)">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cPrimary mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                </svg>
                                                                <span class="truncate" x-text="$store.chatSystem.getFileName(file)"></span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                                </svg>
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

                    <!-- Message Input Area -->
                    <div class="border-t bg-white p-3" x-show="$store.chatSystem.currentChatUser">
                        <!-- Selected File Preview -->
                        <template x-if="$store.chatSystem.selectedFile && $store.chatSystem.selectedFile.length > 0">
                            <div class="mb-3 flex flex-wrap gap-2 bg-gray-50 rounded-lg p-2 border">
                                <template x-for="(file, index) in $store.chatSystem.selectedFile" :key="index">
                                    <div class="relative group">
                                        <!-- Image preview -->
                                        <template x-if="file.type && file.type.match(/^image\//)">
                                            <div class="relative">
                                                <img :src="$store.chatSystem.filePreviewUrls[index]"
                                                    class="w-16 h-16 object-cover rounded-lg border cursor-pointer hover:opacity-90 transition-opacity"
                                                    @click="$store.chatSystem.openModal($store.chatSystem.filePreviewUrls[index])" />
                                                <button type="button"
                                                    class="absolute -top-2 -right-2 bg-cAccent text-white rounded-full p-1 w-5 h-5 flex items-center justify-center shadow-sm"
                                                    @click="$store.chatSystem.removeSelectedFileAt(index)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </template>

                                        <!-- File preview for non-images -->
                                        <template x-if="!file.type || !file.type.match(/^image\//)">
                                            <div class="relative">
                                                <div class="flex items-center bg-white rounded-lg border p-2 pr-7">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cPrimary mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    <span class="truncate max-w-[120px]" x-text="$store.chatSystem.getFileName(file)"></span>
                                                </div>
                                                <button type="button"
                                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 w-5 h-5 flex items-center justify-center shadow-sm"
                                                    @click="$store.chatSystem.removeSelectedFileAt(index)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </template>

                        <!-- Message Input Form -->
                        <form @submit.prevent="$store.chatSystem.sendMessage()" class="flex items-center space-x-2">
                            <input type="text"
                                x-model="$store.chatSystem.newMessage"
                                placeholder="Type your message here..."
                                class="flex-1 border border-gray-300 rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-cPrimary focus:border-transparent" />

                            <input type="file" multiple
                                @change="$store.chatSystem.handleFileSelected($event)"
                                class="hidden"
                                id="attachmentInput"
                                accept="image/*, .pdf, .doc, .docx" />

                            <label for="attachmentInput"
                                class="bg-gray-100 text-gray-700 rounded-full p-2 cursor-pointer hover:bg-gray-200 transition-colors flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                            </label>

                            <button type="submit"
                                :disabled="(!$store.chatSystem.newMessage.trim() && (!$store.chatSystem.selectedFile || $store.chatSystem.selectedFile.length === 0))"
                                :class="(!$store.chatSystem.newMessage.trim() && (!$store.chatSystem.selectedFile || $store.chatSystem.selectedFile.length === 0)) ? 'bg-gray-300 cursor-not-allowed' : 'bg-cPrimary hover:bg-[#9700fd]'"
                                class="text-white rounded-full p-2 transition-colors flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<template x-data x-if="$store.chatSystem.showModal">
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75" @click="$store.chatSystem.closeModal()">
        <div class="relative max-w-4xl max-h-full p-4">
            <button class="absolute top-5 right-5 bg-black bg-opacity-50 text-white rounded-full p-2 hover:bg-opacity-70 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <img :src="$store.chatSystem.modalImage"
                @click.stop
                class="max-w-full max-h-[90vh] rounded-lg shadow-lg object-contain"
                alt="Expanded Attachment" />
        </div>
    </div>
</template>

<!-- Image Modal -->
<template x-data x-if="$store.chatSystem.showModal">
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75" @click="$store.chatSystem.closeModal()">
        <div class="relative max-w-4xl max-h-full p-4">
            <button class="absolute top-5 right-5 bg-black bg-opacity-50 text-white rounded-full p-2 hover:bg-opacity-70 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <img :src="$store.chatSystem.modalImage"
                @click.stop
                class="max-w-full max-h-[90vh] rounded-lg shadow-lg object-contain"
                alt="Expanded Attachment" />
        </div>
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
            filePreviewUrls: [],

            init() {
                console.log(this.current)
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
                this.filePreviewUrls = [];
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
                    this.messages.push(message);

                    this.newMessage = "";
                    this.removeSelectedFile();

                    this.scrollChatContainer();
                } catch (error) {
                    console.error("Error sending message:", error);
                    // Could add visual error feedback here
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