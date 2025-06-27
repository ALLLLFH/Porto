{{-- resources/views/layouts/sidebar.blade.php --}}
<aside class="w-64 bg-white shadow p-4 flex-shrink-0 flex flex-col justify-between">
    {{-- 'flex flex-col justify-between' harus ada di sini --}}

    <div> {{-- Pembungkus konten atas --}}
        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">My Portfolio</h2>
        </div>
        <nav>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('dashboard') }}" class="flex items-center p-2 text-base font-normal text-stone-700 rounded-lg hover:bg-blue-200 group hover:text-blue-700">
                        <svg class="w-6 h-6 text-stone-700 group-hover:text-blue-700 transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 01-8 8v-8H2z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>
                        <span class="ml-3">Data diri</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-base font-normal text-stone-700 rounded-lg hover:bg-blue-200 group hover:text-blue-700">
                        <svg class="flex-shrink-0 w-6 h-6 text-stone-700 group-hover:text-blue-700 transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L10 8.586l-1.293-1.293z"></path><path d="M11 2a2 2 0 00-2 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 00-2-2C.92 2.72 1.982 1 4 1h2a2 2 0 012 2v2a2 2 0 002 2 2 2 0 002-2V4a2 2 0 00-2-2h-2z"></path></svg>
                        <span class="ml-3">Portofolio</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    @auth
        <div class="mt-auto pt-4 border-t border-gray-300">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center p-2 text-base font-normal text-stone-700 rounded-lg hover:bg-red-200 group hover:text-red-700 transition duration-75">
                    <svg class="flex-shrink-0 w-6 h-6 text-stone-700 group-hover:text-red-700 transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-2 0V4H5v12h7a1 1 0 010 2H4a1 1 0 01-1-1V3zm9 6a1 1 0 010 2h-5a1 1 0 010-2h5zm2-3a1 1 0 010 2h-5a1 1 0 010-2h5zm0 6a1 1 0 010 2h-5a1 1 0 010-2h5z" clip-rule="evenodd"></path></svg>
                    <span class="ml-3">Log Out</span>
                </button>
            </form>
        </div>
    @endauth
</aside>