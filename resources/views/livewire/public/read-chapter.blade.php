<div class="min-h-screen bg-[#f8f8f8] text-black font-mono">
    {{-- STYLE ROOT --}}
    <style>
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-left: 2px solid black; }
        ::-webkit-scrollbar-thumb { background: #000; border: 2px solid black; }
        ::-webkit-scrollbar-thumb:hover { background: #333; }
        
        /* Typography khusus untuk area baca agar nyaman */
        .prose-content {
            font-family: 'Georgia', 'Times New Roman', serif;
            line-height: 1.8;
            font-size: 1.125rem; /* 18px */
        }
        .prose-content p { margin-bottom: 1.5em; }
    </style>

    {{-- HEADER SECTION (Konsisten) --}}
    <div class="bg-[#1c0213] border-b-4 border-black sticky top-0 z-50 shadow-2xl">
        <div class="max-w-7xl mx-auto px-6 py-3 flex flex-col md:flex-row items-center justify-between gap-4">
            
            {{-- LOGO --}}
            <a href="{{ route('home') }}" class="group flex items-center gap-2 select-none transition-transform hover:scale-105">
                <img src="{{ asset('images/abcsaga-logo.png') }}" alt="ABCSAGA Logo" class="h-14 w-auto object-contain">
            </a>
            
            {{-- SEARCH BAR --}}
            <form action="{{ route('search') }}" method="GET" class="w-full max-w-md">
                <div class="relative flex border-2 border-black bg-white shadow-[4px_4px_0px_0px_rgba(255,255,255,0.2)]">
                    <input 
                        type="text" 
                        name="q" 
                        value="{{ request('q') }}" 
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
    <div class="max-w-5xl mx-auto p-4 md:p-8 mt-4">
        
        {{-- TOP NAVIGATION BAR --}}
        <div class="bg-white border-2 border-black p-4 mb-8 shadow-[6px_6px_0px_0px_#000] flex flex-col md:flex-row items-center justify-between gap-4">
            {{-- Breadcrumb / Info Buku --}}
            <div class="flex items-center gap-2 text-sm font-bold overflow-hidden w-full md:w-auto">
                <a href="{{ route('book.detail', $chapter->book->id) }}" class="flex items-center gap-2 hover:text-purple-700 whitespace-nowrap">
                    <span class="bg-black text-white px-2 py-1">⬅ KEMBALI</span>
                    <span class="truncate max-w-[150px] md:max-w-xs">{{ $chapter->book->title }}</span>
                </a>
            </div>

            {{-- Chapter Selector (Dropdown) --}}
            <div class="w-full md:w-auto">
                <select onchange="location = this.value;" class="w-full md:w-64 bg-yellow-400 border-2 border-black font-bold px-4 py-2 text-sm focus:ring-0 cursor-pointer hover:bg-yellow-500 transition-colors uppercase">
                    @foreach($chapter->book->chapters as $c)
                        <option value="{{ route('chapter.read', $c->id) }}" {{ $c->id == $chapter->id ? 'selected' : '' }}>
                            Chapter {{ $loop->iteration }}: {{ Str::limit($c->title, 20) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- READING AREA --}}
        <article class="bg-white border-2 border-black p-6 md:p-12 shadow-[8px_8px_0px_0px_#000] relative">
            
            {{-- Chapter Header --}}
            <header class="mb-10 text-center border-b-2 border-black pb-6 border-dashed">
                <h1 class="text-3xl md:text-5xl font-black uppercase mb-4 leading-tight">
                    {{ $chapter->title }}
                </h1>
                <div class="text-sm font-bold text-gray-500 uppercase flex justify-center gap-4">
                    <span>Posted: {{ $chapter->created_at->format('d M Y') }}</span>
                    <span>•</span>
                    <span>By: {{ $chapter->book->user->name ?? 'Anonim' }}</span>
                </div>
            </header>

            {{-- Chapter Content --}}
            {{-- Menggunakan class 'prose-content' untuk font Serif yang nyaman dibaca --}}
            <div class="prose-content text-justify text-gray-900">
                {!! nl2br(e($chapter->content)) !!}
            </div>

            {{-- Footer Note --}}
            <div class="mt-12 pt-8 border-t-4 border-black text-center">
                <span class="bg-black text-white px-4 py-1 font-bold text-sm transform -rotate-1 inline-block">
                    END OF CHAPTER
                </span>
            </div>
        </article>

        {{-- BOTTOM NAVIGATION BUTTONS --}}
        <div class="mt-8 grid grid-cols-2 gap-4">
            {{-- Tombol Previous --}}
            @php
                $prevChapter = $chapter->book->chapters->where('order', '<', $chapter->order)->sortByDesc('order')->first();
                $nextChapter = $chapter->book->chapters->where('order', '>', $chapter->order)->sortBy('order')->first();
            @endphp

            @if($prevChapter)
                <a href="{{ route('chapter.read', $prevChapter->id) }}" class="flex flex-col items-center justify-center bg-white border-2 border-black p-4 shadow-[4px_4px_0px_0px_#000] hover:bg-yellow-400 hover:-translate-y-1 transition-all group">
                    <span class="text-xs font-bold text-gray-500 uppercase mb-1">Previous</span>
                    <span class="text-lg font-black group-hover:underline">PREV CHAPTER</span>
                </a>
            @else
                <button disabled class="flex flex-col items-center justify-center bg-gray-200 border-2 border-gray-400 p-4 opacity-50 cursor-not-allowed">
                    <span class="text-lg font-black text-gray-500">START</span>
                </button>
            @endif

            {{-- Tombol Next --}}
            @if($nextChapter)
                <a href="{{ route('chapter.read', $nextChapter->id) }}" class="flex flex-col items-center justify-center bg-black text-white border-2 border-black p-4 shadow-[4px_4px_0px_0px_#facc15] hover:bg-yellow-400 hover:text-black hover:-translate-y-1 transition-all group">
                    <span class="text-xs font-bold text-gray-400 group-hover:text-black uppercase mb-1">Next</span>
                    <span class="text-lg font-black group-hover:underline">NEXT CHAPTER</span>
                </a>
            @else
                <button disabled class="flex flex-col items-center justify-center bg-gray-200 border-2 border-gray-400 p-4 opacity-50 cursor-not-allowed">
                    <span class="text-lg font-black text-gray-500">LATEST</span>
                </button>
            @endif
        </div>

        {{-- Section Komentar (Opsional Placeholder) --}}
        <div class="mt-12 border-t-4 border-black pt-8">
            <h3 class="text-xl font-black uppercase mb-4">Komentar</h3>
            <div class="bg-gray-100 border-2 border-black p-8 text-center text-gray-500 italic">
                Fitur komentar belum tersedia.
            </div>
        </div>

    </div>
</div>