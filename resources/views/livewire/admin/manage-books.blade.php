<div class="min-h-screen bg-gray-100 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            {{ $bookId ? 'Edit Novel' : 'Buat Novel Baru' }}
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            <a href="{{ route('dashboard') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                &larr; Kembali ke Dashboard
            </a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            
            <form wire:submit.prevent="save" class="space-y-6">
                
                {{-- INPUT JUDUL --}}
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Judul Novel</label>
                    <div class="mt-1">
                        <input wire:model="title" id="title" type="text" required 
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    @error('title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- INPUT SINOPSIS --}}
                <div>
                    <label for="synopsis" class="block text-sm font-medium text-gray-700">Sinopsis</label>
                    <div class="mt-1">
                        <textarea wire:model="synopsis" id="synopsis" rows="4" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                    </div>
                    @error('synopsis') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- INPUT COVER (Upload & Preview) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Cover Novel</label>
                    
                    <div class="mt-2 flex items-center justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            
                            {{-- Area Preview Gambar --}}
                            <div class="mb-4">
                                @if ($cover)
                                    {{-- Preview gambar yang baru dipilih --}}
                                    <p class="text-xs text-gray-500 mb-1">Preview Baru:</p>
                                    <img src="{{ $cover->temporaryUrl() }}" class="mx-auto h-48 w-32 object-cover rounded-md shadow-md">
                                @elseif ($old_cover)
                                    {{-- Preview gambar lama (saat edit) --}}
                                    <p class="text-xs text-gray-500 mb-1">Cover Saat Ini:</p>
                                    <img src="{{ $old_cover }}" class="mx-auto h-48 w-32 object-cover rounded-md shadow-md">
                                @else
                                    {{-- Placeholder icon jika belum ada gambar --}}
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                @endif
                            </div>

                            {{-- Tombol Upload --}}
                            <div class="flex text-sm text-gray-600 justify-center">
                                <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Upload file cover</span>
                                    <input wire:model="cover" id="file-upload" name="file-upload" type="file" class="sr-only">
                                </label>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                        </div>
                    </div>
                    @error('cover') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    
                    {{-- Loading Indicator saat upload --}}
                    <div wire:loading wire:target="cover" class="text-sm text-blue-500 mt-1">
                        Sedang mengupload gambar...
                    </div>
                </div>

                {{-- STATUS PUBLISH --}}
                <div class="flex items-center">
                    <input wire:model="is_published" id="is_published" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="is_published" class="ml-2 block text-sm text-gray-900">
                        Publish Sekarang?
                    </label>
                </div>

                {{-- TOMBOL SUBMIT --}}
                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50" wire:loading.attr="disabled">
                        <span wire:loading.remove>{{ $bookId ? 'Update Novel' : 'Buat Novel' }}</span>
                        <span wire:loading>Menyimpan...</span>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>