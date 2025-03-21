@extends('layout.app')

@section('title')
    Edit Book | {{ $book->title }}
@endsection

@section('content')
<section class="p-6 md:p-8 max-w-5xl mx-auto">
    <div class="flex flex-col gap-6">
        <!-- Header and Back Button -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-blue-800">Edit Book</h1>
            <a href="javascript:history.back()" class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full font-medium hover:bg-blue-200 transition-all duration-200 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back
            </a>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
        <div class="space-y-2">
            @foreach ($errors->all() as $error)
            <div class="p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-lg font-medium">
                {{ $error }}
            </div>
            @endforeach
        </div>
        @endif

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
            <form action="{{ route('book.update', $book->slug) }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="flex flex-col gap-6">
                        <!-- Book Title -->
                        <div class="flex flex-col gap-2">
                            <label for="title" class="font-semibold text-blue-800">Book Title <span class="text-red-500">*</span></label>
                            <input 
                                type="text" 
                                name="title" 
                                id="title" 
                                value="{{ $book->title }}"
                                class="border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                                placeholder="Enter book title" 
                                required
                            />
                        </div>

                        <!-- Author -->
                        <div class="flex flex-col gap-2">
                            <label for="author" class="font-semibold text-blue-800">Author <span class="text-red-500">*</span></label>
                            <input 
                                type="text" 
                                name="author" 
                                id="author" 
                                value="{{ $book->author }}"
                                class="border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                                placeholder="Enter author name" 
                                required
                            />
                        </div>

                        <!-- Published Year -->
                        <div class="flex flex-col gap-2">
                            <label for="published_year" class="font-semibold text-blue-800">Publication Year <span class="text-red-500">*</span></label>
                            <input 
                                type="number" 
                                name="published_year" 
                                id="published_year" 
                                value="{{ $book->published_year }}"
                                min="1000" 
                                max="{{ date('Y') }}" 
                                class="border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                                placeholder="Enter publication year" 
                                required
                            />
                        </div>

                        <!-- Page Count -->
                        <div class="flex flex-col gap-2">
                            <label for="page_count" class="font-semibold text-blue-800">Page Count <span class="text-red-500">*</span></label>
                            <input 
                                type="number" 
                                name="page_count" 
                                id="page_count" 
                                value="{{ $book->page_count }}"
                                min="1" 
                                class="border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                                placeholder="Enter number of pages" 
                                required
                            />
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="flex flex-col gap-6">
                        <!-- Book Description -->
                        <div class="flex flex-col gap-2">
                            <label for="description" class="font-semibold text-blue-800">Description <span class="text-red-500">*</span></label>
                            <textarea 
                                name="description" 
                                id="description" 
                                rows="5" 
                                class="border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                                placeholder="Enter book description"
                                required
                            >{{ $book->description }}</textarea>
                        </div>

                        <!-- Category -->
                        <div class="flex flex-col gap-2">
                            <label for="category" class="font-semibold text-blue-800">Category</label>
                            <select name="category" id="category" class="border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                <option value="">Select a category</option>
                                <option value="Fiction" {{ $book->category == 'Fiction' ? 'selected' : '' }}>Fiction</option>
                                <option value="Non-Fiction" {{ $book->category == 'Non-Fiction' ? 'selected' : '' }}>Non-Fiction</option>
                                <option value="Science" {{ $book->category == 'Science' ? 'selected' : '' }}>Science</option>
                                <option value="Technology" {{ $book->category == 'Technology' ? 'selected' : '' }}>Technology</option>
                                <option value="History" {{ $book->category == 'History' ? 'selected' : '' }}>History</option>
                                <option value="Biography" {{ $book->category == 'Biography' ? 'selected' : '' }}>Biography</option>
                                <option value="Self-Help" {{ $book->category == 'Self-Help' ? 'selected' : '' }}>Self-Help</option>
                                <option value="Other" {{ $book->category == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <!-- Book Cover Image -->
                        <div class="flex flex-col gap-2">
                            <label for="image" class="font-semibold text-blue-800">Book Cover</label>
                            <div class="flex flex-col gap-2">
                                @if ($book->image)
                                    <div class="rounded-lg overflow-hidden border border-gray-200">
                                        <img src="{{ asset('storage/book-images/' . $book->image) }}" alt="{{ $book->title }}" class="w-full h-auto max-h-48 object-contain" />
                                    </div>
                                @endif
                                <div class="bg-gray-50 border border-gray-300 rounded-lg p-4 text-center relative">
                                    <input 
                                        type="file" 
                                        accept="image/*" 
                                        name="image" 
                                        id="image" 
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                                    />
                                    <div class="flex flex-col items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-gray-500">Click to upload new book cover image</span>
                                        <span class="text-xs text-gray-400">(Recommended size: 400x600px)</span>
                                    </div>
                                </div>
                                <div id="image-preview" class="hidden rounded-lg overflow-hidden border border-gray-200">
                                    <img src="#" alt="Image preview" class="w-full h-auto" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-8 flex justify-end">
                    <button 
                        type="submit" 
                        class="px-6 py-3 bg-blue-500 text-white rounded-full font-medium hover:bg-blue-600 transition-all duration-200"
                    >
                        Update Book
                    </button>
                </div>
            </form>
        </div>

        <!-- Form Guidelines -->
        <div class="bg-white rounded-lg p-4 border border-gray-200 shadow-md">
            <h3 class="font-semibold text-blue-800 mb-2">Guidelines for Editing Books</h3>
            <ul class="list-disc list-inside text-gray-700 space-y-1 pl-2">
                <li>Make sure the book information is accurate and complete.</li>
                <li>Upload a new image only if you want to replace the existing one.</li>
                <li>Provide a comprehensive description that helps readers understand what the book is about.</li>
                <li>Double-check the publication year and page count for accuracy.</li>
            </ul>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('image-preview');
    
    imageInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                imagePreview.querySelector('img').src = e.target.result;
                imagePreview.classList.remove('hidden');
            };
            
            reader.readAsDataURL(this.files[0]);
        }
    });
});
</script>
@endsection
