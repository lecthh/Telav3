<div class="flex flex-col border-r border-gray-200 h-full min-h-screen w-[280px] bg-white shadow-sm">
    <div class="flex items-center gap-x-3 p-4 border-b border-gray-200 bg-gradient-to-r from-cGreen/10 to-white">
        <div class="flex p-1.5 bg-cGreen rounded-md text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
            </svg>
        </div>
        <div class="font-gilroy font-bold text-base truncate text-gray-900">
            @if(isset($productionCompany) && isset($productionCompany->company_name))
            {{ $productionCompany->company_name }}
            @elseif(isset($designer) && isset($designer->user) && isset($designer->user->name))
            {{ $designer->user->name }}'s Hub
            @else
            Designer Hub
            @endif
        </div>
    </div>

    <div class="py-4 px-2 flex-grow overflow-y-auto">
        <nav class="flex flex-col space-y-1">
            <a href="{{ route('designer-dashboard') }}" class="flex items-center gap-x-3 px-3 py-2.5 rounded-md {{ request()->routeIs('designer-dashboard') ? 'bg-cGreen/20 text-cGreen font-medium' : 'text-gray-700 hover:bg-cGreen/10' }} transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('partner.designer.orders') }}" class="flex items-center gap-x-3 px-3 py-2.5 rounded-md {{ request()->routeIs('partner.designer.orders') || request()->routeIs('partner.designer.assigned-x') ? 'bg-cGreen/20 text-cGreen font-medium' : 'text-gray-700 hover:bg-cGreen/10' }} transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                </svg>
                <span>Orders</span>
            </a>

            <a href="{{ route('partner.designer.complete') }}" class="flex items-center gap-x-3 px-3 py-2.5 rounded-md {{ request()->routeIs('partner.designer.complete') ? 'bg-cGreen/20 text-cGreen font-medium' : 'text-gray-700 hover:bg-cGreen/10' }} transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span>Completed Work</span>
            </a>

            @php
            // Get the designer's user ID
            $designerUserId = null;
            if (isset($designer) && isset($designer->user_id)) {
            $designerUserId = $designer->user_id;
            }

            // Get unread notification count
            $unreadCount = 0;
            if ($designerUserId) {
            $unreadCount = \App\Models\Notification::where('user_id', $designerUserId)
            ->where('is_read', false)
            ->count();
            }
            @endphp

            <a href="{{ route('partner.designer.profile.notifications') }}" class="flex items-center gap-x-3 px-3 py-2.5 rounded-md {{ request()->routeIs('partner.designer.profile.notifications') ? 'bg-cGreen/20 text-cGreen font-medium' : 'text-gray-700 hover:bg-cGreen/10' }} transition-colors">
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                    </svg>

                    @if($unreadCount > 0)
                    <span class="absolute -top-1 -right-1 h-4 w-4 bg-red-500 rounded-full flex items-center justify-center text-white text-xs">
                        {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                    </span>
                    @endif
                </div>
                <span>Notifications</span>
            </a>

            <a href="{{ route('partner.designer.profile.reviews') }}" class="flex items-center gap-x-3 px-3 py-2.5 rounded-md {{ request()->routeIs('partner.designer.profile.reviews') ? 'bg-cGreen/20 text-cGreen font-medium' : 'text-gray-700 hover:bg-cGreen/10' }} transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                </svg>
                <span>Reviews</span>
            </a>

            <div class="pt-4 mt-4 border-t border-gray-200">
                <a href="{{ route('partner.designer.profile.basics') }}" class="flex items-center gap-x-3 px-3 py-2.5 rounded-md {{ request()->routeIs('partner.designer.profile.basics') ? 'bg-cGreen/20 text-cGreen font-medium' : 'text-gray-700 hover:bg-cGreen/10' }} transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                    </svg>
                    <span>Account Settings</span>
                </a>

                <a href="{{ route('logout') }}" class="flex items-center gap-x-3 px-3 py-2.5 mt-2 rounded-md text-red-600 hover:bg-red-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V7.414l-5-5H3zm7 2a1 1 0 00-1 1v1a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        <path d="M14 9a1 1 0 011 1v3a1 1 0 11-2 0v-3a1 1 0 011-1zM3 11a1 1 0 011-1h2a1 1 0 110 2H4a1 1 0 01-1-1z" />
                        <path d="M8 10a2 2 0 00-2 2v4a2 2 0 002 2h3a2 2 0 002-2v-4a2 2 0 00-2-2H8z" />
                    </svg>
                    <span>Logout</span>
                </a>
            </div>
        </nav>
    </div>
</div>