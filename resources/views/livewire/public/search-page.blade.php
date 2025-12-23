<div class="min-h-screen bg-white font-mono text-black">
    {{-- HEADER SECTION --}}
    <div class="bg-[#1c0213] border-b-4 border-black sticky top-0 z-50 shadow-2xl">
        <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col md:flex-row items-center justify-between gap-4">
            {{-- LOGO --}}
            <a href="{{ route('home') }}" class="group flex items-center gap-2 select-none hover:scale-105 transition-transform">
                <div class="leading-none">
                    <h1 class="text-3xl font-black text-white tracking-tighter">
                        ABC<span class="text-yellow-400">SAGA</span>
                    </h1>
                </div>
            </a>
            
            {{-- SEARCH BAR HEADER --}}
            <form action="{{ route('search') }}" method="GET" class="w-full max-w-md">
                <div class="relative flex border-2 border-black bg-white shadow-[4px_4px_0px_0px_rgba(255,255,255,0.2)]">
                    <input 
                        type="text" 
                        name="q" 
                        value="{{ request('q') }}" {{-- AMBIL LANGSUNG DARI REQUEST --}}
                        placeholder="CARI JUDUL LAIN..." 
                        class="w-full bg-transparent border-none text-sm font-bold px-4 py-2 uppercase placeholder-gray-500 focus:ring-0"
                    >
                    <button type="submit" class="bg-black text-white px-4 hover:bg-yellow-400 hover:text-black transition-colors border-l-2 border-black font-bold">
                        CARI
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="max-w-7xl mx-auto p-6 mt-8">
        
        {{-- HEADER HASIL --}}
        <div class="border-b-4 border-black pb-4 mb-8 flex flex-col md:flex-row items-start md:items-end justify-between gap-4">
            <div>
                <h2 class="text-4xl font-black uppercase">HASIL PENCARIAN</h2>
                @if(request('q'))
                    <p class="text-gray-600 font-bold mt-1 text-lg">
                        Menampilkan hasil untuk: "<span class="text-purple-700 bg-purple-100 px-1">{{ request('q') }}</span>"
                    </p>
                @else
                    <p class="text-gray-600 font-bold mt-1 text-lg">Menampilkan semua buku terbaru</p>
                @endif
            </div>
            
            <div class="bg-yellow-400 text-black px-4 py-2 font-black border-2 border-black text-sm shadow-[4px_4px_0px_0px_#000] transform -rotate-2">
                {{ $books->total() }} DITEMUKAN
            </div>
        </div>

        {{-- GRID HASIL --}}
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @forelse($books as $book)
                <a href="{{ route('book.detail', $book->id) }}" class="group relative block bg-white border-2 border-black hover:-translate-y-1 hover:shadow-[6px_6px_0px_0px_#1c0213] transition-all h-full flex flex-col">
                    
                    {{-- Cover Image --}}
                    <div class="aspect-[2/3] w-full overflow-hidden relative bg-gray-200 border-b-2 border-black">
                        @if($book->cover_url)
                            <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center bg-gray-300 p-2 text-center">
                                <span class="text-xs font-bold text-gray-500 mb-2">{{ $book->title }}</span>
                                <span class="text-xl font-black text-gray-400">NO IMG</span>
                            </div>
                        @endif

                        <div class="absolute inset-0 bg-black/80 flex flex-col justify-end p-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <p class="text-[10px] text-yellow-400 uppercase font-bold mb-1">
                                {{ $book->user->name ?? 'Anonim' }}
                            </p>
                            <p class="text-white text-xs line-clamp-3 leading-tight">
                                {{ $book->synopsis }}
                            </p>
                        </div>
                    </div>

                    {{-- Info Judul --}}
                    <div class="p-3 bg-white flex-grow flex items-center justify-center text-center">
                        <h4 class="text-xs font-black uppercase leading-tight line-clamp-2 group-hover:text-purple-700 transition-colors">
                            {{ $book->title }}
                        </h4>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-20 text-center border-4 border-dashed border-gray-300 bg-gray-50 rounded-lg">
                    <span class="text-6xl block mb-4">🤷‍♂️</span>
                    <h3 class="text-2xl font-black text-gray-400 uppercase">Tidak ditemukan.</h3>
                    <p class="text-gray-500 mt-2 font-bold">Coba kata kunci lain.</p>
                    <a href="{{ route('home') }}" class="inline-block mt-6 px-6 py-2 bg-black text-white font-bold border-2 border-black hover:bg-yellow-400 hover:text-black transition-colors">
                        KEMBALI KE BERANDA
                    </a>
                </div>
            @endforelse
        </div>

        {{-- PAGINATION --}}
        <div class="mt-12 mb-8">
            {{ $books->links() }}
        </div>
    </div>
</div>