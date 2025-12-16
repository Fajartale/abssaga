<div class="p-6">
    
    @if (session()->has('message'))
        <div class="bg-green-400 border-4 border-black p-4 mb-8 shadow-brutal flex justify-between items-center animate-bounce">
            <span class="font-black text-xl uppercase">{{ session('message') }}</span>
            <button wire:click="$set('message', null)" class="text-2xl font-bold">&times;</button>
        </div>
    @endif

    <div class="border-4 border-black p-6 md:p-8 bg-yellow-200 shadow-brutal mb-12 relative">
        <div class="absolute -top-4 -right-4 bg-black text-white px-4 py-2 font-black rotate-2 border-2 border-white">
            ADMIN ZONE
        </div>

        <h2 class="text-4xl font-black uppercase mb-6 border-b-4 border-black pb-2 inline-block">
            Terbitkan Novel Baru
        </h2>

        <form wire:submit="save">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <div class="space-y-4">
                    <div>
                        <label class="block font-bold mb-1 border-l-4 border-black pl-2">JUDUL BUKU</label>
                        <input wire:model="title" type="text" 
                               class="w-full border-4 border-black p-3 font-bold focus:ring-0 focus:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] focus:translate-x-[-2px] focus:translate-y-[-2px] transition-all bg-white" 
                               placeholder="Judul Novel...">
                        @error('title') <span class="text-red-600 font-bold bg-white px-1 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-bold mb-1 border-l-4 border-black pl-2">SINOPSIS</label>
                        <textarea wire:model="synopsis" rows="6" 
                                  class="w-full border-4 border-black p-3 font-medium focus:ring-0 focus:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] focus:translate-x-[-2px] focus:translate-y-[-2px] transition-all bg-white" 
                                  placeholder="Ringkasan cerita..."></textarea>
                        @error('synopsis') <span class="text-red-600 font-bold bg-white px-1 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block font-bold mb-1 border-l-4 border-black pl-2">COVER BUKU</label>
                    
                    <div class="relative w-full h-64 border-4 border-black border-dashed bg-white group hover:bg-gray-50 transition-colors flex flex-col items-center justify-center text-center overflow-hidden">
                        
                        @if ($cover)
                            <img src="{{ $cover->temporaryUrl() }}" class="absolute inset-0 w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity">
                            <div class="absolute bottom-0 bg-black text-white text-xs px-2 py-1 font-bold">Klik untuk ganti</div>
                        @else
                            <div class="text-gray-400 group-hover:text-black transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="font-bold uppercase">Upload Cover</span>
                            </div>
                        @endif

                        <input wire:model="cover" type="file" accept="image/*"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-50">
                    </div>

                    <div wire:loading wire:target="cover" class="mt-2 text-blue-600 font-black animate-pulse text-sm">
                        UPLOADING...
                    </div>
                    @error('cover') <span class="text-red-600 font-bold bg-white px-1 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" 
                        class="bg-black text-white text-xl font-black py-4 px-12 border-4 border-black shadow-brutal hover:bg-white hover:text-black hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all uppercase">
                    <span wire:loading.remove wire:target="save">Terbitkan Buku</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </button>
            </div>
        </form>
    </div>

    <h3 class="text-3xl font-black uppercase mb-6 pl-4 border-l-8 border-yellow-400">
        Koleksi Bukumu ({{ $books->count() }})
    </h3>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        @forelse($books as $book)
            <div class="flex flex-col h-full bg-white border-4 border-black shadow-brutal hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all group">
                <div class="relative w-full aspect-[2/3] border-b-4 border-black bg-gray-200 overflow-hidden">
                    @if($book->cover_image)
                        <img src="{{ asset('storage/'.$book->cover_image) }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center font-black text-gray-300 text-3xl">NO COVER</div>
                    @endif
                    
                    <button wire:click="deleteBook({{ $book->id }})" 
                            wire:confirm="Yakin ingin menghapus novel ini?"
                            class="absolute top-2 right-2 bg-red-500 text-white w-8 h-8 flex items-center justify-center font-bold border-2 border-black hover:bg-red-600 z-20"
                            title="Hapus Buku">
                        &times;
                    </button>
                </div>

                <div class="p-4 flex-1 flex flex-col justify-between">
                    <div class="mb-4">
                        <h4 class="font-black text-lg uppercase leading-tight line-clamp-2 mb-2">{{ $book->title }}</h4>
                        <p class="text-xs font-mono text-gray-500 line-clamp-3">{{ $book->synopsis }}</p>
                    </div>
                    
                    <a href="{{ route('admin.chapters', $book->id) }}" 
                       class="block w-full text-center bg-blue-300 border-4 border-black py-2 font-bold uppercase hover:bg-black hover:text-white transition-colors">
                        Tulis Chapter &rarr;
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center border-4 border-dashed border-gray-400">
                <p class="text-2xl font-bold text-gray-400">Belum ada buku.</p>
                <p class="text-gray-400">Mulailah menulis mahakaryamu hari ini!</p>
            </div>
        @endforelse
    </div>
</div>