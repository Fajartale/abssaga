<div class="p-6">
    
    {{-- Flash Message --}}
    @if (session()->has('message'))
        <div class="bg-green-400 border-4 border-black p-4 mb-8 shadow-brutal animate-bounce text-center">
            <span class="font-black text-xl uppercase">{{ session('message') }}</span>
        </div>
    @endif

    {{-- Form Section --}}
    <div class="border-4 border-black p-6 bg-yellow-200 shadow-brutal mb-10">
        <h2 class="text-3xl font-black uppercase mb-6 border-b-4 border-black inline-block">
            Terbitkan Novel Baru
        </h2>

        <form wire:submit="save">
            {{-- Judul --}}
            <div class="mb-4">
                <label class="block font-bold mb-1 border-l-4 border-black pl-2">JUDUL BUKU</label>
                <input wire:model="title" type="text" class="w-full border-4 border-black p-2 font-bold focus:ring-0 focus:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transition-all" placeholder="Masukkan judul menarik...">
                @error('title') <span class="text-red-600 font-bold text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Sinopsis --}}
            <div class="mb-4">
                <label class="block font-bold mb-1 border-l-4 border-black pl-2">SINOPSIS</label>
                <textarea wire:model="synopsis" rows="4" class="w-full border-4 border-black p-2 font-medium focus:ring-0 focus:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transition-all" placeholder="Ceritakan sedikit tentang bukumu..."></textarea>
                @error('synopsis') <span class="text-red-600 font-bold text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Upload Cover --}}
            <div class="mb-6">
                <label class="block font-bold mb-1 border-l-4 border-black pl-2">COVER (Opsional, Max 10MB)</label>
                
                <div class="border-4 border-black bg-white p-2">
                    {{-- Preview Gambar Sementara --}}
                    @if ($cover)
                        <div class="mb-2 text-center bg-gray-100 p-2 border-2 border-dashed border-gray-300">
                            <span class="text-xs font-bold block mb-1 text-gray-500">Preview Cover Baru:</span>
                            <img src="{{ $cover->temporaryUrl() }}" class="h-40 mx-auto border-2 border-black object-cover">
                        </div>
                    @endif
                    
                    <input wire:model="cover" type="file" accept="image/*" class="w-full cursor-pointer font-bold file:mr-4 file:py-2 file:px-4 file:border-2 file:border-black file:text-sm file:font-bold file:bg-gray-100 hover:file:bg-gray-200">
                </div>

                {{-- Indikator Loading saat Upload --}}
                <div wire:loading wire:target="cover" class="text-blue-700 font-bold text-sm mt-2 flex items-center animate-pulse">
                    <svg class="animate-spin h-5 w-5 mr-2" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Sedang mengupload gambar... Tunggu sebentar.
                </div>

                @error('cover') <span class="block mt-1 bg-red-600 text-white font-bold px-2 py-1 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Tombol Simpan --}}
            <button type="submit" 
                    wire:loading.attr="disabled" 
                    class="w-full md:w-auto bg-black text-white font-black py-3 px-8 border-4 border-black hover:bg-white hover:text-black hover:shadow-none shadow-brutal transition-all uppercase tracking-widest disabled:opacity-50 disabled:cursor-not-allowed">
                
                {{-- Text Normal --}}
                <span wire:loading.remove wire:target="save, cover">SIMPAN & TERBITKAN</span>
                
                {{-- Text saat Loading Simpan --}}
                <span wire:loading wire:target="save">MEMPROSES...</span>
                
                {{-- Text saat Loading Upload --}}
                <span wire:loading wire:target="cover">MENUNGGU UPLOAD...</span>
            </button>
        </form>
    </div>

    {{-- Daftar Buku --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($books as $book)
            <div class="border-4 border-black bg-white shadow-brutal p-4 flex flex-col justify-between relative group">
                
                {{-- Tombol Hapus (Opsional) --}}
                <button wire:click="delete({{ $book->id }})" 
                        wire:confirm="Yakin ingin menghapus buku ini?"
                        class="absolute top-2 right-2 bg-red-500 text-white p-1 border-2 border-black hover:bg-red-600 opacity-0 group-hover:opacity-100 transition-opacity">
                    HAPUS
                </button>

                <div>
                    @if($book->cover_image)
                        {{-- Gunakan asset storage yang benar --}}
                        <img src="{{ asset('storage/'.$book->cover_image) }}" class="w-full h-48 object-cover border-4 border-black mb-4 grayscale hover:grayscale-0 transition-all">
                    @else
                        <div class="w-full h-48 border-4 border-black mb-4 flex items-center justify-center bg-gray-200 text-gray-400 font-bold">
                            NO COVER
                        </div>
                    @endif
                    <h3 class="font-black text-lg uppercase leading-tight mb-2">{{ $book->title }}</h3>
                    <p class="text-xs text-gray-600 font-mono line-clamp-3 mb-4">{{ $book->synopsis }}</p>
                </div>
                
                <a href="{{ route('admin.chapters', $book->id) }}" class="block text-center bg-blue-300 border-4 border-black py-2 font-bold uppercase hover:bg-black hover:text-white transition-colors">
                    Kelola Chapter &rarr;
                </a>
            </div>
        @empty
            <div class="col-span-full text-center py-10 border-4 border-dashed border-gray-400 bg-gray-50">
                <p class="text-xl font-bold text-gray-500">Belum ada buku yang diterbitkan.</p>
            </div>
        @endforelse
    </div>
</div>