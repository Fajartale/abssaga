<div class="p-6">
    
    @if (session()->has('message'))
        <div class="bg-green-400 border-4 border-black p-4 mb-8 shadow-brutal flex items-center justify-between animate-bounce">
            <span class="font-bold text-xl uppercase">{{ session('message') }}</span>
            <span class="text-2xl cursor-pointer" wire:click="$set('message', null)">&times;</span>
        </div>
    @endif

    <div class="border-4 border-black p-6 md:p-8 bg-yellow-200 shadow-brutal mb-12 relative">
        <div class="absolute -top-4 -right-4 bg-black text-white px-4 py-2 font-black rotate-3 border-2 border-white">
            ADMIN PANEL
        </div>

        <h2 class="text-4xl font-black uppercase mb-6 border-b-4 border-black pb-2 inline-block">
            Buat Novel Baru
        </h2>

        <form wire:submit="save">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div>
                    <div class="mb-4">
                        <label class="block font-bold mb-2 border-l-4 border-black pl-2">JUDUL BUKU</label>
                        <input wire:model="title" type="text" class="w-full border-4 border-black p-3 font-bold focus:ring-0 focus:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] focus:translate-x-[-2px] focus:translate-y-[-2px] transition-all bg-white" placeholder="Contoh: Petualangan Si Kancil">
                        @error('title') <span class="text-red-600 font-bold bg-white px-1 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-2 border-l-4 border-black pl-2">SINOPSIS</label>
                        <textarea wire:model="synopsis" rows="5" class="w-full border-4 border-black p-3 font-medium focus:ring-0 focus:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] focus:translate-x-[-2px] focus:translate-y-[-2px] transition-all bg-white" placeholder="Ceritakan ringkasan novelmu di sini..."></textarea>
                        @error('synopsis') <span class="text-red-600 font-bold bg-white px-1 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block font-bold mb-2 border-l-4 border-black pl-2">COVER BUKU</label>
                    
                    <div class="border-4 border-black bg-white p-4 text-center border-dashed relative group">
                        @if ($cover)
                            <img src="{{ $cover->temporaryUrl() }}" class="h-64 mx-auto object-cover border-2 border-black shadow-sm">
                        @else
                            <div class="h-64 flex flex-col items-center justify-center text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="font-bold text-black">Klik untuk upload cover</span>
                            </div>
                        @endif
                        
                        <input wire:model="cover" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    </div>
                    
                    <div wire:loading wire:target="cover" class="mt-2 text-blue-600 font-bold animate-pulse">
                        Sedang mengupload gambar...
                    </div>
                    @error('cover') <span class="text-red-600 font-bold bg-white px-1 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-6 text-right">
                <button type="submit" class="inline-block bg-black text-white text-xl font-black py-4 px-10 hover:bg-white hover:text-black border-4 border-black transition-all shadow-brutal active:translate-y-1 active:shadow-none uppercase tracking-widest">
                    <span wire:loading.remove wire:target="save">Terbitkan Buku</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </button>
            </div>
        </form>
    </div>

    <h3 class="text-3xl font-black uppercase mb-6 border-l-8 border-yellow-400 pl-4">Koleksi Bukumu</h3>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        @forelse($books as $book)
            <div class="group border-4 border-black bg-white shadow-brutal hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all flex flex-col h-full">
                <div class="relative w-full aspect-[2/3] border-b-4 border-black bg-gray-100 overflow-hidden">
                    @if($book->cover_image)
                        <img src="{{ asset('storage/'.$book->cover_image) }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center font-black text-gray-300 text-4xl">NO COVER</div>
                    @endif
                    
                    <div class="absolute top-2 right-2 bg-yellow-300 border-2 border-black px-2 py-1 text-xs font-bold">
                        {{ $book->chapters->count() }} BAB
                    </div>
                </div>

                <div class="p-4 flex-1 flex flex-col justify-between">
                    <div>
                        <h4 class="font-black text-xl uppercase leading-tight mb-2 line-clamp-2">{{ $book->title }}</h4>
                        <p class="text-sm font-mono text-gray-500 mb-4 line-clamp-3">{{ $book->synopsis }}</p>
                    </div>
                    
                    <a href="{{ route('admin.chapters', $book->id) }}" class="w-full block text-center bg-blue-300 border-4 border-black py-2 font-bold uppercase hover:bg-black hover:text-white transition-colors">
                        Tulis Chapter &rarr;
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-10 border-4 border-dashed border-gray-400">
                <p class="text-xl font-bold text-gray-400">Belum ada buku yang diterbitkan.</p>
            </div>
        @endforelse
    </div>
</div>