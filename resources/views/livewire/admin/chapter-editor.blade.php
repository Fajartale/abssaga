<div class="min-h-screen bg-white font-mono text-black">
    
    {{-- CUSTOM STYLES & TRIX EDITOR ASSETS --}}
    <head>
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
        <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
        <style>
            /* Custom Scrollbar */
            ::-webkit-scrollbar { width: 10px; }
            ::-webkit-scrollbar-track { background: #f1f1f1; border-left: 2px solid black; }
            ::-webkit-scrollbar-thumb { background: #000; border: 2px solid black; }
            ::-webkit-scrollbar-thumb:hover { background: #333; }
            
            /* Trix Editor Customization */
            trix-editor {
                border: 4px solid black !important;
                min-height: 400px;
                background-color: #fafafa;
                padding: 1rem;
                font-size: 1.125rem; /* text-lg */
            }
            trix-editor:focus {
                outline: none;
                box-shadow: 6px 6px 0px 0px #e97124;
                background-color: white;
            }
            trix-toolbar .trix-button--icon { color: black; }
            trix-toolbar .trix-button.trix-active { background: #e97124; color: black; }
        </style>
    </head>

    {{-- HEADER HALAMAN --}}
    <div class="bg-[#1c0213] border-b-4 border-black sticky top-0 z-50 shadow-2xl">
        <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between">
            <div class="flex items-center gap-4">
                {{-- Tombol Kembali ke Edit Novel --}}
                <a href="{{ route('book.manage', $book->id) }}" class="bg-white text-black px-4 py-1 font-black border-2 border-black hover:bg-[#e97124] hover:text-black transition-all shadow-[4px_4px_0px_0px_#e97124] hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] uppercase text-sm">
                    ⬅ Detail Novel
                </a>
                <div class="hidden md:block">
                    <h1 class="text-white font-black text-xl uppercase tracking-wider">
                        EDITOR NASKAH
                    </h1>
                    <p class="text-[#e97124] text-xs font-bold uppercase tracking-widest">
                        NOVEL: {{ Str::limit($book->title, 40) }}
                    </p>
                </div>
            </div>
            
            <img src="{{ asset('images/abcsaga-logo.png') }}" alt="Logo" class="h-10 w-auto object-contain opacity-50 grayscale hover:grayscale-0 transition-all">
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="max-w-7xl mx-auto p-4 md:p-6 mt-4 md:mt-8 mb-20">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">
            
            {{-- SIDEBAR: DAFTAR CHAPTER --}}
            <div class="lg:col-span-1 bg-gray-100 border-4 border-black p-4 shadow-[6px_6px_0px_0px_#000] sticky top-24 max-h-[80vh] overflow-y-auto flex flex-col">
                <div class="border-b-4 border-black pb-4 mb-4">
                    <h3 class="font-black text-xl uppercase">DAFTAR ISI</h3>
                    <p class="text-xs font-bold text-gray-500 mt-1">Total: {{ $chapters->count() }} Bab</p>
                </div>

                <ul class="space-y-3 flex-grow">
                    @forelse($chapters as $chap)
                        <li class="group flex flex-col p-3 border-2 border-black transition-all relative {{ $editingId == $chap->id ? 'bg-[#e97124] text-black shadow-[2px_2px_0px_0px_#000]' : 'bg-white hover:bg-orange-50 hover:shadow-[4px_4px_0px_0px_#ccc] hover:-translate-y-1' }}">
                            
                            {{-- Info Chapter --}}
                            <div class="flex justify-between items-start font-bold mb-3">
                                <span class="bg-black text-white text-xs px-2 py-0.5 transform -rotate-2 h-fit">#{{ $chap->order }}</span>
                                <span class="text-sm text-right leading-tight w-2/3">{{ $chap->title }}</span>
                            </div>
                            
                            {{-- Tombol Aksi (Edit & Move) --}}
                            <div class="flex justify-between items-center pt-2 border-t-2 border-black border-dashed opacity-100 lg:opacity-60 lg:group-hover:opacity-100 transition-opacity">
                                <div class="flex gap-1">
                                    {{-- Tombol Naik --}}
                                    @if(!$loop->first)
                                    <button wire:click="move({{ $chap->id }}, 'up')" class="w-6 h-6 flex items-center justify-center border border-black bg-white hover:bg-black hover:text-white transition-colors text-xs" title="Naikkan Urutan">
                                        ▲
                                    </button>
                                    @endif
                                    
                                    {{-- Tombol Turun --}}
                                    @if(!$loop->last)
                                    <button wire:click="move({{ $chap->id }}, 'down')" class="w-6 h-6 flex items-center justify-center border border-black bg-white hover:bg-black hover:text-white transition-colors text-xs" title="Turunkan Urutan">
                                        ▼
                                    </button>
                                    @endif
                                </div>

                                <button wire:click="edit({{ $chap->id }})" class="text-xs font-black uppercase bg-yellow-300 px-2 py-1 border border-black hover:bg-black hover:text-yellow-300 transition-colors">
                                    EDIT ✏️
                                </button>
                            </div>
                        </li>
                    @empty
                        <li class="text-center p-4 border-2 border-dashed border-gray-400 text-gray-400 font-bold text-sm">
                            Belum ada chapter.
                        </li>
                    @endforelse
                </ul>
                
                {{-- Tombol Tambah Baru (Jika sedang Edit) --}}
                @if($isEditing)
                    <div class="mt-4 pt-4 border-t-4 border-black">
                        <button wire:click="cancel" class="w-full bg-green-400 text-black font-black border-2 border-black py-2 hover:bg-green-500 shadow-[2px_2px_0px_0px_#000] active:translate-y-[2px] active:shadow-none uppercase text-sm">
                            + Tulis Bab Baru
                        </button>
                    </div>
                @endif
            </div>

            {{-- MAIN: FORM EDITOR --}}
            <div class="lg:col-span-3">
                <div class="bg-white border-4 border-black p-6 shadow-[8px_8px_0px_0px_#e97124]">
                    
                    {{-- Status Header --}}
                    <div class="flex justify-between items-end mb-6 border-b-4 border-black pb-2">
                        <h2 class="text-3xl font-black uppercase transform -skew-x-12 bg-black text-white px-4 py-1 w-fit">
                            {{ $isEditing ? 'EDIT BAB INI' : 'TULIS BAB BARU' }}
                        </h2>
                        
                        @if($isEditing)
                            <button wire:click="cancel" class="text-red-600 font-bold underline hover:bg-red-100 px-2">
                                BATAL EDIT
                            </button>
                        @endif
                    </div>

                    <form wire:submit.prevent="{{ $isEditing ? 'update' : 'saveChapter' }}">
                        
                        {{-- 1. INPUT JUDUL CHAPTER --}}
                        <div class="mb-6">
                            <input wire:model="title" type="text" placeholder="JUDUL BAB (MISAL: AWAL MULA)..." 
                                class="w-full text-2xl font-black border-0 border-b-4 border-black focus:border-[#e97124] focus:ring-0 px-0 py-2 bg-transparent placeholder-gray-300 transition-colors uppercase">
                            @error('title') 
                                <div class="mt-1 bg-red-500 text-white font-bold px-2 py-1 border-2 border-black w-fit text-xs">
                                    ⚠ {{ $message }}
                                </div> 
                            @enderror
                        </div>
                        
                        {{-- 2. TRIX EDITOR (ISI CERITA) --}}
                        <div class="mb-6" wire:ignore>
                            <input id="x" type="hidden" name="content">
                            <trix-editor
                                class="trix-content"
                                x-data
                                x-on:trix-change="$wire.content = $event.target.value"
                                x-on:trix-initialize="$event.target.value = $wire.content"
                                x-on:trix-clear.window="$el.value = ''" 
                                x-on:trix-load-content.window="$el.editor.loadHTML($event.detail.content)"
                                input="x"
                                placeholder="Mulailah menulis kisah epik Anda di sini..."
                            ></trix-editor>
                        </div>
                        @error('content') 
                            <div class="mb-6 bg-red-500 text-white font-bold px-3 py-2 border-2 border-black w-full text-center shadow-[4px_4px_0px_0px_#000]">
                                ⚠ Isi chapter tidak boleh kosong!
                            </div> 
                        @enderror

                        {{-- 3. TOMBOL SIMPAN --}}
                        <div class="flex justify-end gap-4 border-t-4 border-black border-dashed pt-6">
                            <button type="submit" class="bg-[#e97124] text-black text-xl font-black px-8 py-4 border-4 border-black shadow-[6px_6px_0px_0px_#000] hover:bg-black hover:text-white hover:shadow-[6px_6px_0px_0px_#e97124] hover:-translate-y-1 transition-all uppercase flex items-center gap-2">
                                <span>{{ $isEditing ? 'SIMPAN PERUBAHAN' : 'TERBITKAN BAB INI' }}</span>
                                <span class="text-2xl">💾</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>