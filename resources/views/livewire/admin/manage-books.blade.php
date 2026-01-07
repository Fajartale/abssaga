<div class="min-h-screen bg-white font-mono text-black">
    
    {{-- CUSTOM SCROLLBAR --}}
    <style>
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-left: 2px solid black; }
        ::-webkit-scrollbar-thumb { background: #000; border: 2px solid black; }
        ::-webkit-scrollbar-thumb:hover { background: #333; }
    </style>

    {{-- HEADER KHUSUS (Mirip Dashboard) --}}
    <div class="bg-[#1c0213] border-b-4 border-black sticky top-0 z-50 shadow-2xl">
        <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between">
            <div class="flex items-center gap-4">
                {{-- Tombol Kembali --}}
                <a href="{{ route('dashboard') }}" class="bg-white text-black px-4 py-1 font-black border-2 border-black hover:bg-[#e97124] hover:text-black transition-all shadow-[4px_4px_0px_0px_#e97124] hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] uppercase text-sm">
                    ⬅ Kembali
                </a>
                <h1 class="text-white font-black text-xl uppercase tracking-wider hidden md:block">
                    {{ $bookId ? 'Edit Novel' : 'Novel Baru' }}
                </h1>
            </div>
            
            {{-- Logo Kecil --}}
            <img src="{{ asset('images/abcsaga-logo.png') }}" alt="Logo" class="h-10 w-auto object-contain opacity-50 grayscale hover:grayscale-0 transition-all">
        </div>
    </div>

    {{-- CONTENT SECTION --}}
    <div class="max-w-5xl mx-auto p-6 mt-8 mb-20">
        
        {{-- CARD UTAMA --}}
        <div class="bg-white border-4 border-black p-6 md:p-10 shadow-[8px_8px_0px_0px_#000] relative">
            
            {{-- JUDUL HALAMAN --}}
            <div class="mb-10 border-b-4 border-black pb-6">
                <h2 class="text-4xl md:text-5xl font-black uppercase mb-2">
                    {{ $bookId ? 'PERBARUI KARYA' : 'MULAI TULISAN BARU' }}
                </h2>
                <p class="text-gray-600 font-bold text-lg bg-[#e97124] text-black w-fit px-2 inline-block transform -skew-x-12">
                    Isi detail bukumu dengan semenarik mungkin!
                </p>
            </div>

            <form wire:submit.prevent="save" class="space-y-8">
                
                {{-- 1. INPUT JUDUL --}}
                <div class="group">
                    <label class="block font-black text-xl uppercase mb-3 flex items-center gap-2">
                        <span class="bg-black text-white px-2 py-1 transform -rotate-2">JUDUL BUKU</span>
                    </label>
                    <input type="text" wire:model="title" placeholder="CONTOH: PENDEKAR TANPA BAYANGAN..." 
                        class="w-full border-4 border-black p-4 text-xl font-bold bg-gray-50 focus:bg-white focus:ring-0 focus:outline-none focus:shadow-[6px_6px_0px_0px_#e97124] transition-all placeholder-gray-400">
                    @error('title') 
                        <div class="mt-2 bg-red-500 text-white font-bold px-3 py-1 border-2 border-black w-fit text-sm shadow-[2px_2px_0px_0px_#000]">
                            ⚠ {{ $message }}
                        </div> 
                    @enderror
                </div>

                {{-- 2. INPUT SINOPSIS --}}
                <div class="group">
                    <label class="block font-black text-xl uppercase mb-3 flex items-center gap-2">
                        <span class="bg-black text-white px-2 py-1 transform rotate-1">SINOPSIS</span>
                    </label>
                    <textarea wire:model="synopsis" rows="6" placeholder="Ceritakan ringkasan cerita yang membuat pembaca tidak bisa tidur..." 
                        class="w-full border-4 border-black p-4 text-lg font-bold bg-gray-50 focus:bg-white focus:ring-0 focus:outline-none focus:shadow-[6px_6px_0px_0px_#e97124] transition-all placeholder-gray-400"></textarea>
                    @error('synopsis') 
                        <div class="mt-2 bg-red-500 text-white font-bold px-3 py-1 border-2 border-black w-fit text-sm shadow-[2px_2px_0px_0px_#000]">
                            ⚠ {{ $message }}
                        </div> 
                    @enderror
                </div>

                {{-- GRID: COVER & OPSI --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                    
                    {{-- 3. UPLOAD COVER --}}
                    <div>
                        <label class="block font-black text-xl uppercase mb-3">
                            <span class="bg-black text-white px-2 py-1">COVER (OPSIONAL)</span>
                        </label>
                        
                        <div class="border-4 border-black border-dashed bg-gray-100 p-6 text-center relative hover:bg-orange-50 transition-colors cursor-pointer group shadow-[4px_4px_0px_0px_#ccc]">
                            {{-- Input File Invisible --}}
                            <input type="file" wire:model="cover" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            
                            @if ($cover)
                                {{-- Preview Gambar Baru --}}
                                <img src="{{ $cover->temporaryUrl() }}" class="h-64 mx-auto border-4 border-black shadow-[4px_4px_0px_0px_#000] object-cover transform group-hover:scale-105 transition-transform">
                                <p class="font-black text-sm mt-3 text-[#e97124] uppercase bg-black w-fit mx-auto px-2">Preview Baru</p>
                            @elseif ($old_cover)
                                {{-- Cover Lama --}}
                                <img src="{{ $old_cover }}" class="h-64 mx-auto border-4 border-black shadow-[4px_4px_0px_0px_#000] object-cover">
                                <p class="font-black text-sm mt-3 text-white uppercase bg-gray-400 w-fit mx-auto px-2">Cover Saat Ini</p>
                            @else
                                {{-- Placeholder --}}
                                <div class="h-64 flex flex-col items-center justify-center text-gray-400 group-hover:text-[#e97124] transition-colors border-2 border-gray-300 border-dashed">
                                    <span class="text-6xl">🖼️</span>
                                    <span class="font-black text-lg mt-4 uppercase">KLIK UNTUK UPLOAD</span>
                                    <span class="text-xs font-bold">(JPG/PNG, Max 2MB)</span>
                                </div>
                            @endif
                        </div>

                        {{-- Loading State --}}
                        <div wire:loading wire:target="cover" class="text-[#e97124] font-black text-sm mt-2 flex items-center gap-2">
                            <span class="animate-spin">⚙️</span> Sedang memproses gambar...
                        </div>
                        @error('cover') 
                            <div class="mt-2 bg-red-500 text-white font-bold px-3 py-1 border-2 border-black w-fit text-sm shadow-[2px_2px_0px_0px_#000]">
                                ⚠ {{ $message }}
                            </div> 
                        @enderror
                    </div>

                    {{-- 4. STATUS & TOMBOL --}}
                    <div class="flex flex-col gap-6 h-full justify-between">
                        
                        {{-- Status Publikasi --}}
                        <div>
                            <label class="block font-black text-xl uppercase mb-3">
                                <span class="bg-black text-white px-2 py-1">STATUS PUBLIKASI</span>
                            </label>
                            
                            <div class="flex flex-col gap-3">
                                {{-- Pilihan DRAFT --}}
                                <label class="cursor-pointer flex items-center gap-4 p-4 border-4 border-black w-full hover:bg-gray-100 transition-all shadow-[4px_4px_0px_0px_#ccc] hover:shadow-[2px_2px_0px_0px_#000] hover:translate-x-[2px] hover:translate-y-[2px]">
                                    <input type="radio" wire:model="is_published" value="0" class="peer sr-only">
                                    <div class="w-6 h-6 border-4 border-black peer-checked:bg-black transition-all"></div>
                                    <div>
                                        <span class="block font-black text-xl uppercase">DRAFT</span>
                                        <span class="text-sm font-bold text-gray-500">Hanya saya yang bisa baca</span>
                                    </div>
                                </label>

                                {{-- Pilihan PUBLISH --}}
                                <label class="cursor-pointer flex items-center gap-4 p-4 border-4 border-black w-full hover:bg-orange-50 transition-all shadow-[4px_4px_0px_0px_#ccc] hover:shadow-[2px_2px_0px_0px_#e97124] hover:translate-x-[2px] hover:translate-y-[2px]">
                                    <input type="radio" wire:model="is_published" value="1" class="peer sr-only">
                                    <div class="w-6 h-6 border-4 border-black peer-checked:bg-[#e97124] transition-all"></div>
                                    <div>
                                        <span class="block font-black text-xl uppercase text-[#e97124]">PUBLISH</span>
                                        <span class="text-sm font-bold text-gray-500">Tampil untuk semua pembaca</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- DIVIDER --}}
                        <div class="border-t-4 border-black border-dashed my-2"></div>

                        {{-- TOMBOL AKSI UTAMA --}}
                        <div class="flex flex-col gap-4">
                            
                            <button type="submit" wire:loading.attr="disabled" class="w-full bg-[#e97124] text-black text-xl font-black px-6 py-4 border-4 border-black shadow-[6px_6px_0px_0px_#000] hover:bg-black hover:text-white hover:shadow-[6px_6px_0px_0px_#e97124] hover:-translate-y-1 transition-all uppercase disabled:opacity-50 disabled:cursor-not-allowed flex justify-center items-center gap-2">
                                <span wire:loading.remove wire:target="save">
                                    {{ $bookId ? 'SIMPAN PERUBAHAN' : 'BUAT NOVEL SEKARANG' }} ➔
                                </span>
                                <span wire:loading wire:target="save">MENYIMPAN...</span>
                            </button>

                            @if($bookId)
                                <a href="{{ route('book.chapters', $bookId) }}" class="w-full bg-white text-black text-lg font-black px-6 py-3 border-4 border-black shadow-[6px_6px_0px_0px_#ccc] hover:bg-indigo-600 hover:text-white hover:border-black hover:shadow-[6px_6px_0px_0px_#000] hover:-translate-y-1 transition-all uppercase text-center flex justify-center items-center gap-2">
                                    📝 Kelola Daftar Chapter
                                </a>
                            @endif
                            
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>