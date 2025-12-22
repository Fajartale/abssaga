<div class="min-h-screen bg-white font-sans text-black">
    
    {{-- HERO SECTION (KUNING) --}}
    <div class="bg-yellow-300 border-b-4 border-black p-8 md:p-20 relative overflow-hidden">
        {{-- Background Decoration --}}
        <div class="absolute top-0 right-0 -mt-10 -mr-10 text-9xl text-yellow-400 font-black opacity-50 rotate-12 select-none z-0">
            ABCSAGA
        </div>

        <div class="relative z-10 max-w-4xl">
            <h1 class="text-6xl md:text-8xl font-black leading-none mb-6 tracking-tighter drop-shadow-[4px_4px_0px_rgba(0,0,0,1)]">
                TULIS.<br>BACA.<br>ULANGI.
            </h1>
            <div class="flex flex-col md:flex-row gap-4 mt-8">
                <a href="#browse" class="bg-black text-white px-8 py-4 text-xl font-bold border-2 border-transparent hover:bg-white hover:text-black hover:border-black hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transition-all text-center">
                    MULAI MEMBACA
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-white text-black px-8 py-4 text-xl font-bold border-4 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all text-center">
                        DASHBOARD
                    </a>
                @endauth
            </div>
        </div>
    </div>

    {{-- SLIDER SECTION (PILIHAN EDITOR - UNGU) --}}
    <div class="border-b-4 border-black bg-purple-100 p-8 md:p-12">
        <div class="flex items-center gap-4 mb-8">
            <div class="w-8 h-8 bg-black"></div>
            <h2 class="text-3xl font-black uppercase tracking-widest">PILIHAN EDITOR (HOT 🔥)</h2>
        </div>

        {{-- AREA SLIDER --}}
        <div class="border-4 border-black bg-white shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] relative h-[500px] md:h-[400px]">
            @if($featuredBooks->count() > 0)
                <div x-data="{ activeSlide: 0, slides: {{ $featuredBooks->count() }} }" class="h-full w-full relative overflow-hidden">
                    
                    @foreach($featuredBooks as $index => $book)
                        <div x-show="activeSlide === {{ $index }}"
                             x-transition:enter="transition ease-out duration-500"
                             x-transition:enter-start="opacity-0 translate-x-full"
                             x-transition:enter-end="opacity-100 translate-x-0"
                             x-transition:leave="transition ease-in duration-300"
                             x-transition:leave-start="opacity-100 translate-x-0"
                             x-transition:leave-end="opacity-0 -translate-x-full"
                             class="absolute inset-0 flex flex-col md:flex-row h-full w-full bg-white">
                            
                            {{-- Gambar Cover --}}
                            <div class="w-full md:w-1/3 h-1/2 md:h-full border-b-4 md:border-b-0 md:border-r-4 border-black bg-gray-200 relative overflow-hidden">
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/'.$book->cover_image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="flex items-center justify-center h-full text-4xl font-black text-gray-400">NO COVER</div>
                                @endif
                                <div class="absolute top-4 left-4 bg-yellow-400 border-2 border-black px-3 py-1 font-bold text-xs shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                                    FEATURED #{{ $index + 1 }}
                                </div>
                            </div>

                            {{-- Info Buku --}}
                            <div class="w-full md:w-2/3 p-6 md:p-10 flex flex-col justify-center bg-white">
                                <h3 class="text-3xl md:text-5xl font-black uppercase leading-none mb-4 line-clamp-2">
                                    {{ $book->title }}
                                </h3>
                                <p class="font-mono font-bold text-purple-600 mb-4 text-lg">
                                    Ditulis oleh: {{ $book->user->name }}
                                </p>
                                <p class="text-gray-600 font-medium text-sm md:text-base line-clamp-3 mb-6 border-l-4 border-yellow-400 pl-4 italic">
                                    "{{ $book->synopsis }}"
                                </p>
                                <a href="{{ route('book.detail', $book->id) }}" class="w-fit bg-black text-white px-8 py-3 font-bold text-lg hover:bg-yellow-400 hover:text-black hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transition-all border-2 border-transparent hover:border-black">
                                    BACA SEKARANG &rarr;
                                </a>
                            </div>
                        </div>
                    @endforeach

                    {{-- Tombol Navigasi Slider --}}
                    @if($featuredBooks->count() > 1)
                        <button @click="activeSlide = activeSlide === 0 ? slides - 1 : activeSlide - 1" class="absolute bottom-4 left-4 md:bottom-auto md:top-1/2 md:-translate-y-1/2 md:left-4 bg-white border-2 border-black p-3 hover:bg-yellow-300 shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] z-20">
                            ◀ PREV
                        </button>
                        <button @click="activeSlide = activeSlide === slides - 1 ? 0 : activeSlide + 1" class="absolute bottom-4 right-4 md:bottom-auto md:top-1/2 md:-translate-y-1/2 md:right-4 bg-white border-2 border-black p-3 hover:bg-yellow-300 shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] z-20">
                            NEXT ▶
                        </button>
                    @endif

                </div>
            @else
                <div class="flex items-center justify-center h-full">
                    <p class="text-2xl font-black text-gray-400 uppercase">Belum ada buku featured.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- MAIN CONTENT (SPLIT LAYOUT) --}}
    <div id="browse" class="max-w-7xl mx-auto p-6 md:p-12 grid grid-cols-1 lg:grid-cols-4 gap-12">
        
        {{-- KOLOM KIRI: BUKU TERBARU --}}
        <div class="lg:col-span-3">
            <div class="flex justify-between items-end mb-8 border-b-4 border-black pb-4">
                <h2 class="text-3xl font-black uppercase">TERBARU DIRILIS</h2>
                <span class="hidden md:inline-block font-mono text-sm font-bold bg-black text-white px-2 py-1 rotate-3">FRESH UPDATE</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @forelse($recentBooks as $book)
                <a href="{{ route('book.detail', $book->id) }}" class="group flex flex-col bg-white border-4 border-black hover:shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] hover:-translate-y-1 transition-all duration-200">
                    {{-- Cover Image --}}
                    <div class="h-48 overflow-hidden border-b-4 border-black bg-gray-100 relative">
                         @if($book->cover_image)
                            <img src="{{ asset('storage/'.$book->cover_image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 grayscale group-hover:grayscale-0">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-xl font-bold text-gray-400">NO COVER</div>
                        @endif
                        <div class="absolute top-0 right-0 bg-yellow-300 border-l-2 border-b-2 border-black p-1 text-xs font-black">
                            BARU
                        </div>
                    </div>
                    
                    <div class="p-4 flex-1 flex flex-col justify-between bg-white group-hover:bg-yellow-50">
                        <div>
                            <h3 class="font-black text-xl uppercase leading-tight mb-2 line-clamp-2">{{ $book->title }}</h3>
                            <p class="text-xs font-mono font-bold text-gray-500">Oleh: {{ $book->user->name }}</p>
                        </div>
                        <div class="mt-4 pt-4 border-t-2 border-gray-200 group-hover:border-black text-right text-sm font-bold">
                            LIHAT DETAIL ->
                        </div>
                    </div>
                </a>
                @empty
                    <div class="col-span-full text-center py-20 border-4 border-dashed border-gray-300">
                        <p class="text-xl font-bold text-gray-400">Belum ada buku.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $recentBooks->links() }}
            </div>
        </div>

        {{-- KOLOM KANAN: TOP RANKING --}}
        <div class="lg:col-span-1">
            <div class="sticky top-10">
                <div class="border-4 border-black bg-white shadow-[8px_8px_0px_0px_#facc15]">
                    <div class="bg-black text-white p-4 border-b-4 border-black">
                        <h3 class="text-xl font-black text-center uppercase tracking-wider">👑 TOP RANKING</h3>
                    </div>
                    
                    <ul class="divide-y-4 divide-black">
                        @forelse($rankedBooks as $index => $rank)
                            <li class="p-4 hover:bg-yellow-100 transition-colors cursor-pointer group flex gap-3 items-start">
                                <div class="w-10 h-10 flex-shrink-0 flex items-center justify-center font-black text-2xl border-2 border-black bg-white text-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex-grow min-w-0">
                                    <a href="{{ route('book.detail', $rank->id) }}" class="font-bold text-sm uppercase leading-tight block hover:underline mb-1">
                                        {{ $rank->title }}
                                    </a>
                                    <div class="flex flex-wrap gap-1">
                                        <span class="text-[10px] bg-cyan-300 border border-black px-1 font-bold">
                                            {{ $rank->chapters_count }} Chapters
                                        </span>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="p-4 text-center text-gray-500 font-bold italic">
                                Belum ada data ranking.
                            </li>
                        @endforelse
                    </ul>
                </div>

                {{-- TAGS (Tambahan Kosmetik) --}}
                <div class="mt-8 border-4 border-black bg-white p-4">
                    <h4 class="font-black text-sm uppercase mb-4 border-b-2 border-black pb-2 inline-block">POPULAR TAGS</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['Action', 'Romance', 'Fantasy', 'Horror', 'Comedy'] as $tag)
                            <button class="text-xs font-bold border-2 border-black px-3 py-1 hover:bg-black hover:text-white transition-colors shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-[1px] hover:translate-y-[1px]">
                                #{{ $tag }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>