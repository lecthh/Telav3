<div class="flex flex-col border-r border-gray-200 h-full min-h-screen w-[280px] bg-white shadow-sm">
    <div class="flex items-center gap-x-3 p-4 border-b border-gray-200 bg-gradient-to-r from-cAccent/10 to-white">
        <div class="flex p-1.5 bg-cAccent rounded-md text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
            </svg>
        </div>
        <a href="{{ route('partner.printer.profile.basics') }}" class="font-gilroy font-bold text-base truncate text-gray-900">
             {{ auth()->user()->name }}
        </a>

    </div>
    
    <div class="py-4 px-2 flex-grow overflow-y-auto">
        <nav class="flex flex-col space-y-1">
            <a href="{{ route('printer-dashboard') }}" class="flex items-center gap-x-3 px-3 py-2.5 rounded-md {{ request()->routeIs('printer-dashboard') ? 'bg-cAccent/20 text-cAccent font-medium' : 'text-gray-700 hover:bg-cAccent/10' }} transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                <span>Dashboard</span>
            </a>
            
            <a href="{{ route('partner.printer.orders') }}" class="flex items-center gap-x-3 px-3 py-2.5 rounded-md {{ (request()->routeIs('partner.printer.orders') || request()->routeIs('partner.printer.pending-order-x')) ? 'bg-cAccent/20 text-cAccent font-medium' : 'text-gray-700 hover:bg-cAccent/10' }} transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                </svg>
                <span>Manage Users</span>
            </a>
            
            
            <a href="{{ route('partner.printer.printing-in-progress') }}" class="flex items-center gap-x-3 px-3 py-2.5 rounded-md {{ request()->routeIs('partner.printer.printing*') ? 'bg-cAccent/20 text-cAccent font-medium' : 'text-gray-700 hover:bg-cAccent/10' }} transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                </svg>
                <span>Manage Production Companies</span>
            </a>
            
            <a href="#" class="flex items-center gap-x-3 px-3 py-2.5 rounded-md text-gray-700 hover:bg-cAccent/10 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                </svg>
                <span>Manage Designers</span>
            </a>
            
            <div class="pt-4 mt-4 border-t border-gray-200">                
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