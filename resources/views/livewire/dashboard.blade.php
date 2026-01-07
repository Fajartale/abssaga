<div class="min-h-screen bg-white font-mono text-black">
    {{-- CUSTOM STYLES --}}
    <style>
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-left: 2px solid black; }
        ::-webkit-scrollbar-thumb { background: #000; border: 2px solid black; }
        ::-webkit-scrollbar-thumb:hover { background: #333; }
    </style>

    {{-- HEADER KHUSUS DASHBOARD --}}
    <div class="bg-[#1c0213] border-b-4 border-black sticky top-0 z-50 shadow-2xl">
        <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between">
            
            {{-- LOGO & BADGE PANEL --}}
            <a href="{{ route('home') }}" class="group flex items-center gap-3 select-none hover:scale-105 transition-transform">
                <img src="{{ asset('images/abcsaga-logo.png') }}" alt="ABCSAGA Logo" class="h-12 w-auto object-contain">
                
                {{-- Badge Author Panel --}}
                <span class="text-black font-black text-sm md:text-lg tracking-tighter bg-[#e97124] px-3 py-1 border-2 border-white transform -skew-x-12 hidden md:block shadow-[2px_2px_0px_0px_rgba(255,255,255,0.5)]">
                    AUTHOR PANEL
                </span>
            </a>

            {{-- USER INFO & LOGOUT --}}
            <div class="flex items-center gap-4">
                <span class="text-white font-bold text-sm hidden md:block uppercase tracking-wider">
                    Halo, {{ Auth::user()->name }}
                </span>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-white text-black font-bold px-4 py-2 border-2 border-black hover:bg-[#e97124] hover:text-black transition-colors shadow-[4px_4px_0px_0px_#e97124] hover:shadow-[4px_4px_0px_0px_#fff]">
                        LOGOUT
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="max-w-7xl mx-auto p-6 mt-8">
        
        {{-- Flash Message --}}
        @if (session()->has('message'))
            <div class="mb-6 bg-green-100 border-2 border-black text-black p-4 font-bold shadow-[4px_4px_0px_0px_#000] flex items-center justify-between">
                <span>{{ session('message') }}</span>
                <span class="text-xl">✅</span>
            </div>
        @endif
        
        {{-- WELCOME SECTION --}}
        <div class="mb-10 border-4 border-black p-6 bg-gray-100 shadow-[8px_8px_0px_0px_#000] relative overflow-hidden">
            <div class="relative z-10">
                <h1 class="text-3xl md:text-5xl font-black uppercase mb-2">
                    DASHBOARD
                </h1>
                <p class="text-gray-600 font-bold text-lg">
                    Selamat datang kembali! Siap merangkai kata hari ini?
                </p>
            </div>
            <div class="absolute -right-10 -bottom-10 text-9xl opacity-5 select-none pointer-events-none">
                ✍️
            </div>
        </div>

        {{-- STATS GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            
            {{-- Stat 1: Total Books --}}
            <div class="bg-white border-2 border-black p-4 shadow-[6px_6px_0px_0px_#e97124] hover:-translate-y-1 transition-transform group">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="block text-xs font-bold text-gray-500 uppercase group-hover:text-[#e97124]">Total Novels</span>
                        <span class="block text-4xl font-black">{{ $stats['books'] }}</span>
                    </div>
                    <div class="text-4xl group-hover:scale-110 transition-transform">📕</div>
                </div>
            </div>

            {{-- Stat 2: Total Chapters --}}
            <div class="bg-white border-2 border-black p-4 shadow-[6px_6px_0px_0px_#000] hover:-translate-y-1 transition-transform group">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="block text-xs font-bold text-gray-500 uppercase group-hover:text-black">Total Chapters</span>
                        <span class="block text-4xl font-black">{{ $stats['chapters'] }}</span>
                    </div>
                    <div class="text-4xl group-hover:scale-110 transition-transform">📝</div>
                </div>
            </div>

            {{-- Stat 3: Total Views --}}
            <div class="bg-black text-white border-2 border-black p-4 shadow-[6px_6px_0px_0px_#e97124] hover:-translate-y-1 transition-transform group">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase group-hover:text-[#e97124]">Total Views</span>
                        <span class="block text-4xl font-black">{{ $stats['views'] }}</span>
                    </div>
                    <div class="text-4xl group-hover:scale-110 transition-transform">👀</div>
                </div>
            </div>
        </div>

        {{-- MY NOVELS SECTION --}}
        <div>
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-6 border-b-4 border-black pb-4 gap-4">
                <h2 class="text-2xl font-black uppercase flex items-center gap-3">
                    <span class="w-6 h-6 bg-[#e97124] border-2 border-black block shadow-[2px_2px_0px_0px_#000]"></span>
                    NOVEL SAYA
                </h2>
                
                {{-- [PERBAIKAN 1] Tombol Buat Baru -> route('book.manage') --}}
                <a href="{{ route('book.manage') }}" class="bg-[#e97124] text-black px-6 py-2 font-black border-2 border-black shadow-[4px_4px_0px_0px_#000] hover:bg-black hover:text-white hover:shadow-[4px_4px_0px_0px_#e97124] transition-all text-sm uppercase flex items-center gap-2">
                    <span>+</span> Buat Novel Baru
                </a>
            </div>

            {{-- Table List --}}
            <div class="bg-white border-2 border-black overflow-hidden shadow-[8px_8px_0px_0px_#1c0213]">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[600px]">
                        <thead class="bg-black text-white uppercase text-sm font-bold">
                            <tr>
                                <th class="p-4 border-b-2 border-black w-24">Cover</th>
                                <th class="p-4 border-b-2 border-black">Detail Buku</th>
                                <th class="p-4 border-b-2 border-black text-center">Status</th>
                                <th class="p-4 border-b-2 border-black text-center">Statistik</th>
                                <th class="p-4 border-b-2 border-black text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y-2 divide-black font-bold text-sm">
                            @forelse($books as $book)
                                <tr class="hover:bg-orange-50 group transition-colors">
                                    {{-- Kolom Cover --}}
                                    <td class="p-4 align-top">
                                        <div class="w-16 h-24 bg-gray-200 border-2 border-black overflow-hidden relative shadow-[2px_2px_0px_0px_#000]">
                                            @if($book->cover_url)
                                                <img src="{{ $book->cover_url }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-[8px] text-gray-500 text-center uppercase p-1">NO COVER</div>
                                            @endif
                                        </div>
                                    </td>
                                    
                                    {{-- Kolom Detail --}}
                                    <td class="p-4 align-top">
                                        <h3 class="text-lg font-black uppercase group-hover:text-[#e97124] transition-colors line-clamp-1">
                                            {{ $book->title }}
                                        </h3>
                                        <p class="text-xs text-gray-500 mt-2 line-clamp-2 leading-relaxed">
                                            {{ $book->synopsis ?: 'Belum ada sinopsis.' }}
                                        </p>
                                        <div class="mt-2 text-[10px] text-gray-400 uppercase font-bold">
                                            Updated: {{ $book->updated_at->diffForHumans() }}
                                        </div>
                                    </td>

                                    {{-- Kolom Status --}}
                                    <td class="p-4 align-middle text-center">
                                        @if($book->is_published)
                                            <span class="inline-block bg-[#e97124] text-black border-2 border-black px-3 py-1 text-xs font-black shadow-[2px_2px_0px_0px_#000]">
                                                PUBLISHED
                                            </span>
                                        @else
                                            <span class="inline-block bg-gray-200 text-gray-500 border-2 border-black px-3 py-1 text-xs font-black border-dashed">
                                                DRAFT
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Kolom Statistik --}}
                                    <td class="p-4 align-middle text-center">
                                        <div class="flex flex-col items-center gap-1">
                                            <span class="text-xl font-black">{{ $book->chapters_count }}</span>
                                            <span class="text-[10px] uppercase text-gray-500">Chapters</span>
                                        </div>
                                    </td>

                                    {{-- Kolom Aksi --}}
                                    <td class="p-4 align-middle text-right">
                                        <div class="flex justify-end gap-2">
                                            {{-- Tombol Lihat (Link ke Public) --}}
                                            <a href="{{ route('book.detail', $book->id) }}" class="flex items-center justify-center w-10 h-10 border-2 border-black bg-white hover:bg-black hover:text-white transition-all shadow-[2px_2px_0px_0px_#ccc] hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px]" title="Lihat Halaman">
                                                👁️
                                            </a>
                                            
                                            {{-- [PERBAIKAN 2] Tombol Edit -> route('book.manage', id) --}}
                                            <a href="{{ route('book.manage', $book->id) }}" class="flex items-center justify-center w-10 h-10 border-2 border-black bg-yellow-300 hover:bg-yellow-400 transition-all shadow-[2px_2px_0px_0px_#000] hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px]" title="Edit Buku">
                                                ✏️
                                            </a>

                                            {{-- [PERBAIKAN 3] Tombol Hapus (Pastikan method deleteBook ada di Dashboard.php) --}}
                                            <button 
                                                wire:click="deleteBook({{ $book->id }})" 
                                                wire:confirm="Yakin ingin menghapus novel ini? Tindakan ini tidak bisa dibatalkan."
                                                class="flex items-center justify-center w-10 h-10 border-2 border-black bg-red-500 text-white hover:bg-red-600 transition-all shadow-[2px_2px_0px_0px_#000] hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px]" title="Hapus">
                                                🗑️
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-12 text-center border-2 border-dashed border-gray-300 bg-gray-50">
                                        <span class="text-4xl block mb-2">📭</span>
                                        <h3 class="text-lg font-bold text-gray-400 uppercase">Belum ada novel.</h3>
                                        <p class="text-sm text-gray-400 mt-1">Mulailah menulis cerita pertamamu sekarang!</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $books->links() }}
            </div>
        </div>
    </div>
</div>