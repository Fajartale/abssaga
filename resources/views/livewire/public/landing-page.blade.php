<div class="min-h-screen bg-white font-mono text-black">
    {{-- CUSTOM STYLES --}}
    <style>
        .text-stroke-black { -webkit-text-stroke: 2px black; }
        .text-stroke-sm { -webkit-text-stroke: 1px black; }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-left: 2px solid black; }
        ::-webkit-scrollbar-thumb { background: #000; border: 2px solid black; }
        ::-webkit-scrollbar-thumb:hover { background: #333; }
    </style>

    {{-- HEADER SECTION --}}
    <div class="bg-[#1c0213] border-b-4 border-black sticky top-0 z-50 shadow-2xl">
        <div class="max-w-7xl mx-auto px-6 py-3">
            <div class="flex flex-col lg:flex-row justify-between items-center gap-6">
                
                {{-- LOGO & NAVIGASI KIRI --}}
                <div class="flex flex-col lg:flex-row items-center gap-8 w-full lg:w-auto">
                    {{-- Logo Gambar --}}
                    <a href="{{ route('home') }}" class="group flex items-center gap-3 select-none hover:scale-105 transition-transform">
                        <img src="{{ asset('images/abcsaga-logo.png') }}" alt="ABCSAGA Logo" class="h-14 w-auto object-contain">
                    </a>

                    {{-- Menu Navigasi --}}
                    <nav class="flex gap-4">
                        <a href="#" class="px-6 py-2 bg-white text-black font-bold border-2 border-black shadow-[4px_4px_0px_0px_rgba(255,255,255,0.3)] hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all text-sm uppercase">
                            Series
                        </a>
                        {{-- Tombol Ranking: BG #131c02, Teks Putih --}}
                        <a href="#" class="px-6 py-2 bg-[#131c02] text-white font-bold border-2 border-black shadow-[4px_4px_0px_0px_rgba(255,255,255,0.3)] hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all text-sm uppercase">
                            Ranking 🏆
                        </a>
                    </nav>
                </div>

                {{-- SEARCH BAR KANAN --}}
                <div class="w-full lg:w-auto">
                    <form action="{{ route('search') }}" method="GET" class="relative flex border-2 border-black bg-white w-full lg:w-[300px]">
                        <input 
                            type="text" 
                            name="q" 
                            placeholder="CARI BUKU..." 
                            class="w-full bg-transparent border-none text-sm font-bold px-4 py-2 uppercase placeholder-gray-500 focus:ring-0"
                            required
                        >
                        {{-- Tombol Cari Hover: BG #131c02, Teks Putih --}}
                        <button type="submit" class="bg-black text-white px-4 hover:bg-[#131c02] hover:text-white transition-colors">
                            🔍
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT GRID --}}
    <div class="max-w-7xl mx-auto p-6 grid grid-cols-1 lg:grid-cols-4 gap-8 mt-8">
        
        {{-- KOLOM KIRI (Konten Utama 3/4) --}}
        <div class="lg:col-span-3 space-y-10">
            
            {{-- SLIDER SECTION (EDITOR'S CHOICE) --}}
            <div class="border-4 border-black p-2 bg-white shadow-[8px_8px_0px_0px_#1c0213] relative group">
                {{-- Badge Editor: BG #131c02, Teks Putih --}}
                <div class="absolute -top-4 -left-2 bg-[#131c02] text-white px-4 py-1 font-black border-2 border-black z-20 shadow-sm transform -rotate-2">
                    EDITOR'S CHOICE 🔥
                </div>
                
                <div class="relative h-[400px] bg-black border-2 border-black overflow-hidden">
                    @if($featuredBooks->count() > 0)
                        <div x-data="{ activeSlide: 0, slides: {{ $featuredBooks->count() }} }" class="h-full w-full relative">
                            
                            @foreach($featuredBooks as $index => $book)
                                <div x-show="activeSlide === {{ $index }}"
                                     x-transition:enter="transition ease-out duration-500"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     class="absolute inset-0 bg-cover bg-center flex flex-col justify-end p-8"
                                     style="background-image: linear-gradient(to top, rgba(0,0,0,0.95) 10%, transparent 70%), url('{{ $book->cover_url ?? 'https://via.placeholder.com/800x400?text=No+Cover' }}');">
                                    
                                    <h2 class="text-4xl lg:text-5xl font-black text-white mb-2 leading-none drop-shadow-[2px_2px_0px_#000]">
                                        {{ $book->title }}
                                    </h2>
                                    
                                    {{-- Penulis: Teks #131c02 dengan Background Putih (Agar terbaca) --}}
                                    <p class="text-[#131c02] bg-white px-2 inline-block font-bold mb-4 uppercase tracking-widest text-xs">
                                        Ditulis oleh: {{ $book->user->name ?? 'Anonim' }}
                                    </p>
                                    
                                    {{-- Border Sinopsis: #131c02 --}}
                                    <p class="text-gray-300 text-sm line-clamp-2 max-w-2xl mb-6 border-l-4 border-[#131c02] pl-4">
                                        {{ $book->synopsis }}
                                    </p>
                                    
                                    {{-- Tombol Baca Hover: BG #131c02, Teks Putih --}}
                                    <a href="{{ route('book.detail', $book->id) }}" class="w-fit bg-white text-black border-2 border-black px-8 py-3 font-bold hover:bg-[#131c02] hover:text-white hover:shadow-[4px_4px_0px_0px_#000] transition-all uppercase tracking-widest text-xs">
                                        BACA SEKARANG
                                    </a>
                                </div>
                            @endforeach

                            {{-- Slider Nav Hover: BG #131c02, Teks Putih --}}
                            @if($featuredBooks->count() > 1)
                                <button @click="activeSlide = activeSlide === 0 ? slides - 1 : activeSlide - 1" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white border-2 border-black p-3 hover:bg-[#131c02] hover:text-white transition-colors z-20">◀</button>
                                <button @click="activeSlide = activeSlide === slides - 1 ? 0 : activeSlide + 1" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white border-2 border-black p-3 hover:bg-[#131c02] hover:text-white transition-colors z-20">▶</button>
                            @endif
                        </div>
                    @else
                        <div class="h-full w-full flex flex-col items-center justify-center text-white">
                            <span class="text-6xl mb-4">📚</span>
                            <h3 class="text-2xl font-bold uppercase">BELUM ADA BUKU FEATURED</h3>
                        </div>
                    @endif
                </div>
            </div>

            {{-- NEW RELEASES GRID --}}
            <div>
                <div class="flex items-center gap-4 mb-6 border-b-4 border-black pb-2">
                    <h3 class="text-3xl font-black bg-black text-white px-4 py-1 transform -skew-x-6">
                        NEW RELEASES
                    </h3>
                    {{-- Garis Pemisah: #131c02 --}}
                    <div class="h-1 bg-[#131c02] flex-grow"></div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    @forelse($recentBooks as $book)
                        <a href="{{ route('book.detail', $book->id) }}" class="group relative block bg-white border-2 border-black hover:-translate-y-1 hover:shadow-[4px_4px_0px_0px_#1c0213] transition-all h-full flex flex-col">
                            
                            <div class="aspect-[2/3] w-full overflow-hidden relative bg-gray-200">
                                @if($book->cover_url)
                                    <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center bg-gray-300 p-2 text-center">
                                        <span class="text-[10px] font-bold text-gray-500 break-words">{{ $book->title }}</span>
                                        <span class="text-xl font-black text-gray-400 mt-2">NO IMG</span>
                                    </div>
                                @endif
                                
                                {{-- Overlay Hover --}}
                                <div class="absolute inset-0 bg-black/80 flex flex-col justify-end p-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <h4 class="text-white text-xs font-bold uppercase leading-tight line-clamp-3">
                                        {{ $book->title }}
                                    </h4>
                                    {{-- Penulis Overlay: Teks #131c02, BG Putih --}}
                                    <p class="text-[10px] text-[#131c02] bg-white px-1 mt-1 truncate inline-block">
                                        {{ $book->user->name ?? 'Anonim' }}
                                    </p>
                                </div>

                                {{-- Badge New: BG #131c02, Teks Putih --}}
                                <div class="absolute top-0 left-0 bg-[#131c02] text-white text-[10px] font-black px-1 border-b border-r border-black">
                                    NEW
                                </div>
                            </div>
                            
                            <div class="p-2 border-t-2 border-black bg-white flex-grow flex items-center justify-center">
                                <h4 class="text-[11px] font-bold uppercase leading-tight line-clamp-2 group-hover:text-purple-700 transition-colors w-full text-center">
                                    {{ $book->title }}
                                </h4>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full border-2 border-dashed border-black p-8 text-center bg-gray-50">
                            <h3 class="text-sm font-bold text-gray-500">BELUM ADA BUKU.</h3>
                        </div>
                    @endforelse
                </div>
                
                <div class="mt-8">
                     {{ $recentBooks->links() }}
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN (SIDEBAR 1/4) --}}
        <div class="lg:col-span-1">
            <div class="sticky top-24 space-y-8">
                
                {{-- TOP RANKING WIDGET --}}
                {{-- Shadow: #131c02 --}}
                <div class="border-4 border-black bg-white shadow-[8px_8px_0px_0px_#131c02]">
                    <div class="bg-black text-white p-3 border-b-4 border-black">
                        <h3 class="text-xl font-black text-center uppercase tracking-wider">👑 Top Ranking</h3>
                    </div>
                    <ul class="divide-y-2 divide-black">
                        @forelse($rankedBooks as $index => $rank)
                            {{-- Ranking Item Hover: BG #131c02, Teks Putih --}}
                            <li class="p-4 hover:bg-[#131c02] hover:text-white transition-colors cursor-pointer group flex gap-3 items-center">
                                <div class="w-8 h-8 flex items-center justify-center font-black text-lg border-2 border-black bg-white text-black group-hover:bg-white group-hover:text-black transition-colors shadow-[2px_2px_0px_0px_#000]">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex-grow min-w-0">
                                    <a href="{{ route('book.detail', $rank->id) }}" class="font-bold text-sm uppercase truncate block group-hover:underline">
                                        {{ $rank->title }}
                                    </a>
                                    <span class="text-[10px] bg-cyan-300 text-black border border-black px-1 font-bold">
                                        {{ $rank->chapters_count ?? 0 }} Chapters
                                    </span>
                                </div>
                            </li>
                        @empty
                            <li class="p-4 text-center font-bold text-gray-500 text-sm">Belum ada data ranking.</li>
                        @endforelse
                    </ul>
                </div>

                {{-- POPULAR TAGS --}}
                <div class="border-4 border-black bg-white p-4">
                    <h4 class="font-black text-sm uppercase mb-4 border-b-2 border-black pb-2 inline-block">
                        Popular Tags
                    </h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['Action', 'Romance', 'Fantasy', 'Horror', 'System'] as $tag)
                            {{-- Tags Hover: BG #131c02, Teks Putih --}}
                            <button class="text-xs font-bold border-2 border-black px-3 py-1 hover:bg-[#131c02] hover:text-white transition-colors shadow-[2px_2px_0px_0px_#000] hover:shadow-none hover:translate-x-[1px] hover:translate-y-[1px]">
                                #{{ $tag }}
                            </button>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>