<div class="p-6">
    
    @if (session()->has('message'))
        <div class="bg-green-400 border-4 border-black p-4 mb-8 shadow-brutal animate-bounce">
            <span class="font-bold text-xl uppercase">{{ session('message') }}</span>
        </div>
    @endif

    <div class="border-4 border-black p-6 bg-yellow-200 shadow-brutal mb-10 relative">
        <h2 class="text-3xl font-bold uppercase mb-4 border-b-4 border-black inline-block">Buat Novel Baru</h2>
        
        <form wire:submit="save">
            <div class="mb-4">
                <label class="block font-bold mb-1">Judul Buku</label>
                <input wire:model="title" type="text" class="w-full border-4 border-black p-2 focus:ring-0 focus:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transition-all bg-white">
                @error('title') <span class="text-red-600 font-bold bg-white px-1 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block font-bold mb-1">Sinopsis</label>
                <textarea wire:model="synopsis" rows="4" class="w-full border-4 border-black p-2 focus:ring-0 focus:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transition-all bg-white"></textarea>
                @error('synopsis') <span class="text-red-600 font-bold bg-white px-1 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block font-bold mb-1">Cover (Opsional)</label>
                
                @if ($cover)
                    <div class="mb-2">
                        <span class="text-sm font-bold">Preview:</span>
                        <img src="{{ $cover->temporaryUrl() }}" class="h-32 border-2 border-black">
                    </div>
                @endif
                
                <input wire:model="cover" type="file" class="border-4 border-black p-2 bg-white w-full cursor-pointer">
                <div wire:loading wire:target="cover" class="text-blue-600 font-bold text-sm mt-1">Sedang mengupload...</div>
                @error('cover') <span class="text-red-600 font-bold bg-white px-1 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="bg-black text-white font-bold py-3 px-8 border-4 border-black hover:bg-white hover:text-black transition-all shadow-brutal active:translate-y-1 active:shadow-none uppercase tracking-wider">
                <span wire:loading.remove wire:target="save">Terbitkan Buku</span>
                <span wire:loading wire:target="save">Menyimpan...</span>
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($books as $book)
            <div class="border-4 border-black bg-white p-4 shadow-brutal flex flex-col justify-between">
                <div>
                    @if($book->cover_image)
                        <img src="{{ asset('storage/'.$book->cover_image) }}" class="w-full h-64 object-cover border-4 border-black mb-4 grayscale hover:grayscale-0 transition-all">
                    @else
                        <div class="w-full h-64 border-4 border-black mb-4 flex items-center justify-center bg-gray-100 text-gray-400 font-bold text-2xl">NO COVER</div>
                    @endif
                    <h3 class="font-bold text-xl mb-2 uppercase leading-tight">{{ $book->title }}</h3>
                </div>
                
                <a href="{{ route('admin.chapters', $book->id) }}" class="block text-center bg-blue-300 border-4 border-black font-bold py-2 hover:bg-black hover:text-white transition-colors mt-4">
                    TULIS CHAPTER &rarr;
                </a>
            </div>
        @endforeach
    </div>
</div>