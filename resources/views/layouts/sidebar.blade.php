{{-- resources/views/layouts/sidebar.blade.php --}}
<aside
    :class="sidebarCollapsed ? 'w-20' : 'w-64'"
    class="fixed top-0 left-0 h-screen bg-white shadow p-4 flex-shrink-0 flex flex-col justify-between overflow-hidden z-30 transition-all duration-300">

    <button @click="sidebarCollapsed = !sidebarCollapsed"
        class="mb-6 flex items-center justify-end w-full text-gray-500 hover:text-gray-700 focus:outline-none">
        <i :class="sidebarCollapsed ? 'fa-solid fa-chevron-right' : 'fa-solid fa-chevron-left'"></i>
    </button>

    <div>
        <div class="mb-6 flex items-center" :class="sidebarCollapsed ? 'justify-center' : ''">
            <h2 class="text-2xl font-semibold text-gray-800" x-show="!sidebarCollapsed" x-transition>My Portfolio</h2>
            <i class="fa-solid fa-user text-2xl text-gray-800" x-show="sidebarCollapsed" x-transition></i>
        </div>
        <nav>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center p-2 text-base font-normal text-stone-700 rounded-lg hover:bg-blue-200 group hover:text-blue-700 transition-all duration-200">
                        <i class="fa-solid fa-table-list text-lg"></i>
                        <span class="ml-3" x-show="!sidebarCollapsed" x-transition>Data diri</span>
                    </a>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center p-2 text-base font-normal text-stone-700 rounded-lg hover:bg-blue-200 group hover:text-blue-700 transition-all duration-200">
                        <i class="fa-solid fa-address-card text-lg"></i>
                        <span class="ml-3" x-show="!sidebarCollapsed" x-transition>Portofolio</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    @auth
        <div class="mt-auto pt-4 border-t border-gray-300">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center p-2 text-base font-normal text-stone-700 rounded-lg hover:bg-red-200 group hover:text-red-700 transition duration-75">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <span class="ml-3" x-show="!sidebarCollapsed" x-transition>Log Out</span>
                </button>
            </form>
        </div>
    @endauth
</aside>