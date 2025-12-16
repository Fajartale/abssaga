<div class="min-h-screen bg-yellow-50 py-12 px-4 sm:px-6 lg:px-8 font-sans">
    
    <div class="max-w-5xl mx-auto mb-6">
        <a href="{{ route('home') }}" class="inline-flex items-center font-bold text-black hover:underline decoration-4 decoration-pink-500 text-lg">
            &larr; KEMBALI KE BERANDA
        </a>
    </div>

    <div class="max-w-5xl mx-auto bg-white border-4 border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] overflow-hidden">
        
        <div class="grid grid-cols-1 md:grid-cols-12 gap-0">
            
            <div class="md:col-span-4 border-b-4 md:border-b-0 md:border-r-4 border-black bg-gray-100 p-6 flex items-center justify-center">
                <div class="relative w-full aspect-[2/3] border-4 border-black bg-white shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                    @if($book->cover_image)
                        <img src="{{ asset('storage/'.$book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-pink-500 text-white">
                            <span class="text-6xl font-black">?</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="md:col-span-8 p-6 md:p-10 flex flex-col justify-between">
                <div>
                    <h1 class="text-4xl md:text-6xl font-black uppercase leading-none mb-4 tracking-tighter">
                        {{ $book->title }}
                    </h1>
                    
                    <div class="inline-block bg-black text-white px-4 py-1 text-lg font-bold mb-6 transform -rotate-1">
                        PENULIS: {{ $book->user->name }}
                    </div>

                    <div class="border-2 border-black p-4 bg-blue-50 relative mb-6">
                        <span class="absolute -top-3 -left-2 bg-blue-500 text-white px-2 text-xs font-bold border-2 border-black">SINOPSIS</span>
                        <p class="text-gray-900 leading-relaxed font-medium">
                            {{ $book->synopsis }}
                        </p>
                    </div>
                </div>

                @if($firstChapter)
                    <a href="{{ route('chapter.read', $firstChapter->id) }}" class="group relative w-full block text-center bg-lime-400 border-4 border-black py-4 text-xl font-black uppercase hover:bg-lime-300 transition-all active:translate-y-1 active:shadow-none shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                        Mulai Baca Bab 1
                        <span class="hidden group-hover:inline-block ml-2 transition-transform duration-200 group-hover:translate-x-1">&rarr;</span>
                    </a>
                @else
                    <div class="w-full text-center bg-gray-200 border-4 border-black py-4 text-xl font-bold text-gray-500 cursor-not-allowed">
                        BELUM ADA CHAPTER
                    </div>
                @endif
            </div>
        </div>

        <div class="border-t-4 border-black bg-white">
            <div class="p-4 bg-black text-white border-b-4 border-black flex justify-between items-center">
                <h2 class="text-2xl font-black uppercase tracking-widest">DAFTAR CHAPTER</h2>
                <span class="bg-white text-black px-3 py-1 font-bold text-sm border-2 border-transparent rounded-none">
                    TOTAL: {{ $book->chapters->count() }}
                </span>
            </div>

            <div class="divide-y-4 divide-black">
                @forelse($book->chapters as $chapter)
                    <a href="{{ route('chapter.read', $chapter->id) }}" class="block p-5 hover:bg-pink-100 transition-colors group flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <span class="flex-shrink-0 w-12 h-12 flex items-center justify-center border-2 border-black bg-white font-black text-xl shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] group-hover:translate-x-0.5 group-hover:translate-y-0.5 group-hover:shadow-none transition-all">
                                {{ $loop->iteration }}
                            </span>
                            <span class="text-xl font-bold font-mono group-hover:underline decoration-4 decoration-black">
                                {{ $chapter->title }}
                            </span>
                        </div>
                        <span class="text-sm font-bold bg-gray-200 px-2 py-1 border border-black hidden sm:block">
                            BACA &rarr;
                        </span>
                    </a>
                @empty
                    <div class="p-10 text-center text-gray-500 font-mono">
                        <p class="text-xl">--- Belum ada chapter yang ditulis ---</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>