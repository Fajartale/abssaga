<div class="p-6">
    <div class="flex justify-between items-center mb-6 border-b-4 border-black pb-4">
        <h1 class="text-2xl font-bold">Menulis: {{ $book->title }}</h1>
        <a href="{{ route('dashboard') }}" class="underline decoration-wavy">Kembali</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <div class="lg:col-span-1 border-4 border-black p-4 bg-gray-100 h-fit">
            <h3 class="font-bold border-b-2 border-black mb-2">Daftar Chapter</h3>
            <ul class="space-y-2">
                @foreach($chapters as $chap)
                    <li class="flex justify-between items-center bg-white border-2 border-black p-2 text-sm">
                        <span>{{ $chap->order }}. {{ $chap->title }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="lg:col-span-3">
            <form wire:submit="saveChapter">
                <div class="mb-4">
                    <input wire:model="title" type="text" placeholder="Judul Chapter..." class="w-full text-2xl font-bold border-0 border-b-4 border-black focus:ring-0 px-0 bg-transparent">
                    @error('title') <span class="text-red-600 font-bold bg-yellow-300 px-1">{{ $message }}</span> @enderror
                </div>
                
                <div class="mb-4" wire:ignore>
                    <trix-editor
                        class="trix-content min-h-[400px] bg-white text-lg border-2 border-black"
                        x-data
                        x-on:trix-change="$wire.content = $event.target.value"
                        x-on:trix-initialize="$event.target.value = $wire.content"
                        x-on:chapter-created.window="$el.value = ''" 
                    ></trix-editor>
                </div>
                @error('content') 
                    <div class="mb-4 text-red-600 font-bold bg-yellow-300 px-1 inline-block border-2 border-red-600">
                        Isi chapter tidak boleh kosong!
                    </div> 
                @enderror

                <button type="submit" class="mt-4 bg-green-400 border-2 border-black px-8 py-3 font-bold shadow-brutal hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all">
                    SIMPAN CHAPTER
                </button>
            </form>
        </div>
    </div>
</div>