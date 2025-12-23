<div class="min-h-screen bg-white font-mono text-black">
    {{-- STYLE KHUSUS (Sama seperti Landing Page) --}}
    <style>
        .text-stroke-black { -webkit-text-stroke: 2px black; }
        .text-stroke-sm { -webkit-text-stroke: 1px black; }
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-left: 2px solid black; }
        ::-webkit-scrollbar-thumb { background: #000; border: 2px solid black; }
        ::-webkit-scrollbar-thumb:hover { background: #333; }
    </style>

    {{-- HEADER & NAVBAR --}}
    <div class="bg-[#1c0213] border-b-4 border-black sticky top-0 z-50 shadow-2xl">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex flex-col lg:flex-row justify-between items-center gap-6">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="group flex items-center gap-3 select-none hover:scale-105 transition-transform">
                    <div class="w-10 h-8 bg-white border-2 border-black relative shadow-[4px_4px_0px_0px_#facc15]">
                        <div class="absolute inset-0 border-r-2 border-black w-1/2 bg-gray-100"></div>
                        <div class="absolute top-2 left-1 w-6 h-1 bg-black"></div>
                    </div>
                    <div class="leading-none">
                        <h1 class="text-3xl font-black text-white tracking-tighter">
                            ABC<span class="text-yellow-400 text-stroke-sm">SAGA</span>
                        </h1>
                    </div>
                </a>

                {{-- Breadcrumb Simple --}}
                <div class="hidden lg:flex gap-2 text-white text-sm font-bold uppercase">
                    <a href="{{ route('home') }}" class="hover:text-yellow-400 hover:underline">Home</a>
                    <span>/</span>
                    <span class="text-yellow-400">{{ Str::limit($book->title, 20) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="max-w-7xl mx-auto p-6 md:p-12">
        
        {{-- SECTION 1: BOOK HERO (INFO UTAMA) --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 mb-16">
            
            {{-- COVER IMAGE (KIRI) --}}
            <div class="lg:col-span-4">
                <div class="border-4 border-black bg-white p-2 shadow-[12px_12px_0px_0px_#1c0213] relative group">
                    <div class="aspect-[2/3] bg-gray-200 border-2 border-black overflow-hidden relative">
                        @if($book->cover_image)
                            <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-300">
                                <span class="text-5xl font-black text-gray-400 -rotate-12 select-none">NO COVER</span>
                            </div>
                        @endif
                        
                        {{-- Badge Status --}}
                        <div class="absolute top-4 right-4 bg-yellow-400 border-2 border-black px-3 py-1 font-bold text-xs shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                            ONGOING
                        </div>
                    </div>
                </div>
            </div>

            {{-- DETAIL INFO (KANAN) --}}
            <div class="lg:col-span-8 flex flex-col justify-between">
                <div>
                    {{-- Judul Besar --}}
                    <h1 class="text-5xl md:text-7xl font-black uppercase leading-[0.9] mb-4 tracking-tighter drop-shadow-[4px_4px_0px_#facc15]">
                        {{ $book->title }}
                    </h1>

                    {{-- Meta Info --}}
                    <div class="flex flex-wrap gap-3 mb-8">
                        <div class="bg-black text-white px-3 py-1 font-bold border-2 border-transparent text-sm">
                            Author: {{ $book->user->name ?? 'Unknown' }}
                        </div>
                        <div class="bg-white text-black px-3 py-1 font-bold border-2 border-black text-sm">
                            {{ $book->chapters->count() }} Chapters
                        </div>
                        <div class="bg-cyan-300 text-black px-3 py-1 font-bold border-2 border-black text-sm shadow-[2px_2px_0px_0px_#000]">
                            Fantasy / Action
                        </div>
                    </div>

                    {{-- Sinopsis --}}
                    <div class="mb-8">
                        <h3 class="font-black text-xl bg-yellow-400 inline-block px-2 border-2 border-black mb-2 transform -rotate-1">
                            SYNOPSIS
                        </h3>
                        <p class="text-lg leading-relaxed text-gray-800 border-l-4 border-black pl-6 italic font-medium">
                            "{{ $book->synopsis }}"
                        </p>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row gap-4 mt-4">
                    @if($firstChapter)
                        <a href="{{ route('chapter.read', $firstChapter->id) }}" class="flex-1 bg-black text-white text-center py-4 text-xl font-black border-4 border-black hover:bg-yellow-400 hover:text-black hover:shadow-[8px_8px_0px_0px_#1c0213] transition-all uppercase">
                            MULAI BACA BAB 1 🚀
                        </a>
                    @else
                        <button disabled class="flex-1 bg-gray-300 text-gray-500 text-center py-4 text-xl font-black border-4 border-gray-400 cursor-not-allowed uppercase">
                            BELUM ADA CHAPTER
                        </button>
                    @endif

                    <button class="flex-none px-8 py-4 bg-white text-black text-xl font-black border-4 border-black hover:bg-gray-100 hover:shadow-[8px_8px_0px_0px_#1c0213] transition-all">
                        Bookmark 🔖
                    </button>
                </div>
            </div>
        </div>

        {{-- SECTION 2: CHAPTER LIST --}}
        <div class="border-t-4 border-black pt-12">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-10 h-10 bg-black text-white flex items-center justify-center font-bold border-2 border-black shadow-[4px_4px_0px_0px_#facc15]">
                    #
                </div>
                <h2 class="text-4xl font-black uppercase tracking-tighter">
                    DAFTAR CHAPTER
                </h2>
            </div>

            <div class="bg-gray-50 border-4 border-black p-4 md:p-8 shadow-[12px_12px_0px_0px_#1c0213]">
                @if($book->chapters->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($book->chapters as $chapter)
                            <a href="{{ route('chapter.read', $chapter->id) }}" class="group relative bg-white border-2 border-black p-4 hover:bg-yellow-300 hover:-translate-y-1 transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)] hover:shadow-[4px_4px_0px_0px_#000]">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="font-black text-2xl text-gray-200 group-hover:text-black transition-colors">
                                        {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                    <span class="text-[10px] font-bold border border-black px-1 bg-white group-hover:bg-black group-hover:text-white transition-colors">
                                        READ
                                    </span>
                                </div>
                                <h4 class="font-bold text-lg uppercase leading-tight line-clamp-2 group-hover:underline decoration-2">
                                    {{ $chapter->title }}
                                </h4>
                                <div class="mt-2 text-xs font-bold text-gray-500 group-hover:text-black">
                                    {{ $chapter->created_at->format('d M Y') }}
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <h3 class="text-2xl font-bold text-gray-400 uppercase">PENULIS BELUM UPLOAD CHAPTER 😔</h3>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>