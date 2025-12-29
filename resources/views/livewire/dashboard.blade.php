<div class="min-h-screen bg-white font-mono text-black">
    {{-- CUSTOM STYLES --}}
    <style>
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-left: 2px solid black; }
        ::-webkit-scrollbar-thumb { background: #000; border: 2px solid black; }
        ::-webkit-scrollbar-thumb:hover { background: #333; }
    </style>

    {{-- HEADER (Versi Dashboard - Lebih Simpel) --}}
    <div class="bg-[#1c0213] border-b-4 border-black sticky top-0 z-50 shadow-2xl">
        <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between">
            <a href="{{ route('home') }}" class="group flex items-center gap-2 select-none hover:scale-105 transition-transform">
                <img src="{{ asset('images/abcsaga-logo.png') }}" alt="ABCSAGA Logo" class="h-12 w-auto object-contain">
                <span class="text-white font-black text-xl tracking-tighter bg-[#e97124] px-2 border-2 border-white transform -skew-x-12 hidden md:block">
                    AUTHOR PANEL
                </span>
            </a>

            {{-- User Dropdown / Logout (Placeholder) --}}
            <div class="flex items-center gap-4">
                <span class="text-white font-bold text-sm hidden md:block">Halo, {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-white text-black font-bold px-4 py-1 border-2 border-black hover:bg-[#e97124] hover:text-black transition-colors shadow-[2px_2px_0px_0px_#e97124]">
                        LOGOUT
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="max-w-7xl mx-auto p-6 mt-8">
        
        {{-- WELCOME SECTION --}}
        <div class="mb-10 border-4 border-black p-6 bg-gray-100 shadow-[8px_8px_0px_0px_#000]">
            <h1 class="text-3xl md:text-5xl font-black uppercase mb-2">
                DASHBOARD
            </h1>
            <p class="text-gray-600 font-bold">
                Selamat datang kembali, Penulis! Siap membuat karya masterpiece hari ini?
            </p>
        </div>

        {{-- STATS GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            {{-- Stat 1: Total Books --}}
            <div class="bg-white border-2 border-black p-4 shadow-[4px_4px_0px_0px_#e97124] hover:-translate-y-1 transition-transform">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase">Total Novels</span>
                        <span class="block text-4xl font-black">{{ $stats['books'] }}</span>
                    </div>
                    <div class="text-4xl">📕</div>
                </div>
            </div>

            {{-- Stat 2: Total Chapters --}}
            <div class="bg-white border-2 border-black p-4 shadow-[4px_4px_0px_0px_#000] hover:-translate-y-1 transition-transform">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase">Total Chapters</span>
                        <span class="block text-4xl font-black">{{ $stats['chapters'] }}</span>
                    </div>
                    <div class="text-4xl">✍️</div>
                </div>
            </div>

            {{-- Stat 3: Total Views --}}
            <div class="bg-black text-white border-2 border-black p-4 shadow-[4px_4px_0px_0px_#e97124] hover:-translate-y-1 transition-transform">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase">Total Views</span>
                        <span class="block text-4xl font-black">{{ $stats['views'] }}</span>
                    </div>
                    <div class="text-4xl">👀</div>
                </div>
            </div>
        </div>

        {{-- MY NOVELS SECTION --}}
        <div>
            <div class="flex items-center justify-between mb-6 border-b-4 border-black pb-2">
                <h2 class="text-2xl font-black uppercase flex items-center gap-2">
                    <span class="w-4 h-4 bg-[#e97124] border border-black block"></span>
                    NOVEL SAYA
                </h2>
                {{-- Tombol Buat Baru (Link ke halaman create nanti) --}}
                <a href="#" class="bg-[#e97124] text-black px-4 py-2 font-bold border-2 border-black shadow-[4px_4px_0px_0px_#000] hover:bg-black hover:text-white transition-all text-sm uppercase">
                    + BUAT NOVEL BARU
                </a>
            </div>

            {{-- Table List --}}
            <div class="bg-white border-2 border-black overflow-hidden shadow-[6px_6px_0px_0px_#1c0213]">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-black text-white uppercase text-sm font-bold">
                        <tr>
                            <th class="p-4 border-b-2 border-black">Cover</th>
                            <th class="p-4 border-b-2 border-black">Judul</th>
                            <th class="p-4 border-b-2 border-black text-center">Status</th>
                            <th class="p-4 border-b-2 border-black text-center">Chapters</th>
                            <th class="p-4 border-b-2 border-black text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-black font-bold text-sm">
                        @forelse($books as $book)
                            <tr class="hover:bg-gray-50 group">
                                <td class="p-4 w-20">
                                    <div class="w-12 h-16 bg-gray-200 border border-black overflow-hidden relative">
                                        @if($book->cover_url)
                                            <img src="{{ $book->cover_url }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-[8px] text-gray-500 text-center">NO IMG</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-4">
                                    <h3 class="text-lg font-black uppercase group-hover:text-[#e97124] transition-colors">
                                        {{ $book->title }}
                                    </h3>
                                    <p class="text-xs text-gray-500 mt-1 truncate max-w-xs">
                                        {{ Str::limit($book->synopsis, 50) }}
                                    </p>
                                </td>
                                <td class="p-4 text-center">
                                    @if($book->is_published)
                                        <span class="bg-[#e97124] text-black border border-black px-2 py-1 text-xs">PUBLISHED</span>
                                    @else
                                        <span class="bg-gray-300 text-black border border-black px-2 py-1 text-xs">DRAFT</span>
                                    @endif
                                </td>
                                <td class="p-4 text-center text-xl font-black">
                                    {{ $book->chapters_count }}
                                </td>
                                <td class="p-4 text-right space-x-2">
                                    <a href="{{ route('book.detail', $book->id) }}" class="inline-block border-2 border-black p-2 hover:bg-black hover:text-white transition-colors" title="Lihat">
                                        👁️
                                    </a>
                                    <a href="#" class="inline-block border-2 border-black p-2 bg-yellow-300 hover:bg-yellow-400 transition-colors" title="Edit">
                                        ✏️
                                    </a>
                                    <button class="inline-block border-2 border-black p-2 bg-red-500 text-white hover:bg-red-600 transition-colors" title="Hapus">
                                        🗑️
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-500 italic">
                                    Anda belum menulis novel apapun.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $books->links() }}
            </div>
        </div>
    </div>
</div>