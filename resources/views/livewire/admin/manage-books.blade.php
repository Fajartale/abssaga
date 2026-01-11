<div class="min-h-screen bg-white font-mono text-black">
    
    {{-- HEADER KHUSUS --}}
    <div class="bg-[#1c0213] border-b-4 border-black sticky top-0 z-50 shadow-2xl">
        <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between">
            <div class="flex items-center gap-4">
                {{-- Tombol Kembali --}}
                <a href="{{ route('dashboard') }}" class="bg-white text-black px-3 py-1 font-bold border-2 border-black hover:bg-[#e97124] transition-colors shadow-[2px_2px_0px_0px_#e97124]">
                    ⬅ KEMBALI
                </a>
                <h1 class="text-white font-black text-xl uppercase tracking-wider hidden md:block">
                    {{ $bookId ? 'EDIT NOVEL' : 'NOVEL BARU' }}
                </h1>
            </div>
            
            {{-- Logo --}}
            <img src="{{ asset('images/abcsaga-logo.png') }}" alt="Logo" class="h-10 w-auto object-contain opacity-50">
        </div>
    </div>

    {{-- FORM SECTION --}}
    <div class="max-w-4xl mx-auto p-6 mt-8 mb-20">
        
        <div class="bg-white border-4 border-black p-6 md:p-10 shadow-[8px_8px_0px_0px_#e97124] relative">
            
            {{-- Judul Form --}}
            <div class="mb-8 border-b-4 border-black pb-4">
                <h2 class="text-3xl font-black uppercase">
                    {{ $bookId ? 'PERBARUI KARYA' : 'MULAI TULISAN BARU' }}
                </h2>
                <p class="text-gray-500 font-bold mt-1">
                    Isi detail buku Anda dengan menarik agar pembaca penasaran.
                </p>
            </div>

            <form wire:submit.prevent="save" class="space-y-8">
                
                {{-- 1. INPUT JUDUL --}}
                <div class="group">
                    <label class="block font-black text-lg uppercase mb-2 bg-black text-white w-fit px-2 transform -rotate-1">
                        JUDUL BUKU
                    </label>
                    <input type="text" wire:model="title" placeholder="CONTOH: PENDEKAR TANPA BAYANGAN..." 
                        class="w-full border-4 border-black p-4 text-lg font-bold bg-gray-50 focus:bg-white focus:ring-0 focus:outline-none focus:shadow-[4px_4px_0px_0px_#e97124] transition-all placeholder-gray-400">
                    @error('title') <span class="text-red-600 font-black text-sm mt-1 block bg-red-100 p-1 border border-red-600 w-fit">⚠ {{ $message }}</span> @enderror
                </div>

                {{-- 2. INPUT SINOPSIS --}}
                <div class="group">
                    <label class="block font-black text-lg uppercase mb-2 bg-black text-white w-fit px-2 transform rotate-1">
                        SINOPSIS
                    </label>
                    <textarea wire:model="synopsis" rows="6" placeholder="Ceritakan ringkasan cerita yang membuat pembaca tidak bisa tidur..." 
                        class="w-full border-4 border-black p-4 text-lg font-bold bg-gray-50 focus:bg-white focus:ring-0 focus:outline-none focus:shadow-[4px_4px_0px_0px_#e97124] transition-all placeholder-gray-400"></textarea>
                    @error('synopsis') <span class="text-red-600 font-black text-sm mt-1 block bg-red-100 p-1 border border-red-600 w-fit">⚠ {{ $message }}</span> @enderror
                {{-- 3. PILIH GENRE (Multi Select) --}}
                <div class="group">
                    <label class="block font-black text-lg uppercase mb-2 bg-black text-white w-fit px-2">
                        PILIH GENRE (MINIMAL 1)
                    </label>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 border-4 border-black p-4 bg-gray-50">
                        @foreach($allGenres as $genre)
                            <label class="cursor-pointer flex items-center gap-2 hover:bg-yellow-200 p-1 transition-colors">
                                <input type="checkbox" wire:model="selectedGenres" value="{{ $genre->id }}" 
                                    class="w-5 h-5 border-2 border-black text-[#e97124] focus:ring-[#e97124]">
                                <span class="font-bold text-sm uppercase">{{ $genre->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('selectedGenres') 
                        <span class="text-red-600 font-black text-sm mt-1 block bg-red-100 p-1 border border-red-600 w-fit">
                            ⚠ {{ $message }}
                        </span> 
                    @enderror
                </div>
                
                </div>

                {{-- 3. GRID COVER & STATUS --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    {{-- UPLOAD COVER --}}
                    <div>
                        <label class="block font-black text-lg uppercase mb-2 bg-black text-white w-fit px-2">
                            COVER (OPSIONAL)
                        </label>
                        
                        <div class="border-4 border-black border-dashed bg-gray-100 p-4 text-center relative hover:bg-orange-50 transition-colors cursor-pointer group h-[280px] flex flex-col justify-center items-center">
                            {{-- Input File Invisible --}}
                            <input type="file" wire:model="cover" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            
                            @if ($cover)
                                {{-- Preview Gambar Baru --}}
                                <img src="{{ $cover->temporaryUrl() }}" class="h-48 mx-auto border-2 border-black shadow-sm object-cover">
                                <p class="font-bold text-xs mt-2 text-[#e97124] uppercase">Preview Gambar Baru</p>
                            @elseif ($old_cover)
                                {{-- Tampilkan Cover Lama --}}
                                <img src="{{ $old_cover }}" class="h-48 mx-auto border-2 border-black shadow-sm object-cover">
                                <p class="font-bold text-xs mt-2 text-gray-500 uppercase">Cover Saat Ini</p>
                            @else
                                {{-- Placeholder Kosong --}}
                                <div class="flex flex-col items-center justify-center text-gray-400 group-hover:text-[#e97124] transition-colors">
                                    <span class="text-4xl">🖼️</span>
                                    <span class="font-bold text-sm mt-2">KLIK UNTUK UPLOAD</span>
                                    <span class="text-xs">(JPG/PNG, Max 2MB)</span>
                                </div>
                            @endif
                        </div>
                        
                        {{-- Loading State --}}
                        <div wire:loading wire:target="cover" class="text-[#e97124] font-bold text-xs mt-2 animate-pulse">
                            Sedang mengupload gambar...
                        </div>
                        @error('cover') <span class="text-red-600 font-black text-sm mt-1 block">⚠ {{ $message }}</span> @enderror
                    </div>

                    {{-- PILIH STATUS (YANG DIPERBAIKI) --}}
                    <div class="flex flex-col justify-start">
                        <label class="block font-black text-lg uppercase mb-2 bg-black text-white w-fit px-2">
                            STATUS PUBLIKASI
                        </label>
                        
                        <div class="flex flex-col gap-4 mt-2">
                            
                            {{-- Pilihan DRAFT --}}
                            <div class="relative">
                                <input type="radio" id="status_draft" wire:model.live="is_published" value="0" class="peer sr-only">
                                <label for="status_draft" class="cursor-pointer flex items-center gap-4 p-4 border-4 border-black w-full bg-white hover:bg-gray-100 transition-all peer-checked:bg-gray-200 peer-checked:shadow-[inset_4px_4px_0px_0px_rgba(0,0,0,0.1)]">
                                    {{-- Custom Checkbox Box --}}
                                    <div class="w-6 h-6 border-2 border-black bg-white flex items-center justify-center peer-checked:bg-black transition-colors">
                                        <div class="w-3 h-3 bg-white opacity-0 peer-checked:opacity-100"></div>
                                    </div>
                                    <div>
                                        <span class="block font-black text-xl uppercase">DRAFT</span>
                                        <span class="text-sm font-bold text-gray-500">Hanya saya yang lihat</span>
                                    </div>
                                </label>
                            </div>

                            {{-- Pilihan PUBLISH --}}
                            <div class="relative">
                                <input type="radio" id="status_publish" wire:model.live="is_published" value="1" class="peer sr-only">
                                <label for="status_publish" class="cursor-pointer flex items-center gap-4 p-4 border-4 border-black w-full bg-white hover:bg-orange-50 transition-all peer-checked:bg-[#e97124] peer-checked:text-black peer-checked:shadow-[inset_4px_4px_0px_0px_rgba(0,0,0,0.2)]">
                                    {{-- Custom Checkbox Box --}}
                                    <div class="w-6 h-6 border-2 border-black bg-white flex items-center justify-center peer-checked:bg-black transition-colors">
                                        <div class="w-3 h-3 bg-white opacity-0 peer-checked:opacity-100"></div>
                                    </div>
                                    <div>
                                        <span class="block font-black text-xl uppercase">PUBLISH</span>
                                        <span class="text-sm font-bold opacity-80">Tampil ke publik</span>
                                    </div>
                                </label>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- 4. TOMBOL AKSI --}}
                <div class="pt-6 border-t-4 border-black flex items-center justify-end gap-4">
                    <a href="{{ route('dashboard') }}" class="px-6 py-3 font-bold text-gray-500 hover:text-black uppercase hover:underline">
                        Batal
                    </a>
                    <button type="submit" wire:loading.attr="disabled" class="bg-[#e97124] text-black text-xl font-black px-8 py-3 border-2 border-black shadow-[4px_4px_0px_0px_#000] hover:bg-black hover:text-white hover:shadow-[4px_4px_0px_0px_#e97124] hover:-translate-y-1 transition-all uppercase disabled:opacity-50 disabled:cursor-not-allowed">
                        <span wire:loading.remove wire:target="save">{{ $bookId ? 'SIMPAN PERUBAHAN' : 'TERBITKAN SEKARANG' }} ➔</span>
                        <span wire:loading wire:target="save">MENYIMPAN...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>