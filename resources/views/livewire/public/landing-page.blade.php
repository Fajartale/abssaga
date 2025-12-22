<div class="min-h-screen bg-white font-mono">
    <style>
        .text-stroke-black {
            -webkit-text-stroke: 2px black;
        }
        .text-stroke-sm {
            -webkit-text-stroke: 1px black;
        }
        ::-webkit-scrollbar {
            width: 12px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-left: 2px solid black;
        }
        ::-webkit-scrollbar-thumb {
            background: #888;
            border: 2px solid black;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>

    <div class="bg-[#1c0213] border-b-4 border-black sticky top-0 z-50 shadow-2xl">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex flex-col lg:flex-row justify-between items-center gap-6">
                
                <div class="flex flex-col lg:flex-row items-center gap-8 w-full lg:w-auto">
                    <a href="{{ route('home') }}" class="group flex items-center gap-3 select-none hover:scale-105 transition-transform">
                        <div class="w-12 h-10 bg-white border-2 border-black relative shadow-[4px_4px_0px_0px_#facc15]">
                            <div class="absolute inset-0 border-r-2 border-black w-1/2 bg-gray-100"></div>
                            <div class="absolute top-2 left-1 w-8 h-1 bg-black"></div>
                            <div class="absolute top-4 left-1 w-8 h-1 bg-black"></div>
                            <div class="absolute top-6 left-1 w-6 h-1 bg-black"></div>
                        </div>
                        <div class="leading-none">
                            <h1 class="text-4xl font-black text-white tracking-tighter">
                                ABC<span class="text-yellow-400 text-stroke-sm">SAGA</span>
                            </h1>
                            <span class="text-[10px] bg-white px-1 font-bold tracking-widest border border-black block text-center -mt-1 transform -rotate-1">
                                EST. 2025
                            </span>
                        </div>
                    </a>

                    <nav class="flex gap-4">
                        <a href="#" class="relative px-6 py-2 bg-white text-black font-bold border-2 border-black shadow-[4px_4px_0px_0px_rgba(255,255,255,0.3)] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all text-sm uppercase tracking-wide">
                            Series
                        </a>
                        <a href="#" class="relative px-6 py-2 bg-yellow-400 text-black font-bold border-2 border-black shadow-[4px_4px_0px_0px_rgba(255,255,255,0.3)] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all text-sm uppercase tracking-wide flex items-center gap-2">
                            Ranking <span>🏆</span>
                        </a>
                    </nav>
                </div>

                <div class="w-full lg:w-auto flex-grow lg:flex-grow-0">
                    <div class="relative group w-full lg:w-[350px]">
                        <div class="absolute inset-0 bg-gray-600 translate-x-2 translate-y-2 border-2 border-black transition-transform group-focus-within:translate-x-1 group-focus-within:translate-y-1"></div>
                        <div class="relative flex border-2 border-black bg-white">
                            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari judul, penulis..." class="w-full bg-transparent border-none text-sm font-bold px-4 py-3 placeholder-gray-400 focus:ring-0 text-black uppercase tracking-wider">
                            <button class="bg-black text-white px-4 border-l-2 border-black hover:bg-yellow-400 hover:text-black transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto p-6 grid grid-cols-1 lg:grid-cols-4 gap-8 mt-8">
        
        <div class="lg:col-span-3 space-y-10">
            
            <div class="border-4 border-black p-2 bg-white shadow-[8px_8px_0px_0px_#1c0213] relative group">
                <div class="absolute -top-4 -left-2 bg-yellow-400 text-black px-4 py-1 font-black border-2 border-black z-20 shadow-sm transform -rotate-2">
                    HOT PICKS 🔥
                </div>
                
                <div class="relative h-[350px] overflow-hidden border-2 border-black bg-black">
                    @if($featuredBooks->count() > 0)
                        <div x-data="{ activeSlide: 0, slides: {{ $featuredBooks->count() }} }" class="h-full w-full">
                            @foreach($featuredBooks as $index => $book)
                                <div x-show="activeSlide === {{ $index }}" 
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     class="absolute inset-0 p-8 flex flex-col justify-end items-start bg-cover bg-center"
                                     style="background-image: linear-gradient(to top, rgba(0,0,0,0.9) 10%, transparent 60%), url('{{ $book->cover_image ? Storage::url($book->cover_image) : '' }}');">
                                    
                                    <h2 class="text-4xl md:text-5xl font-black text-white mb-2 leading-none drop-shadow-[2px_2px_0px_#000]">
                                        {{ $book->title }}
                                    </h2>
                                    <p class="text-sm md:text-base text-gray-200 mb-6 line-clamp-2 max-w-2xl font-medium border-l-4 border-yellow-400 pl-3">
                                        {{ $book->description }}
                                    </p>
                                    <a href="{{ route('book.detail', $book->id) }}" class="bg-white text-black border-2 border-black px-8 py-3 font-bold hover:bg-yellow-400 hover:shadow-[4px_4px_0px_0px_#000] transition-all uppercase tracking-widest text-xs">
                                        Baca Sekarang
                                    </a>
                                </div>
                            @endforeach

                            <button @click="activeSlide = activeSlide === 0 ? slides - 1 : activeSlide - 1" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white border-2 border-black p-2 hover:bg-yellow-400 hover:-translate-x-1 transition-all z-20">◀</button>
                            <button @click="activeSlide = activeSlide === slides - 1 ? 0 : activeSlide + 1" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white border-2 border-black p-2 hover:bg-yellow-400 hover:translate-x-1 transition-all z-20">▶</button>
                        </div>
                    @else
                        <div class="h-full w-full flex flex-col items-center justify-center text-white space-y-4">
                            <span class="text-6xl">📚</span>
                            <h3 class="text-2xl font-bold uppercase tracking-widest">Belum ada Featured Books</h3>
                            <p class="text-gray-400 text-sm">Tambahkan buku di dashboard admin.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div>
                <div class="flex items-center gap-4 mb-6 border-b-4 border-black pb-2">
                    <h3 class="text-3xl font-black bg-black text-white px-4 py-1 transform -skew-x-6">LATEST UPDATES</h3>
                    <div class="h-1 bg-yellow-400 flex-grow"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($books as $book)
                        <div class="group border-4 border-black bg-white hover:bg-yellow-50 transition-all hover:shadow-[8px_8px_0px_0px_#1c0213] hover:-translate-y-1 flex flex-col h-full">
                            <div class="h-48 bg-gray-200 border-b-4 border-black relative overflow-hidden">
                                @if($book->cover_image)
                                    <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                        <span class="text-5xl text-gray-300 font-black rotate-12 select-none">NO COVER</span>
                                    </div>
                                @endif
                                <div class="absolute top-2 right-2 bg-black text-white text-xs font-bold px-2 py-1 border border-white">{{ $book->chapters->count() }} CH</div>
                            </div>
                            <div class="p-5 flex flex-col flex-grow">
                                <h4 class="text-xl font-black uppercase mb-2 leading-tight group-hover:text-[#1c0213]">{{ $book->title }}</h4>
                                <p class="text-xs text-gray-600 line-clamp-3 mb-4 font-medium flex-grow">{{ $book->description }}</p>
                                <a href="{{ route('book.detail', $book->id) }}" class="w-full block text-center bg-transparent border-2 border-black py-2 font-bold text-sm hover:bg-black hover:text-white transition-colors uppercase">Detail Buku -></a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 border-2 border-dashed border-black p-12 text-center">
                            <h3 class="text-2xl font-bold text-gray-400">BELUM ADA BUKU.</h3>
                            <p class="text-gray-500">Silahkan cari judul lain.</p>
                        </div>
                    @endforelse
                </div>
                <div class="mt-10">{{ $books->links() }}</div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="sticky top-24">
                <div class="border-4 border-black bg-white shadow-[8px_8px_0px_0px_#facc15]">
                    <div class="bg-black text-white p-3 border-b-4 border-black">
                        <h3 class="text-xl font-black text-center uppercase tracking-wider">👑 Top Ranking</h3>
                    </div>
                    <ul class="divide-y-2 divide-black">
                        @foreach($rankedBooks as $index => $rank)
                            <li class="p-4 hover:bg-yellow-50 transition-colors cursor-pointer group flex gap-3 items-center">
                                <div class="w-10 h-10 flex items-center justify-center font-black text-2xl border-2 border-black bg-white group-hover:bg-black group-hover:text-white transition-colors shadow-[2px_2px_0px_0px_#000]">{{ $index + 1 }}</div>
                                <div class="flex-grow min-w-0">
                                    <a href="{{ route('book.detail', $rank->id) }}" class="font-bold text-sm uppercase truncate block hover:underline">{{ $rank->title }}</a>
                                    <span class="text-[10px] bg-yellow-300 border border-black px-1 font-bold">{{ $rank->chapters->count() }} Chapters</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="mt-8 border-4 border-black bg-white p-4">
                    <h4 class="font-black text-sm uppercase mb-4 border-b-2 border-black pb-2 inline-block">Popular Tags</h4>
                    <div class="flex flex-wrap gap-2">
                        @php $tags = ['Action', 'Romance', 'Fantasy', 'Horror', 'Wuxia', 'System']; @endphp
                        @foreach($tags as $tag)
                            <button class="text-xs font-bold border-2 border-black px-3 py-1 hover:bg-cyan-400 hover:text-white transition-colors shadow-[2px_2px_0px_0px_#000] hover:shadow-none hover:translate-x-[1px] hover:translate-y-[1px]">#{{ $tag }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>