<div class="p-6">
    
    @if (session()->has('message'))
        <div class="bg-green-400 border-4 border-black p-4 mb-8 shadow-brutal animate-bounce text-center">
            <span class="font-black text-xl uppercase">{{ session('message') }}</span>
        </div>
    @endif

    <div class="border-4 border-black p-6 bg-yellow-200 shadow-brutal mb-10">
        <h2 class="text-3xl font-black uppercase mb-6 border-b-4 border-black inline-block">
            Terbitkan Novel Baru
        </h2>

        <form wire:submit="save">
            <div class="mb-4">
                <label class="block font-bold mb-1 border-l-4 border-black pl-2">JUDUL BUKU</label>
                <input wire:model="title" type="text" class="w-full border-4 border-black p-2 font-bold focus:ring-0 focus:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transition-all">
                
                @error('title') 
                    <span class="block mt-1 bg-red-600 text-white font-bold px-2 py-1 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-bold mb-1 border-l-4 border-black pl-2">SINOPSIS</label>
                <textarea wire:model="synopsis" rows="4" class="w-full border-4 border-black p-2 font-medium focus:ring-0 focus:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transition-all"></textarea>
                
                @error('synopsis') 
                    <span class="block mt-1 bg-red-600 text-white font-bold px-2 py-1 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            <div class="mb-6">
                <label class="block font-bold mb-1 border-l-4 border-black pl-2">COVER (Opsional, Max 2MB)</label>
                
                <div class="border-4 border-black bg-white p-2">
                    @if ($cover)
                        <div class="mb-2 text-center bg-gray-100 p-2">
                            <span class="text-xs font-bold block mb-1">Preview:</span>
                            <img src="{{ $cover->temporaryUrl() }}" class="h-40 mx-auto border-2 border-black object-cover">
                        </div>
                    @endif
                    
                    <input wire:model="cover" type="file" accept="image/*" class="w-full cursor-pointer font-bold">
                </div>

                <div wire:loading wire:target="cover" class="text-blue-600 font-bold text-sm mt-1 animate-pulse">
                    Sedang mengupload gambar...
                </div>

                @error('cover') 
                    <span class="block mt-1 bg-red-600 text-white font-bold px-2 py-1 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            <button type="submit" class="w-full md:w-auto bg-black text-white font-black py-3 px-8 border-4 border-black hover:bg-white hover:text-black hover:shadow-none shadow-brutal transition-all uppercase tracking-widest">
                <span wire:loading.remove wire:target="save">Simpan & Terbitkan</span>
                <span wire:loading wire:target="save">Memproses...</span>
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($books as $book)
            <div class="border-4 border-black bg-white shadow-brutal p-4 flex flex-col justify-between">
                <div>
                    @if($book->cover_image)
                        <img src="{{ asset('storage/'.$book->cover_image) }}" class="w-full h-48 object-cover border-4 border-black mb-4 grayscale hover:grayscale-0 transition-all">
                    @else
                        <div class="w-full h-48 border-4 border-black mb-4 flex items-center justify-center bg-gray-200 text-gray-400 font-bold">NO COVER</div>
                    @endif
                    <h3 class="font-black text-lg uppercase leading-tight mb-2">{{ $book->title }}</h3>
                    <p class="text-xs text-gray-600 font-mono line-clamp-3 mb-4">{{ $book->synopsis }}</p>
                </div>
                <a href="{{ route('admin.chapters', $book->id) }}" class="block text-center bg-blue-300 border-4 border-black py-2 font-bold uppercase hover:bg-black hover:text-white transition-colors">
                    Kelola Chapter &rarr;
                </a>
            </div>
        @empty
            <div class="col-span-full text-center py-10 border-4 border-dashed border-gray-400">
                <p class="text-xl font-bold text-gray-500">Belum ada buku di database.</p>
            </div>
        @endforelse
    </div>
</div>