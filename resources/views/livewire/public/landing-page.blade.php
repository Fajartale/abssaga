<div class="min-h-screen bg-white font-sans text-black">
    
    {{-- HERO SECTION --}}
    <div class="bg-yellow-300 border-b-4 border-black p-8 md:p-20 relative overflow-hidden">
        {{-- Background Decoration Text --}}
        <div class="absolute top-0 right-0 -mt-10 -mr-10 text-9xl text-yellow-400 font-black opacity-50 rotate-12 select-none z-0">
            ABCSAGA
        </div>

        <div class="relative z-10 max-w-4xl">
            <h1 class="text-6xl md:text-8xl font-black leading-none mb-6 tracking-tighter drop-shadow-[4px_4px_0px_rgba(0,0,0,1)]">
                TULIS.<br>BACA.<br>ULANGI.
            </h1>
            <p class="text-xl md:text-2xl font-bold font-mono border-l-4 border-black pl-4 mb-8 bg-white/50 inline-block p-2">
                Platform novel digital tanpa basa-basi.
            </p>
            <div class="flex flex-col md:flex-row gap-4">
                <a href="#browse" class="bg-black text-white px-8 py-4 text-xl font-bold border-2 border-transparent hover:bg-white hover:text-black hover:border-black hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transition-all text-center">
                    MULAI MEMBACA
                </a>
                
                @guest
                    <a href="{{ route('login') }}" class="bg-white text-black px-8 py-4 text-xl font-bold border-4 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all text-center">
                        JADI PENULIS
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="bg-white text-black px-8 py-4 text-xl font-bold border-4 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all text-center">
                        DASHBOARD PENULIS
                    </a>
                @endguest
            </div>
        </div>
    </div>

    {{-- FEATURED SECTION (PILIHAN EDITOR) --}}
    <div class="border-b-4 border-black bg-purple-100 p-8 md:p-12">
        <div class="flex items-center gap-4 mb-8">
            <div class="w-8 h-8 bg-black"></div>
            <h2 class="text-3xl font-black uppercase tracking-widest">PILIHAN EDITOR (Favorit)</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse($featuredBooks as $book)
            <a href="{{ route('book.show', $book->id) }}" class="group relative block bg-white border-4 border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-2 hover:translate-y-2 transition-all duration-200">
                <div class="flex flex-col md:flex-row h-full">
                    {{-- Cover Image --}}
                    <div class="w-full md:w-1/3 border-b-4 md:border-b-0 md:border-r-4 border-black bg-gray-200 aspect-[2/3] md:aspect-auto overflow-hidden">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/'.$book->cover_image) }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                        @else
                            <div class="flex items-center justify-center h-full text-4xl font-black text-gray-400">?</div>
                        @endif
                    </div>
                    
                    {{-- Book Details --}}
                    <div class="p-6 flex flex-col justify-between w-full md:w-2/3">
                        <div>
                            <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 border border-black mb-2 inline-block shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">HOT PICK</span>
                            <h3 class="text-2xl md:text-3xl font-black uppercase leading-tight mb-2 group-hover:underline decoration-4 decoration-purple-500">{{ $book->title }}</h3>
                            <p class="font-mono text-sm text-gray-600 mb-4 font-bold">Penulis: {{ $book->user->name }}</p>
                            <p class="text-sm line-clamp-3 font-medium border-l-2 border-black pl-3 italic">
                                "{{ $book->synopsis }}"
                            </p>
                        </div>
                        <div class="mt-4 text-right font-bold text-lg group-hover:mr-2 transition-all">BACA SEKARANG &rarr;</div>
                    </div>
                </div>
            </a>
            @empty
                <div class="col-span-full text-center py-10 font-mono font-bold text-gray-500">
                    Belum ada buku unggulan.
                </div>
            @endforelse
        </div>
    </div>

    {{-- RECENT BOOKS SECTION (TERBARU) --}}
    <div id="browse" class="p-8 md:p-12 bg-white">
        <div class="flex justify-between items-end mb-8 border-b-4 border-black pb-4">
            <h2 class="text-3xl font-black uppercase">TERBARU DIRILIS</h2>
            <span class="font-mono text-xs md:text-sm font-bold bg-black text-white px-2 py-1 rotate-3 inline-block">UPDATE SETIAP HARI</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($recentBooks as $book)
            <a href="{{ route('book.show', $book->id) }}" class="group flex flex-col bg-white border-4 border-black hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] transition-all duration-200">
                
                {{-- Cover Image --}}
                <div class="h-64 overflow-hidden border-b-4 border-black bg-gray-100 relative">
                     @if($book->cover_image)
                        <img src="{{ asset('storage/'.$book->cover_image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 grayscale group-hover:grayscale-0">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-xl font-bold text-gray-400">NO COVER</div>
                    @endif
                    
                    {{-- Tanggal Rilis Badge --}}
                    <div class="absolute top-0 right-0 bg-white border-l-2 border-b-2 border-black p-1 text-xs font-mono font-bold">
                        {{ $book->created_at->format('d M') }}
                    </div>
                </div>
                
                {{-- Judul & Penulis --}}
                <div class="p-4 flex-1 flex flex-col justify-between bg-white group-hover:bg-yellow-50 transition-colors">
                    <div>
                        <h3 class="font-black text-lg uppercase leading-tight mb-1 line-clamp-2">{{ $book->title }}</h3>
                        <p class="text-xs font-mono font-bold text-gray-500">Oleh: {{ $book->user->name }}</p>
                    </div>
                </div>
            </a>
            @empty
                <div class="col-span-full text-center py-20 border-4 border-dashed border-gray-300">
                    <p class="text-xl font-bold text-gray-400">Belum ada buku yang diterbitkan.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>