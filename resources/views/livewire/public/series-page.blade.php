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
    <div class="max-w-7xl mx-auto p-6 mt-8">
        
        {{-- JUDUL HALAMAN --}}
        <div class="border-b-4 border-black pb-4 mb-8 flex items-end justify-between">
            <div>
                <h1 class="text-4xl md:text-6xl font-black uppercase tracking-tighter">LIBRARY SERIES</h1>
                <p class="text-gray-500 font-bold mt-2">Jelajahi koleksi cerita terbaik kami.</p>
            </div>
            <div class="hidden md:block bg-[#e97124] text-black border-2 border-black px-4 py-1 font-black transform rotate-2 shadow-[4px_4px_0px_0px_#000]">
                {{ $books->total() }} JUDUL
            </div>
        </div>

        {{-- GENRE FILTER (Horizontal Scroll) --}}
        <div class="mb-10 overflow-x-auto pb-4">
            <div class="flex gap-3 min-w-max">
                @foreach($genres as $g)
                    <button wire:click="setGenre('{{ $g }}')" 
                            class="px-6 py-2 border-2 border-black font-bold text-sm uppercase transition-all shadow-[4px_4px_0px_0px_#000] hover:-translate-y-1 hover:shadow-[6px_6px_0px_0px_#e97124] 
                            {{ $genre === $g ? 'bg-[#e97124] text-black' : 'bg-white text-gray-500 hover:text-black' }}">
                        {{ $g }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- BOOKS GRID --}}
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @forelse($books as $book)
                <a href="{{ route('book.detail', $book->id) }}" class="group relative block bg-white border-2 border-black hover:-translate-y-1 hover:shadow-[6px_6px_0px_0px_#1c0213] transition-all h-full flex flex-col">
                    <div class="aspect-[2/3] w-full overflow-hidden relative bg-gray-200 border-b-2 border-black">
                        @if($book->cover_url)
                            <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center bg-gray-300 p-2 text-center">
                                <span class="text-xs font-bold text-gray-500 mb-2">{{ $book->title }}</span>
                                <span class="text-xl font-black text-gray-400">NO IMG</span>
                            </div>
                        @endif
                        <div class="absolute top-0 left-0 bg-[#e97124] text-black text-[10px] font-black px-2 py-1 border-b-2 border-r-2 border-black">
                            SERIES
                        </div>
                    </div>
                    <div class="p-3 bg-white flex-grow flex flex-col items-center justify-center text-center">
                        <h4 class="text-xs font-black uppercase leading-tight line-clamp-2 group-hover:text-[#e97124] transition-colors">
                            {{ $book->title }}
                        </h4>
                        <span class="text-[10px] text-gray-500 mt-1 font-bold">{{ $book->user->name ?? 'Anonim' }}</span>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-20 text-center border-4 border-dashed border-gray-300 rounded-lg">
                    <h3 class="text-2xl font-black text-gray-400 uppercase">Tidak ada buku di kategori ini.</h3>
                </div>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $books->links() }}
        </div>
    </div>
</div>