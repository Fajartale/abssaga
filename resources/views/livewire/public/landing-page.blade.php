<div class="min-h-screen bg-white font-mono">
    <style>
        .text-stroke-black {
            -webkit-text-stroke: 2px black;
        }
    </style>

    <div class="bg-[#410854] border-b-4 border-black p-8">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-6xl font-black mb-4 uppercase tracking-tighter text-white">
                ABC<span class="text-yellow-400 text-stroke-black">SAGA</span>
            </h1>
            <div class="flex gap-0">
                <input 
                    wire:model.live.debounce.300ms="search" 
                    type="text" 
                    placeholder="CARI BUKU DISINI..." 
                    class="w-full bg-white border-4 border-black text-2xl p-4 font-bold placeholder-gray-400 focus:ring-0 focus:border-black shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]"
                >
                <button class="bg-black text-white font-bold px-8 border-4 border-black hover:bg-white hover:text-black transition-all hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transform hover:-translate-y-1">
                    CARI
                </button>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto p-6 grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <div class="lg:col-span-3 space-y-8">
            
            @if($featuredBooks->count() > 0)
            <div x-data="{ activeSlide: 0, slides: {{ $featuredBooks->count() }} }" class="border-4 border-black p-2 bg-white shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] relative">
                <div class="absolute top-0 left-0 bg-black text-white px-4 py-1 font-bold z-10">
                    FEATURED 🔥
                </div>
                
                <div class="relative h-[300px] overflow-hidden bg-gray-100 border-2 border-black">
                    @foreach($featuredBooks as $index => $book)
                        <div x-show="activeSlide === {{ $index }}" 
                             class="absolute inset-0 p-8 flex flex-col justify-center items-start transition-opacity duration-500 bg-cover bg-center"
                             style="background-image: linear-gradient(to right, white 30%, rgba(255,255,255,0.8) 50%, transparent), url('{{ $book->cover_image ? Storage::url($book->cover_image) : '' }}');">
                            
                            <h2 class="text-4xl font-black bg-white inline-block px-2 border-2 border-black mb-2 truncate max-w-full z-10">
                                {{ $book->title }}
                            </h2>
                            <p class="text-lg bg-yellow-300 inline-block px-2 border-2 border-black mb-4 line-clamp-2 max-w-[80%] z-10">
                                {{ $book->description }}
                            </p>
                            <a href="{{ route('book.detail', $book->id) }}" class="bg-cyan-400 text-black border-2 border-black px-6 py-2 font-bold hover:bg-cyan-300 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] z-10">
                                BACA SEKARANG
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-between mt-2">
                    <button @click="activeSlide = activeSlide === 0 ? slides - 1 : activeSlide - 1" class="border-2 border-black px-4 py-1 font-bold hover:bg-gray-200">PREV</button>
                    <div class="font-bold flex items-center gap-1">
                        <template x-for="i in slides">
                            <div :class="activeSlide === i-1 ? 'bg-black' : 'bg-gray-300'" class="w-3 h-3 border border-black"></div>
                        </template>
                    </div>
                    <button @click="activeSlide = activeSlide === slides - 1 ? 0 : activeSlide + 1" class="border-2 border-black px-4 py-1 font-bold hover:bg-gray-200">NEXT</button>
                </div>
            </div>
            @endif

            <div>
                <h3 class="text-3xl font-black border-b-4 border-black mb-6 inline-block bg-white pr-4">
                    DAFTAR PUSTAKA
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($books as $book)
                        <div class="group border-4 border-black bg-white hover:bg-yellow-50 transition-all hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:-translate-y-1">
                            
                            <div class="h-40 bg-gray-200 border-b-4 border-black flex items-center justify-center relative overflow-hidden">
                                @if($book->cover_image)
                                    <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-6xl text-gray-300 font-black rotate-12 select-none group-hover:text-yellow-400 transition-colors">BOOK</span>
                                @endif
                            </div>

                            <div class="p-4">
                                <h4 class="text-xl font-bold truncate uppercase mb-2 group-hover:underline decoration-wavy">{{ $book->title }}</h4>
                                <p class="text-sm text-gray-600 line-clamp-2 mb-4 h-10">{{ $book->description }}</p>
                                
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-bold bg-gray-200 border border-black px-2 py-1">
                                        {{ $book->chapters->count() }} Chapter
                                    </span>
                                    <a href="{{ route('book.detail', $book->id) }}" class="text-sm font-bold underline decoration-2 hover:bg-black hover:text-white px-1">
                                        LIHAT ->
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 border-2 border-dashed border-black p-8 text-center font-bold text-gray-500">
                            TIDAK ADA BUKU DITEMUKAN.
                        </div>
                    @endforelse
                </div>

                <div class="mt-8">
                    {{ $books->links() }}
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="sticky top-6 border-4 border-black bg-white p-4 shadow-[8px_8px_0px_0px_#ff0000]">
                <h3 class="text-2xl font-black bg-red-500 text-white border-2 border-black p-2 text-center mb-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                    TOP RANKING
                </h3>
                
                <ul class="space-y-4">
                    @foreach($rankedBooks as $index => $rank)
                        <li class="flex items-start gap-3 group cursor-pointer">
                            <div class="text-3xl font-black text-stroke-black text-transparent group-hover:text-red-500 transition-colors">
                                #{{ $index + 1 }}
                            </div>
                            <div class="border-b-2 border-black w-full pb-2">
                                <a href="{{ route('book.detail', $rank->id) }}" class="font-bold block text-lg leading-tight group-hover:underline">
                                    {{ $rank->title }}
                                </a>
                                <span class="text-xs bg-black text-white px-1 mt-1 inline-block">
                                    {{ $rank->chapters->count() }} Chapters
                                </span>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-8 pt-6 border-t-4 border-black">
                    <h4 class="font-bold mb-3 uppercase">Kategori Populer</h4>
                    <div class="flex flex-wrap gap-2">
                        @php $tags = ['Action', 'Romance', 'Fantasy', 'Horror', 'Comedy', 'Slice of Life']; @endphp
                        @foreach($tags as $tag)
                            <button class="border-2 border-black px-2 py-1 text-sm font-bold hover:bg-yellow-300 hover:shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] transition-all">
                                {{ $tag }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>