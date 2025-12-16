<div class="p-6">
    <div class="border-4 border-black p-6 bg-yellow-200 shadow-brutal mb-10">
        <h2 class="text-3xl font-bold uppercase mb-4 border-b-4 border-black">Buat Novel Baru</h2>
        <form wire:submit.prevent="save">
            <div class="mb-4">
                <label class="block font-bold mb-1">Judul Buku</label>
                <input wire:model="title" type="text" class="w-full border-2 border-black p-2 focus:ring-0 focus:shadow-brutal transition-all">
            </div>
            <div class="mb-4">
                <label class="block font-bold mb-1">Sinopsis</label>
                <textarea wire:model="synopsis" class="w-full border-2 border-black p-2 h-32 focus:ring-0 focus:shadow-brutal"></textarea>
            </div>
            <div class="mb-4">
                <label class="block font-bold mb-1">Cover</label>
                <input wire:model="cover" type="file" class="border-2 border-black p-2 bg-white w-full">
            </div>
            <button type="submit" class="bg-black text-white font-bold py-3 px-6 hover:bg-white hover:text-black border-2 border-black transition-all shadow-brutal active:translate-y-1 active:shadow-none">
                TERBITKAN BUKU
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($books as $book)
            <div class="border-4 border-black bg-white p-4 shadow-brutal">
                @if($book->cover_image)
                    <img src="{{ asset('storage/'.$book->cover_image) }}" class="w-full h-48 object-cover border-2 border-black mb-4 grayscale hover:grayscale-0 transition-all">
                @endif
                <h3 class="font-bold text-xl mb-2">{{ $book->title }}</h3>
                <a href="{{ route('admin.chapters', $book->id) }}" class="block text-center bg-blue-300 border-2 border-black font-bold py-2 hover:bg-blue-400">
                    TULIS CHAPTER
                </a>
            </div>
        @endforeach
    </div>
</div>