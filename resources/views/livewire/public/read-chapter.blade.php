<div class="min-h-screen bg-orange-50 font-sans">
    
    <div class="sticky top-0 z-50 bg-white border-b-4 border-black px-4 py-3 flex justify-between items-center shadow-sm">
        <a href="{{ route('book.show', $this->chapter->book_id) }}" class="font-bold hover:underline text-sm md:text-base">
            &larr; <span class="hidden md:inline">KEMBALI KE</span> DAFTAR ISI
        </a>
        <h1 class="font-black uppercase truncate max-w-[200px] md:max-w-md text-center">
            {{ $chapter->book->title }}
        </h1>
        <div class="w-20"></div> </div>

    <div class="max-w-4xl mx-auto p-6 md:p-12">
        
        <div class="text-center mb-10 pb-6 border-b-2 border-black border-dashed">
            <span class="bg-black text-white px-3 py-1 font-mono text-sm font-bold mb-2 inline-block">
                CHAPTER {{ $chapter->order }}
            </span>
            <h2 class="text-4xl md:text-5xl font-black uppercase mt-2 leading-tight">
                {{ $chapter->title }}
            </h2>
        </div>

        <article class="prose prose-lg md:prose-xl max-w-none prose-headings:font-black prose-headings:uppercase prose-p:font-serif prose-p:leading-relaxed prose-blockquote:border-l-4 prose-blockquote:border-black prose-blockquote:bg-yellow-100 prose-blockquote:p-4 prose-blockquote:not-italic prose-img:border-4 prose-img:border-black">
            
            {!! $chapter->content !!}
            
        </article>

        <div class="mt-16 pt-8 border-t-4 border-black grid grid-cols-2 gap-4">
            
            @if($prev)
                <a href="{{ route('chapter.read', $prev->id) }}" class="group flex flex-col items-start justify-center p-4 border-4 border-black bg-white hover:bg-black hover:text-white transition-colors shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-none active:translate-y-1">
                    <span class="text-xs font-mono font-bold mb-1 opacity-70">SEBELUMNYA</span>
                    <span class="font-bold text-lg leading-tight group-hover:underline">{{ $prev->title }}</span>
                </a>
            @else
                <div class="opacity-0"></div> 
            @endif

            @if($next)
                <a href="{{ route('chapter.read', $next->id) }}" class="group flex flex-col items-end justify-center p-4 border-4 border-black bg-lime-300 hover:bg-black hover:text-white transition-colors shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-none active:translate-y-1 text-right">
                    <span class="text-xs font-mono font-bold mb-1 opacity-70">SELANJUTNYA</span>
                    <span class="font-bold text-lg leading-tight group-hover:underline">{{ $next->title }}</span>
                </a>
            @else
                <div class="flex items-center justify-center p-4 border-4 border-gray-300 text-gray-400 font-bold border-dashed">
                    AKHIR CERITA
                </div>
            @endif

        </div>

        <div class="mt-12 text-center">
            <p class="font-mono text-sm text-gray-500">
                --- END OF CHAPTER {{ $chapter->order }} ---
            </p>
        </div>
    </div>
</div>