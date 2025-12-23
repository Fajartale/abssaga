<div class="min-h-screen bg-[#f8f8f8] font-mono text-black">
    
    {{-- CUSTOM STYLE --}}
    <style>
        /* Styling Konten Trix */
        .trix-content h1 { font-size: 2em; font-weight: bold; margin-bottom: 0.5em; }
        .trix-content p { margin-bottom: 1em; line-height: 1.8; }
        .trix-content blockquote { border-left: 4px solid #facc15; padding-left: 1rem; font-style: italic; margin: 1rem 0; background: #fff; padding: 1rem; }
        .trix-content ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 1rem; }
        .trix-content ol { list-style-type: decimal; padding-left: 1.5rem; margin-bottom: 1rem; }
        .trix-content a { color: blue; text-decoration: underline; }
        
        /* Progress Bar Reading Indicator */
        #progress-bar { width: 0%; height: 6px; background: #facc15; position: fixed; top: 0; left: 0; z-index: 100; border-bottom: 2px solid black; }

        /* --- FITUR ANTI COPY (CSS) --- */
        .prevent-select {
            -webkit-user-select: none; /* Safari */
            -ms-user-select: none; /* IE 10 and IE 11 */
            user-select: none; /* Standard syntax */
        }
    </style>

    {{-- PROGRESS BAR SCROLL --}}
    <div id="progress-bar"></div>

    {{-- NAVBAR SEDERHANA (STICKY) --}}
    <div class="bg-[#1c0213] text-white border-b-4 border-black sticky top-0 z-50 shadow-lg">
        <div class="max-w-4xl mx-auto px-4 py-3 flex justify-between items-center">
            
            {{-- Back Button --}}
            <a href="{{ route('book.detail', $book->id) }}" class="flex items-center gap-2 hover:text-yellow-400 transition-colors font-bold text-sm uppercase">
                <span>&larr; KEMBALI</span>
            </a>

            {{-- Judul Buku (Truncated) --}}
            <div class="hidden md:block font-bold text-yellow-400 tracking-widest text-sm">
                {{ Str::limit($book->title, 40) }}
            </div>

            {{-- Home Button --}}
            <a href="{{ route('home') }}" class="font-black text-xl hover:scale-110 transition-transform">
                ABC<span class="text-yellow-400">SAGA</span>
            </a>
        </div>
    </div>

    {{-- MAIN READING AREA (Diberi class prevent-select) --}}
    <div class="max-w-4xl mx-auto p-6 md:p-12 my-8 bg-white border-4 border-black shadow-[12px_12px_0px_0px_#1c0213] prevent-select" 
         oncontextmenu="return false;"> {{-- Matikan Klik Kanan di area ini --}}
        
        {{-- HEADER CHAPTER --}}
        <div class="text-center border-b-4 border-black pb-8 mb-8">
            <span class="bg-yellow-400 text-black px-3 py-1 font-bold border-2 border-black text-xs shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                CHAPTER {{ $chapter->order }}
            </span>
            <h1 class="text-4xl md:text-5xl font-black mt-4 uppercase leading-tight">
                {{ $chapter->title }}
            </h1>
            <p class="text-gray-500 text-sm mt-2 font-bold">
                Diposting: {{ $chapter->created_at->format('d M Y') }}
            </p>
        </div>

        {{-- NAVIGATION TOP --}}
        <div class="flex justify-between items-center gap-4 mb-10">
            @if($prevChapter)
                <a href="{{ route('chapter.read', $prevChapter->id) }}" class="flex-1 bg-white text-black text-center py-2 font-bold border-2 border-black hover:bg-black hover:text-white transition-all text-sm">
                    &larr; PREV
                </a>
            @else
                <button disabled class="flex-1 bg-gray-200 text-gray-400 py-2 font-bold border-2 border-gray-300 cursor-not-allowed text-sm">
                    &larr; PREV
                </button>
            @endif

            <a href="{{ route('book.detail', $book->id) }}" class="px-4 py-2 font-bold border-2 border-black hover:bg-gray-100 text-sm">
                LIST
            </a>

            @if($nextChapter)
                <a href="{{ route('chapter.read', $nextChapter->id) }}" class="flex-1 bg-black text-white text-center py-2 font-bold border-2 border-black hover:bg-yellow-400 hover:text-black transition-all text-sm">
                    NEXT &rarr;
                </a>
            @else
                <button disabled class="flex-1 bg-gray-200 text-gray-400 py-2 font-bold border-2 border-gray-300 cursor-not-allowed text-sm">
                    NEXT &rarr;
                </button>
            @endif
        </div>

        {{-- ISI KONTEN (TRIX HTML) --}}
        <div class="trix-content text-lg md:text-xl text-gray-900 leading-relaxed font-serif text-justify">
            {!! $chapter->content !!}
        </div>

        {{-- NAVIGATION BOTTOM --}}
        <div class="flex justify-between items-center gap-4 mt-16 pt-8 border-t-4 border-black">
             @if($prevChapter)
                <a href="{{ route('chapter.read', $prevChapter->id) }}" class="flex-1 bg-white text-black text-center py-4 font-black border-4 border-black hover:bg-black hover:text-white hover:shadow-[4px_4px_0px_0px_#facc15] transition-all">
                    &larr; CHAPTER SEBELUMNYA
                </a>
            @else
                <button disabled class="flex-1 bg-gray-100 text-gray-400 py-4 font-black border-4 border-gray-300 cursor-not-allowed">
                    INI CHAPTER AWAL
                </button>
            @endif

            @if($nextChapter)
                <a href="{{ route('chapter.read', $nextChapter->id) }}" class="flex-1 bg-yellow-400 text-black text-center py-4 font-black border-4 border-black hover:bg-black hover:text-white hover:shadow-[4px_4px_0px_0px_#ccc] transition-all">
                    CHAPTER BERIKUTNYA &rarr;
                </a>
            @else
                <button disabled class="flex-1 bg-gray-100 text-gray-400 py-4 font-black border-4 border-gray-300 cursor-not-allowed">
                    INI CHAPTER TERAKHIR
                </button>
            @endif
        </div>

    </div>

    {{-- FOOTER SIMPLE --}}
    <div class="max-w-4xl mx-auto px-6 pb-12 text-center text-gray-500 text-xs font-bold">
        &copy; 2025 ABCSAGA. Happy Reading!
    </div>

</div>

{{-- SCRIPT: PROGRESS BAR & ANTI COPY PROTECTION --}}
<script>
    // 1. Reading Progress Bar
    window.onscroll = function() {
        let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        let scrolled = (winScroll / height) * 100;
        document.getElementById("progress-bar").style.width = scrolled + "%";
    };

    // 2. Disable Right Click (Context Menu) Global
    document.addEventListener('contextmenu', event => event.preventDefault());

    // 3. Disable Keyboard Shortcuts (Ctrl+C, Ctrl+U, Ctrl+S, Ctrl+P, F12)
    document.onkeydown = function(e) {
        if(e.keyCode == 123) { // F12 (Inspect Element)
            return false;
        }
        if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) { // Ctrl+Shift+I
            return false;
        }
        if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) { // Ctrl+Shift+C
            return false;
        }
        if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) { // Ctrl+Shift+J
            return false;
        }
        if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) { // Ctrl+U (View Source)
            return false;
        }
        if(e.ctrlKey && e.keyCode == 'S'.charCodeAt(0)) { // Ctrl+S (Save)
            return false;
        }
        if(e.ctrlKey && e.keyCode == 'P'.charCodeAt(0)) { // Ctrl+P (Print)
            return false;
        }
        if(e.ctrlKey && e.keyCode == 'C'.charCodeAt(0)) { // Ctrl+C (Copy)
            return false;
        }
    }
</script>