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
    <div class="max-w-4xl mx-auto p-6 mt-8">
        
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
                </div>

                {{-- 3. GRID COVER & STATUS --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    {{-- UPLOAD COVER --}}
                    <div>
                        <label class="block font-black text-lg uppercase mb-2 bg-black text-white w-fit px-2">
                            COVER (OPSIONAL)
                        </label>
                        
                        <div class="border-4 border-black border-dashed bg-gray-100 p-4 text-center relative hover:bg-orange-50 transition-colors cursor-pointer group">
                            {{-- Input File Invisible --}}
                            <input type="file" wire:model="cover" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            
                            @if ($cover)
                                {{-- Preview Gambar Baru yang belum disimpan --}}
                                <img src="{{ $cover->temporaryUrl() }}" class="h-48 mx-auto border-2 border-black shadow-sm object-cover">
                                <p class="font-bold text-xs mt-2 text-[#e97124] uppercase">Preview Gambar Baru</p>
                            @elseif ($old_cover)
                                {{-- Tampilkan Cover Lama jika Edit --}}
                                <img src="{{ $old_cover }}" class="h-48 mx-auto border-2 border-black shadow-sm object-cover">
                                <p class="font-bold text-xs mt-2 text-gray-500 uppercase">Cover Saat Ini</p>
                            @else
                                {{-- Placeholder Kosong --}}
                                <div class="h-48 flex flex-col items-center justify-center text-gray-400 group-hover:text-[#e97124] transition-colors">
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

                    {{-- PILIH STATUS --}}
                    <div class="flex flex-col justify-start">
                        <label class="block font-black text-lg uppercase mb-2 bg-black text-white w-fit px-2">
                            STATUS PUBLIKASI
                        </label>
                        
                        <div class="flex flex-col gap-3 mt-2">
                            {{-- Pilihan DRAFT --}}
                            <label class="cursor-pointer flex items-center gap-3 p-3 border-2 border-black w-full hover:bg-gray-100 transition-colors relative">
                                <input type="radio" wire:model="is_published" value="0" class="peer sr-only">
                                <div class="w-5 h-5 border-2 border-black peer-checked:bg-black peer-checked:shadow-[inset_0_0_0_2px_white] transition-all"></div>
                                <div>
                                    <span class="block font-black text-lg">DRAFT</span>
                                    <span class="text-xs font-bold text-gray-500">Hanya saya yang lihat</span>
                                </div>
                                {{-- Indikator Aktif --}}
                                <div class="absolute inset-0 border-2 border-transparent peer-checked:border-gray-500 pointer-events-none opacity-20"></div>
                            </label>

                            {{-- Pilihan PUBLISH --}}
                            <label class="cursor-pointer flex items-center gap-3 p-3 border-2 border-black w-full hover:bg-orange-50 transition-colors relative">
                                <input type="radio" wire:model="is_published" value="1" class="peer sr-only">
                                <div class="w-5 h-5 border-2 border-black peer-checked:bg-[#e97124] peer-checked:shadow-[inset_0_0_0_2px_white] transition-all"></div>
                                <div>
                                    <span class="block font-black text-lg text-[#e97124]">PUBLISH</span>
                                    <span class="text-xs font-bold text-gray-500">Tampil ke publik</span>
                                </div>
                                {{-- Indikator Aktif --}}
                                <div class="absolute inset-0 border-2 border-transparent peer-checked:border-[#e97124] pointer-events-none"></div>
                            </label>
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