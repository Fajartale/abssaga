<div class="min-h-screen bg-white font-mono text-black">
    {{-- HEADER (Konsisten) --}}
    <div class="bg-[#1c0213] border-b-4 border-black sticky top-0 z-50 shadow-2xl">
        <div class="max-w-7xl mx-auto px-6 py-3 flex flex-col md:flex-row items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="group flex items-center gap-2 select-none hover:scale-105 transition-transform">
                <img src="{{ asset('images/abcsaga-logo.png') }}" alt="ABCSAGA Logo" class="h-14 w-auto object-contain">
            </a>
            <form action="{{ route('search') }}" method="GET" class="w-full max-w-md">
                <div class="relative flex border-2 border-black bg-white shadow-[4px_4px_0px_0px_rgba(255,255,255,0.2)]">
                    <input type="text" name="q" placeholder="CARI JUDUL LAIN..." class="w-full bg-transparent border-none text-sm font-bold px-4 py-2 uppercase placeholder-gray-500 focus:ring-0">
                    <button type="submit" class="bg-black text-white px-4 hover:bg-[#e97124] hover:text-black transition-colors border-l-2 border-black font-bold">CARI</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="max-w-5xl mx-auto p-6 mt-8">
        
        <div class="text-center mb-12">
            <h1 class="text-5xl md:text-7xl font-black uppercase text-stroke-black text-transparent bg-clip-text bg-gradient-to-b from-black to-gray-800" style="-webkit-text-stroke: 2px black; color: white;">
                TOP RANKING
            </h1>
            <p class="text-xl font-bold bg-[#e97124] inline-block px-6 py-1 border-2 border-black mt-4 shadow-[4px_4px_0px_0px_#000] transform -rotate-2">
                MOST ACTIVE NOVELS
            </p>
        </div>

        {{-- LEADERBOARD LIST --}}
        <div class="flex flex-col gap-4">
            @forelse($books as $index => $book)
                <div class="group flex items-center bg-white border-2 border-black p-4 shadow-[6px_6px_0px_0px_#000] hover:-translate-y-1 hover:shadow-[8px_8px_0px_0px_#e97124] transition-all relative overflow-hidden">
                    
                    {{-- RANK NUMBER --}}
                    <div class="flex-shrink-0 w-16 h-16 flex items-center justify-center border-4 border-black font-black text-3xl 
                        {{ $index == 0 ? 'bg-[#e97124] text-black' : 
                          ($index == 1 ? 'bg-gray-300 text-black' : 
                          ($index == 2 ? 'bg-[#d68f5c] text-white' : 'bg-white text-black')) }}">
                        {{ $index + 1 }}
                    </div>

                    {{-- BOOK INFO --}}
                    <div class="ml-6 flex-grow">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-2">
                            <div>
                                <h3 class="text-xl md:text-2xl font-black uppercase leading-none group-hover:text-[#e97124] transition-colors">
                                    <a href="{{ route('book.detail', $book->id) }}">
                                        {{ $book->title }}
                                    </a>
                                </h3>
                                <p class="text-xs font-bold text-gray-500 mt-1 uppercase">
                                    Author: {{ $book->user->name ?? 'Anonim' }}
                                </p>
                            </div>
                            
                            {{-- STATS --}}
                            <div class="flex items-center gap-4 mt-2 md:mt-0">
                                <div class="text-right">
                                    <span class="block text-xs font-bold text-gray-400 uppercase">Total Chapters</span>
                                    <span class="block text-2xl font-black">{{ $book->chapters_count }}</span>
                                </div>
                                <a href="{{ route('book.detail', $book->id) }}" class="hidden md:block bg-black text-white px-6 py-2 font-bold border-2 border-black hover:bg-[#e97124] hover:text-black transition-colors">
                                    READ
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- DECORATION FOR TOP 1 --}}
                    @if($index == 0)
                        <div class="absolute -right-6 -top-6 text-9xl opacity-10 rotate-12 pointer-events-none">👑</div>
                    @endif
                </div>
            @empty
                <div class="text-center p-10 border-4 border-dashed border-gray-300">
                    <h3 class="text-xl font-bold text-gray-400">Belum ada data ranking.</h3>
                </div>
            @endforelse
        </div>
    </div>
</div>