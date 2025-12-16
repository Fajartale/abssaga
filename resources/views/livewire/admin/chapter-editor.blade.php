<div class="p-6">
    <div class="flex justify-between items-center mb-6 border-b-4 border-black pb-4">
        <h1 class="text-2xl font-bold">
            {{ $isEditing ? 'Mengedit Chapter' : 'Menulis: ' . $book->title }}
        </h1>
        <a href="{{ route('dashboard') }}" class="underline decoration-wavy">Kembali</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        
        <div class="lg:col-span-1 border-4 border-black p-4 bg-gray-100 h-fit">
            <h3 class="font-bold border-b-2 border-black mb-4 pb-2">Daftar Chapter</h3>
            <ul class="space-y-3">
                @foreach($chapters as $chap)
                    <li class="flex flex-col bg-white border-2 border-black p-2 text-sm shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transition-all hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none {{ $editingId == $chap->id ? 'bg-yellow-200' : '' }}">
                        <div class="flex justify-between items-center font-bold mb-2">
                            <span>#{{ $chap->order }}</span>
                            <span class="truncate w-24 text-right">{{ Str::limit($chap->title, 15) }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center border-t-2 border-gray-200 pt-2 gap-1">
                            <div class="flex gap-1">
                                @if(!$loop->first)
                                <button wire:click="move({{ $chap->id }}, 'up')" class="bg-blue-200 px-2 py-1 border border-black hover:bg-blue-400 text-xs">
                                    ⬆️
                                </button>
                                @endif
                                @if(!$loop->last)
                                <button wire:click="move({{ $chap->id }}, 'down')" class="bg-blue-200 px-2 py-1 border border-black hover:bg-blue-400 text-xs">
                                    ⬇️
                                </button>
                                @endif
                            </div>

                            <button wire:click="edit({{ $chap->id }})" class="bg-yellow-300 px-2 py-1 border border-black hover:bg-yellow-500 text-xs font-bold">
                                EDIT ✏️
                            </button>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="lg:col-span-3">
            <form wire:submit="{{ $isEditing ? 'update' : 'saveChapter' }}">
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
                        x-on:trix-clear.window="$el.value = ''" 
                        x-on:trix-load-content.window="$el.editor.loadHTML($event.detail.content)"
                    ></trix-editor>
                </div>
                @error('content') 
                    <div class="mb-4 text-red-600 font-bold bg-yellow-300 px-1 inline-block border-2 border-red-600">
                        Isi chapter tidak boleh kosong!
                    </div> 
                @enderror

                <div class="flex gap-4">
                    @if($isEditing)
                        <button type="button" wire:click="cancel" class="bg-gray-300 border-2 border-black px-6 py-3 font-bold hover:bg-gray-400">
                            BATAL
                        </button>
                        <button type="submit" class="bg-yellow-400 border-2 border-black px-8 py-3 font-bold shadow-brutal hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all">
                            UPDATE CHAPTER
                        </button>
                    @else
                        <button type="submit" class="bg-green-400 border-2 border-black px-8 py-3 font-bold shadow-brutal hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all">
                            SIMPAN CHAPTER
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>