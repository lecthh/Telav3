<div class="flex flex-col border-r border-gray-200 h-full min-h-screen w-[280px] bg-white shadow-sm sticky">
    <div class="flex items-center gap-x-3 p-4 border-b border-gray-200 bg-gradient-to-r from-cPrimary/10 to-white">
        <div class="flex p-1.5 bg-cPrimary rounded-md text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
            </svg>
        </div>
        <a href="{{ route('partner.printer.profile.basics') }}" class="font-gilroy font-bold text-base truncate text-gray-900">
            {{ auth()->user()->name }}
        </a>

    </div>

    @php
  // Check if any production companies routes are active.
  $isProductionActive = request()->routeIs('superadmin.production') || request()->routeIs('superadmin.production.approve');
  // Check if any designers routes are active.
  $isDesignerActive = request()->routeIs('superadmin.designer') || request()->routeIs('superadmin.designer.approve');
@endphp

<div class="py-4 px-2 flex-grow overflow-y-auto">
  <nav class="flex flex-col space-y-1">
    <!-- Manage Users (unchanged) -->
    <a href="{{ route('superadmin.users') }}" class="flex items-center gap-x-3 px-3 py-2.5 rounded-md {{ request()->routeIs('superadmin.users') ? 'bg-cAccent/20 text-cAccent font-medium' : 'text-gray-700 hover:bg-cAccent/10' }} transition-colors">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 18L18 20L22 16M12 15H8C6.13623 15 5.20435 15 4.46927 15.3045C3.48915 15.7105 2.71046 16.4892 2.30448 17.4693C2 18.2044 2 19.1362 2 21M15.5 3.29076C16.9659 3.88415 18 5.32131 18 7C18 8.67869 16.9659 10.1159 15.5 10.7092M13.5 7C13.5 9.20914 11.7091 11 9.5 11C7.29086 11 5.5 9.20914 5.5 7C5.5 4.79086 7.29086 3 9.5 3C11.7091 3 13.5 4.79086 13.5 7Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
      <span>Manage Users</span>
    </a>

    <!-- Production Companies Dropdown -->
    <div x-data="{ openProd: {{ $isProductionActive ? 'true' : 'false' }} }" class="w-full">
      <button @click="openProd = !openProd" class="flex items-center gap-x-3 w-full px-3 py-2.5 rounded-md {{ $isProductionActive ? 'bg-cAccent/20 text-cAccent font-medium' : 'text-gray-700 hover:bg-cAccent/10' }} transition-colors">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 6L10.5 10.5M6 6H3L2 3L3 2L6 3V6ZM19.259 2.74101L16.6314 5.36863C16.2354 5.76465 16.0373 5.96265 15.9632 6.19098C15.8979 6.39183 15.8979 6.60817 15.9632 6.80902C16.0373 7.03735 16.2354 7.23535 16.6314 7.63137L16.8686 7.86863C17.2646 8.26465 17.4627 8.46265 17.691 8.53684C17.8918 8.6021 18.1082 8.6021 18.309 8.53684C18.5373 8.46265 18.7354 8.26465 19.1314 7.86863L21.5893 5.41072C21.854 6.05488 22 6.76039 22 7.5C22 10.5376 19.5376 13 16.5 13C16.1338 13 15.7759 12.9642 15.4298 12.8959C14.9436 12.8001 14.7005 12.7521 14.5532 12.7668C14.3965 12.7824 14.3193 12.8059 14.1805 12.8802C14.0499 12.9501 13.919 13.081 13.657 13.343L6.5 20.5C5.67157 21.3284 4.32843 21.3284 3.5 20.5C2.67157 19.6716 2.67157 18.3284 3.5 17.5L10.657 10.343C10.919 10.081 11.0499 9.95005 11.1198 9.81949C11.1941 9.68068 11.2176 9.60347 11.2332 9.44681C11.2479 9.29945 11.1999 9.05638 11.1041 8.57024C11.0358 8.22406 11 7.86621 11 7.5C11 4.46243 13.4624 2 16.5 2C17.5055 2 18.448 2.26982 19.259 2.74101ZM12.0001 14.9999L17.5 20.4999C18.3284 21.3283 19.6716 21.3283 20.5 20.4999C21.3284 19.6715 21.3284 18.3283 20.5 17.4999L15.9753 12.9753C15.655 12.945 15.3427 12.8872 15.0408 12.8043C14.6517 12.6975 14.2249 12.7751 13.9397 13.0603L12.0001 14.9999Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
        <span>Production Companies</span>
        <svg class="ml-auto h-4 w-4 transform transition-transform" :class="{ 'rotate-90': openProd }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </button>
      <div x-show="openProd" class="flex flex-col space-y-1 pl-8 mt-1">
        <a href="{{ route('superadmin.production') }}" class="flex items-center gap-x-3 px-3 py-2.5 rounded-md {{ request()->routeIs('superadmin.production') ? 'bg-cAccent/20 text-cAccent font-medium' : 'text-gray-700 hover:bg-cAccent/10' }} transition-colors">
          <span>Manage Production Companies</span>
        </a>
        <a href="{{ route('superadmin.production.approve') }}" class="flex items-center gap-x-3 px-3 py-2.5 rounded-md {{ request()->routeIs('superadmin.production.approve') ? 'bg-cAccent/20 text-cAccent font-medium' : 'text-gray-700 hover:bg-cAccent/10' }} transition-colors">
          <span>Approve Production Companies</span>
        </a>
      </div>
    </div>

    <!-- Designers Dropdown -->
    <div x-data="{ openDesign: {{ $isDesignerActive ? 'true' : 'false' }} }" class="w-full">
      <button @click="openDesign = !openDesign" class="flex items-center gap-x-3 w-full px-3 py-2.5 rounded-md {{ $isDesignerActive ? 'bg-cAccent/20 text-cAccent font-medium' : 'text-gray-700 hover:bg-cAccent/10' }} transition-colors">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 12C2 17.5228 6.47715 22 12 22C13.6569 22 15 20.6569 15 19V18.5C15 18.0356 15 17.8034 15.0257 17.6084C15.2029 16.2622 16.2622 15.2029 17.6084 15.0257C17.8034 15 18.0356 15 18.5 15H19C20.6569 15 22 13.6569 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M7 13C7.55228 13 8 12.5523 8 12C8 11.4477 7.55228 11 7 11C6.44772 11 6 11.4477 6 12C6 12.5523 6.44772 13 7 13Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M16 9C16.5523 9 17 8.55228 17 8C17 7.44772 16.5523 7 16 7C15.4477 7 15 7.44772 15 8C15 8.55228 15.4477 9 16 9Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M10 8C10.5523 8 11 7.55228 11 7C11 6.44772 10.5523 6 10 6C9.44772 6 9 6.44772 9 7C9 7.55228 9.44772 8 10 8Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
        <span>Designers</span>
        <svg class="ml-auto h-4 w-4 transform transition-transform" :class="{ 'rotate-90': openDesign }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </button>
      <div x-show="openDesign" class="flex flex-col space-y-1 pl-8 mt-1">
        <a href="{{ route('superadmin.designers') }}" class="flex items-center gap-x-3 px-3 py-2.5 rounded-md {{ request()->routeIs('superadmin.designer') ? 'bg-cAccent/20 text-cAccent font-medium' : 'text-gray-700 hover:bg-cAccent/10' }} transition-colors">
          <span>Manage Designers</span>
        </a>
        <a href="{{ route('superadmin.designers.approve') }}" class="flex items-center gap-x-3 px-3 py-2.5 rounded-md {{ request()->routeIs('superadmin.designer.approve') ? 'bg-cAccent/20 text-cAccent font-medium' : 'text-gray-700 hover:bg-cAccent/10' }} transition-colors">
          <span>Approve Designers</span>
        </a>
      </div>
    </div>

    <!-- Logout -->
    <div class="pt-4 mt-4 border-t border-gray-200">
      <a href="{{ route('logout') }}" class="flex items-center gap-x-3 px-3 py-2.5 mt-2 rounded-md text-red-600 hover:bg-red-50 transition-colors">
        <!-- SVG icon -->
        <span>Logout</span>
      </a>
    </div>
  </nav>
</div>


</div>