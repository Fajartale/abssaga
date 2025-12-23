<div class="min-h-screen bg-white font-mono text-black">
    {{-- HEADER SIMPLE --}}
    <div class="bg-[#1c0213] border-b-4 border-black sticky top-0 z-50 shadow-2xl">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="group flex items-center gap-2 select-none">
                <div class="leading-none">
                    <h1 class="text-2xl font-black text-white tracking-tighter">
                        ABC<span class="text-yellow-400">SAGA</span>
                    </h1>
                </div>
            </a>
            
            {{-- Search Bar di Header (Agar user bisa cari ulang) --}}
            <form action="{{ route('search') }}" method="GET" class="w-full max-w-md ml-8">
                <div class="relative flex border-2 border-black bg-white">
                    <input type="text" name="q" value="{{ $search }}" placeholder="CARI JUDUL LAIN..." class="w-full bg-transparent border-none text-sm font-bold px-4 py-2 uppercase placeholder-gray-500 focus:ring-0">
                    <button type="submit" class="bg-black text-white px-4 hover:bg-yellow-400 hover:text-black transition-colors">🔍</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="max-w-7xl mx-auto p-6 mt-8">
        <div class="border-b-4 border-black pb-4 mb-8 flex items-end justify-between">
            <div>
                <h2 class="text-4xl font-black uppercase">HASIL PENCARIAN</h2>
                <p class="text-gray-600 font-bold mt-1">
                    Menampilkan hasil untuk: "<span class="text-purple-700">{{ $search }}</span>"
                </p>
            </div>
            <div class="bg-yellow-400 text-black px-3 py-1 font-bold border-2 border-black text-xs shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                {{ $books->total() }} DITEMUKAN
            </div>
        </div>

        {{-- GRID HASIL --}}
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @forelse($books as $book)
                <a href="{{ route('book.detail', $book->id) }}" class="group relative block bg-white border-2 border-black hover:-translate-y-1 hover:shadow-[6px_6px_0px_0px_#1c0213] transition-all h-full flex flex-col">
                    {{-- Cover --}}
                    <div class="aspect-[2/3] w-full overflow-hidden relative bg-gray-200 border-b-2 border-black">
                        @if($book->cover_url)
                            <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center bg-gray-300 p-2 text-center">
                                <span class="text-xl font-black text-gray-400">NO IMG</span>
                            </div>
                        @endif
                    </div>
                    {{-- Info --}}
                    <div class="p-3 bg-white flex-grow">
                        <h4 class="text-sm font-black uppercase leading-tight line-clamp-2 group-hover:text-purple-700 transition-colors">
                            {{ $book->title }}
                        </h4>
                        <p class="text-xs font-bold text-gray-500 mt-1">
                            {{ $book->user->name ?? 'Anonim' }}
                        </p>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-20 text-center border-4 border-dashed border-gray-300">
                    <span class="text-6xl">🤷‍♂️</span>
                    <h3 class="text-2xl font-black text-gray-400 mt-4 uppercase">Tidak ditemukan buku dengan kata kunci tersebut.</h3>
                    <a href="{{ route('home') }}" class="inline-block mt-4 text-black font-bold underline hover:text-purple-700">Kembali ke Beranda</a>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $books->links() }}
        </div>
    </div>
</div>