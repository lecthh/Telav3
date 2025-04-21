<nav class="flex px-4 md:px-[100px] py-3.5 justify-between items-center bg-white text-[18px] font-inter text-cNot-black border border-b border-[#424242]/20 sticky top-0 z-10">
    <div class="flex gap-x-4 md:gap-x-6 items-center">
        <a href="{{ route('home') }}" class="flex-shrink-0">@include('svgs.logo')</a>
        <a href="{{ route('home') }}" class="hover:text-cPrimary transition-colors">Home</a>
        <a href="{{ route('customer.place-order.select-apparel') }}" class="hover:text-cPrimary transition-colors hidden md:block">Start Your Custom Order</a>
    </div>
    <div class="flex gap-x-3 md:gap-x-6 items-center">
        <div class="flex gap-x-3 md:gap-x-4">
            @if(Auth::check())
            <div x-data="{ isOpen: false }">
                <button type="button" class="relative hover:text-cPrimary transition-colors" @click="isOpen = !isOpen">
                    @include('svgs.bell')
                    @php
                    $unreadNotificationsCount = Auth::user()->notifications->where('is_read', false)->count();
                    @endphp
                    @if($unreadNotificationsCount > 0)
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center" id="notification-badge">
                        {{ $unreadNotificationsCount }}
                    </span>
                    @endif
                </button>

                <!-- Notification Dropdown -->
                <div x-show="isOpen" @click.away="isOpen = false" class="absolute top-16 right-24 z-50 animate-fade-in bg-white shadow-lg rounded-lg w-80 max-h-96 overflow-y-auto" x-cloak>
                    @livewire('modal-notification')
                </div>
            </div>
            <a href="{{ route('customer.cart') }}" class="relative hover:text-cPrimary transition-colors">
                @include('svgs.basket')
                @php
                $cart = \App\Models\Cart::where('user_id', Auth::id())->first();
                $cartItemCount = $cart ? $cart->items()->count() : 0;
                @endphp
                @if($cartItemCount > 0)
                <span class="absolute -top-2 -right-2 bg-cPrimary text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                    {{ $cartItemCount }}
                </span>
                @endif
            </a>
            @endif
        </div>

        <!-- User Menu -->
        @if(Auth::check())
        <div class="relative" x-data="{ open: false }">
            <button type="button" @click="open = !open" class="flex items-center gap-x-2 hover:text-cPrimary transition-colors">
                <span class="hidden md:block">{{ Auth::user()->name }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50" x-cloak style="display: none;">
                <a href="{{ route('customer.profile.basics') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-cPrimary hover:text-white">Profile</a>
                <a href="{{ route('customer.profile.orders') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-cPrimary hover:text-white">My Orders</a>
                <a href="{{ route('customer.profile.reviews') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-cPrimary hover:text-white">My Reviews</a>
                <div class="border-t border-gray-200"></div>
                <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-500 hover:text-white">Logout</a>
            </div>
        </div>
        @else
        <!-- Login button -->
        <button onclick="Livewire.dispatch('openModal', { component: 'modal-login' })" class="rounded-xl px-6 py-3 gap-x-3 bg-white border border-Colors/Border/border-primary text-black text-base items-center justify-center hover:bg-Colors/Background/bg-primary_hover">Login/Sign Up</button>
        @endif

        <a href="{{ route('customer.place-order.select-apparel') }}" class="flex bg-cPrimary rounded-xl text-white text-base md:text-[18px] gap-y-3 px-4 py-2 md:px-6 md:py-3 justify-center transition ease-in-out hover:shadow-md hover:bg-[#8722c7] active:bg-[#6B10A8]">
            Order Now
        </a>
    </div>
</nav>
@livewire('wire-elements-modal')

<script>
    // Make sure Alpine.js is loaded
    document.addEventListener('alpine:init', () => {
        console.log('Alpine.js initialized');
    });

    document.addEventListener('livewire:initialized', () => {
        Livewire.on('notificationStatusChanged', () => {
            updateNotificationBadge();
        });
    });

    // Function to update notification badge
    function updateNotificationBadge() {
        fetch('/user')
            .then(response => response.json())
            .then(user => {
                if (user) {
                    fetch('/notifications/count')
                        .then(response => response.json())
                        .then(data => {
                            const badge = document.getElementById('notification-badge');
                            if (data.count > 0) {
                                if (badge) {
                                    badge.textContent = data.count;
                                    badge.classList.remove('hidden');
                                } else {
                                    const newBadge = document.createElement('span');
                                    newBadge.id = 'notification-badge';
                                    newBadge.className = 'absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center';
                                    newBadge.textContent = data.count;
                                    document.querySelector('.bell-icon-container').appendChild(newBadge);
                                }
                            } else if (badge) {
                                badge.classList.add('hidden');
                            }
                        });
                }
            });
    }
</script>