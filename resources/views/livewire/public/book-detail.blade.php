<div class="min-h-screen bg-white font-mono text-black">
    {{-- STYLE ROOT --}}
    <style>
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-left: 2px solid black; }
        ::-webkit-scrollbar-thumb { background: #000; border: 2px solid black; }
        ::-webkit-scrollbar-thumb:hover { background: #333; }
    </style>

    {{-- HEADER SECTION --}}
    <div class="bg-[#1c0213] border-b-4 border-black sticky top-0 z-50 shadow-2xl">
        <div class="max-w-7xl mx-auto px-6 py-3 flex flex-col md:flex-row items-center justify-between gap-4">
            
            {{-- LOGO --}}
            <a href="{{ route('home') }}" class="group flex items-center gap-2 select-none transition-transform hover:scale-105">
                <img src="{{ asset('images/abcsaga-logo.png') }}" alt="ABCSAGA Logo" class="h-14 w-auto object-contain">
            </a>
            
            {{-- SEARCH BAR --}}
            <form action="{{ route('search') }}" method="GET" class="w-full max-w-md">
                <div class="relative flex border-2 border-black bg-white shadow-[4px_4px_0px_0px_rgba(255,255,255,0.2)]">
                    <input 
                        type="text" 
                        name="q" 
                        value="{{ request('q') }}" 
                        placeholder="CARI JUDUL LAIN..." 
                        class="w-full bg-transparent border-none text-sm font-bold px-4 py-2 uppercase placeholder-gray-500 focus:ring-0"
                    >
                    {{-- Tombol Search Hover: BG #e97124 --}}
                    <button type="submit" class="bg-black text-white px-4 hover:bg-[#e97124] hover:text-black transition-colors border-l-2 border-black font-bold">
                        CARI
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="max-w-7xl mx-auto p-6 mt-8">
        
        {{-- BREADCRUMB SIMPLE --}}
        <div class="mb-6 flex gap-2 text-sm font-bold uppercase text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-black hover:underline">Home</a>
            <span>/</span>
            <span class="text-black">{{ $book->title }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            {{-- KOLOM KIRI: COVER (4 Bagian) --}}
            <div class="lg:col-span-4">
                <div class="sticky top-28">
                    {{-- Cover Image Container --}}
                    <div class="border-4 border-black bg-white p-2 shadow-[10px_10px_0px_0px_#000] relative">
                        <div class="aspect-[2/3] w-full overflow-hidden border-2 border-black bg-gray-200">
                            @if($book->cover_url)
                                <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center bg-gray-300 p-4 text-center">
                                    <span class="text-4xl">📕</span>
                                    <span class="text-xl font-black text-gray-500 mt-2 uppercase">No Cover</span>
                                </div>
                            @endif
                        </div>

                        {{-- Status Badge (Overlay): BG #e97124 --}}
                        <div class="absolute -top-4 -right-4 bg-[#e97124] text-black border-2 border-black px-4 py-1 font-black shadow-[4px_4px_0px_0px_#000] transform rotate-3">
                            {{ $book->is_published ? 'PUBLISHED' : 'DRAFT' }}
                        </div>
                    </div>

                    {{-- Stats Box --}}
                    <div class="mt-6 grid grid-cols-2 gap-4">
                        {{-- Shadow Stats: #e97124 --}}
                        <div class="bg-black text-white p-3 text-center border-2 border-black shadow-[4px_4px_0px_0px_#e97124]">
                            <span class="block text-xs text-gray-400 uppercase">Chapters</span>
                            <span class="text-2xl font-black">{{ $book->chapters->count() }}</span>
                        </div>
                        <div class="bg-white text-black p-3 text-center border-2 border-black shadow-[4px_4px_0px_0px_#000]">
                            <span class="block text-xs text-gray-500 uppercase">Views</span>
                            <span class="text-2xl font-black">0</span> {{-- Placeholder Views --}}
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: INFO & CHAPTERS (8 Bagian) --}}
            <div class="lg:col-span-8 space-y-8">
                
                {{-- INFO HEADER --}}
                <div class="border-b-4 border-black pb-6">
                    <h1 class="text-4xl md:text-6xl font-black uppercase leading-none mb-4 break-words">
                        {{ $book->title }}
                    </h1>
                    
                    <div class="flex flex-wrap items-center gap-4">
                        {{-- Author --}}
                        <div class="flex items-center gap-2 bg-gray-100 px-3 py-1 border-2 border-black rounded-full">
                            <span class="text-xl">✍️</span>
                            <span class="font-bold uppercase text-sm">{{ $book->user->name ?? 'Anonim' }}</span>
                        </div>
                        
                        {{-- Genre/Tags (Contoh) --}}
                        <div class="flex gap-2">
                            <span class="text-xs font-bold border border-black px-2 py-1 bg-white hover:bg-cyan-300 transition-colors cursor-pointer">#ACTION</span>
                            <span class="text-xs font-bold border border-black px-2 py-1 bg-white hover:bg-cyan-300 transition-colors cursor-pointer">#FANTASY</span>
                        </div>
                    </div>
                </div>

                {{-- SYNOPSIS --}}
                {{-- Background diubah ke Oranye Transparan (bg-[#e97124]/10) --}}
                <div class="bg-[#e97124]/10 border-l-8 border-black p-6 relative">
                    <h3 class="font-black text-lg uppercase mb-2">Synopsis</h3>
                    <p class="text-gray-800 leading-relaxed whitespace-pre-line">
                        {{ $book->synopsis }}
                    </p>
                    <div class="absolute top-0 right-0 p-2 opacity-10 pointer-events-none">
                        <span class="text-6xl">❝</span>
                    </div>
                </div>

                {{-- TOMBOL BACA TERBARU --}}
                @if($book->chapters->count() > 0)
                    <div class="flex gap-4">
                        {{-- Hover Button: BG #e97124 --}}
                        <a href="{{ route('chapter.read', $book->chapters->first()->id) }}" class="flex-1 bg-black text-white text-center py-4 font-black text-xl uppercase border-2 border-black hover:bg-[#e97124] hover:text-black hover:shadow-[6px_6px_0px_0px_#000] hover:-translate-y-1 transition-all">
                            MULAI BACA BAB 1
                        </a>
                    </div>
                @else
                    <div class="bg-gray-200 border-2 border-black p-4 text-center font-bold text-gray-500 border-dashed">
                        BELUM ADA CHAPTER YANG DIRILIS.
                    </div>
                @endif

                {{-- CHAPTER LIST --}}
                <div class="mt-12">
                    <div class="flex items-center justify-between border-b-4 border-black mb-6 pb-2">
                        <h3 class="text-2xl font-black uppercase flex items-center gap-2">
                            {{-- Kotak Icon: BG #e97124 --}}
                            <span class="bg-[#e97124] w-6 h-6 border-2 border-black block"></span>
                            DAFTAR CHAPTER
                        </h3>
                        <span class="text-sm font-bold">{{ $book->chapters->count() }} Total</span>
                    </div>

                    <div class="flex flex-col gap-3">
                        @forelse($book->chapters as $chapter)
                            {{-- Chapter Item Shadow Hover: #e97124 --}}
                            <a href="{{ route('chapter.read', $chapter->id) }}" class="group flex items-center justify-between p-4 border-2 border-black bg-white hover:bg-black hover:text-white transition-all shadow-[4px_4px_0px_0px_#ccc] hover:shadow-[4px_4px_0px_0px_#e97124] hover:-translate-x-1">
                                <div class="flex items-center gap-4">
                                    {{-- Nomor Chapter Hover: Text #e97124 --}}
                                    <span class="font-black text-lg text-gray-400 group-hover:text-[#e97124]">
                                        #{{ $loop->iteration }}
                                    </span>
                                    <div>
                                        <h4 class="font-bold text-lg uppercase">{{ $chapter->title }}</h4>
                                        <span class="text-xs text-gray-500 group-hover:text-gray-400 uppercase">
                                            Updated: {{ $chapter->created_at->format('d M Y') }}
                                        </span>
                                    </div>
                                </div>
                                <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                                    {{-- Teks Baca: Text #e97124 --}}
                                    <span class="font-bold text-[#e97124]">BACA ➔</span>
                                </div>
                            </a>
                        @empty
                            <div class="p-8 text-center text-gray-500 italic">
                                Penulis belum mengupload chapter apapun.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>