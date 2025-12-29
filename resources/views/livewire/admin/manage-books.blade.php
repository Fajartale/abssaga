<div class="min-h-screen bg-white font-mono text-black">
    
    {{-- HEADER --}}
    <div class="bg-[#1c0213] border-b-4 border-black sticky top-0 z-50 shadow-2xl">
        <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}" class="bg-white text-black px-3 py-1 font-bold border-2 border-black hover:bg-[#e97124] transition-colors shadow-[2px_2px_0px_0px_#e97124]">
                    ⬅ KEMBALI
                </a>
                <h1 class="text-white font-black text-xl uppercase tracking-wider">
                    {{ $bookId ? 'EDIT NOVEL' : 'NOVEL BARU' }}
                </h1>
            </div>
            
            {{-- Logo Kecil --}}
            <img src="{{ asset('images/abcsaga-logo.png') }}" alt="Logo" class="h-10 w-auto object-contain opacity-50">
        </div>
    </div>

    {{-- MAIN FORM --}}
    <div class="max-w-4xl mx-auto p-6 mt-8">
        
        <div class="bg-white border-4 border-black p-6 md:p-10 shadow-[8px_8px_0px_0px_#e97124] relative">
            
            {{-- Form Title --}}
            <div class="mb-8 border-b-4 border-black pb-4">
                <h2 class="text-3xl font-black uppercase">
                    {{ $bookId ? 'PERBARUI KARYA' : 'MULAI TULISAN BARU' }}
                </h2>
                <p class="text-gray-500 font-bold mt-1">
                    Isi detail buku Anda dengan menarik agar pembaca penasaran.
                </p>
            </div>

            <form wire:submit.prevent="save" class="space-y-8">
                
                {{-- 1. JUDUL --}}
                <div class="group">
                    <label class="block font-black text-lg uppercase mb-2 bg-black text-white w-fit px-2 transform -rotate-1">
                        JUDUL BUKU
                    </label>
                    <input type="text" wire:model="title" placeholder="CONTOH: PENDEKAR TANPA BAYANGAN..." 
                        class="w-full border-4 border-black p-4 text-lg font-bold bg-gray-50 focus:bg-white focus:ring-0 focus:outline-none focus:shadow-[4px_4px_0px_0px_#e97124] transition-all placeholder-gray-400">
                    @error('title') <span class="text-red-600 font-black text-sm mt-1 block">⚠ {{ $message }}</span> @enderror
                </div>

                {{-- 2. SINOPSIS --}}
                <div class="group">
                    <label class="block font-black text-lg uppercase mb-2 bg-black text-white w-fit px-2 transform rotate-1">
                        SINOPSIS
                    </label>
                    <textarea wire:model="synopsis" rows="6" placeholder="Ceritakan ringkasan cerita yang membuat pembaca tidak bisa tidur..." 
                        class="w-full border-4 border-black p-4 text-lg font-bold bg-gray-50 focus:bg-white focus:ring-0 focus:outline-none focus:shadow-[4px_4px_0px_0px_#e97124] transition-all placeholder-gray-400"></textarea>
                    @error('synopsis') <span class="text-red-600 font-black text-sm mt-1 block">⚠ {{ $message }}</span> @enderror
                </div>

                {{-- 3. GRID: COVER & STATUS --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    {{-- Upload Cover --}}
                    <div>
                        <label class="block font-black text-lg uppercase mb-2 bg-black text-white w-fit px-2">
                            COVER (OPSIONAL)
                        </label>
                        
                        <div class="border-4 border-black border-dashed bg-gray-100 p-4 text-center relative hover:bg-orange-50 transition-colors cursor-pointer">
                            <input type="file" wire:model="cover" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            
                            @if ($cover)
                                {{-- Preview Upload Baru --}}
                                <img src="{{ $cover->temporaryUrl() }}" class="h-48 mx-auto border-2 border-black shadow-sm object-cover">
                                <p class="font-bold text-xs mt-2 text-[#e97124]">Preview Gambar Baru</p>
                            @elseif ($old_cover)
                                {{-- Preview Cover Lama --}}
                                <img src="{{ $old_cover }}" class="h-48 mx-auto border-2 border-black shadow-sm object-cover">
                                <p class="font-bold text-xs mt-2 text-gray-500">Cover Saat Ini</p>
                            @else
                                {{-- Placeholder --}}
                                <div class="h-48 flex flex-col items-center justify-center text-gray-400">
                                    <span class="text-4xl">🖼️</span>
                                    <span class="font-bold text-sm mt-2">KLIK UNTUK UPLOAD</span>
                                    <span class="text-xs">(JPG/PNG, Max 2MB)</span>
                                </div>
                            @endif
                        </div>
                        @error('cover') <span class="text-red-600 font-black text-sm mt-1 block">⚠ {{ $message }}</span> @enderror
                    </div>

                    {{-- Status Publish --}}
                    <div class="flex flex-col justify-start">
                        <label class="block font-black text-lg uppercase mb-2 bg-black text-white w-fit px-2">
                            STATUS PUBLIKASI
                        </label>
                        
                        <div class="flex items-center gap-4 mt-2">
                            <label class="cursor-pointer flex items-center gap-3 p-3 border-2 border-black w-full hover:bg-gray-50 {{ $is_published == 0 ? 'bg-gray-200' : '' }}">
                                <input type="radio" wire:model="is_published" value="0" class="w-6 h-6 text-black focus:ring-0 border-2 border-black">
                                <div>
                                    <span class="block font-black text-lg">DRAFT</span>
                                    <span class="text-xs font-bold text-gray-500">Hanya saya yang lihat</span>
                                </div>
                            </label>

                            <label class="cursor-pointer flex items-center gap-3 p-3 border-2 border-black w-full hover:bg-orange-50 {{ $is_published == 1 ? 'bg-[#e97124]/20' : '' }}">
                                <input type="radio" wire:model="is_published" value="1" class="w-6 h-6 text-[#e97124] focus:ring-0 border-2 border-black">
                                <div>
                                    <span class="block font-black text-lg text-[#e97124]">PUBLISH</span>
                                    <span class="text-xs font-bold text-gray-500">Tampil ke publik</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- 4. ACTION BUTTONS --}}
                <div class="pt-6 border-t-4 border-black flex items-center justify-end gap-4">
                    <a href="{{ route('dashboard') }}" class="px-6 py-3 font-bold text-gray-500 hover:text-black uppercase">
                        Batal
                    </a>
                    <button type="submit" class="bg-[#e97124] text-black text-xl font-black px-8 py-3 border-2 border-black shadow-[4px_4px_0px_0px_#000] hover:bg-black hover:text-white hover:shadow-[4px_4px_0px_0px_#e97124] hover:-translate-y-1 transition-all uppercase">
                        {{ $bookId ? 'SIMPAN PERUBAHAN' : 'TERBITKAN SEKARANG' }} ➔
                    </button>
                </div>
            </form>

            {{-- Loading Indicator --}}
            <div wire:loading wire:target="save, cover" class="absolute inset-0 bg-white/80 flex items-center justify-center z-50 backdrop-blur-sm">
                <div class="text-center">
                    <div class="animate-spin text-5xl mb-2">⏳</div>
                    <span class="font-black text-xl uppercase bg-black text-white px-2">MEMPROSES...</span>
                </div>
            </div>

        </div>
    </div>
</div>