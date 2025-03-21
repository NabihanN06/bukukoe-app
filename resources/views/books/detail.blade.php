@extends('layout.app')

@section('title')
    {{ $book->title }}
@endsection

@section('content')
<section class="p-6 md:p-8 max-w-7xl mx-auto">
    <div class="flex flex-col gap-6">
        <!-- Header and Back Button -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-blue-800">Book Details</h1>
            <a href="javascript:history.back()" class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full font-medium hover:bg-blue-200 transition-all duration-200 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back
            </a>
        </div>

        <!-- Book Details Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-blue-100">
            <div class="grid grid-cols-1 md:grid-cols-7 gap-6 p-6">
                <!-- Book Image -->
                <div class="md:col-span-3 flex justify-center md:justify-start">
                    <div class="relative">
                        <img src="{{ asset('storage/book-images/' . $book->image) }}" alt="{{ $book->title }}" class="w-full max-w-sm rounded-lg shadow-md object-cover transform transition-transform" />
                        <div class="absolute -bottom-3 -right-3 bg-blue-500 text-white px-3 py-1 rounded-full font-bold border-2 border-blue-700 shadow-md">
                            {{ $book->status }}
                        </div>
                    </div>
                </div>

                <!-- Book Info -->
                <div class="flex flex-col gap-4 md:col-span-4">
                    <div class="flex flex-col gap-6">
                        <div>
                            <h2 class="text-3xl font-bold text-blue-800 mb-2">{{ $book->title }}</h2>
                            <p class="text-blue-600 text-lg">by {{ $book->author }} ({{ $book->published_year }})</p>
                        </div>

                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-lg text-blue-800 mb-2">Description</h3>
                            <p class="text-blue-700">{{ $book->description }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <h3 class="font-semibold text-blue-800">Total Pages</h3>
                                <p class="text-blue-700 text-lg">{{ $book->page_count }}</p>
                            </div>
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <h3 class="font-semibold text-blue-800">Published</h3>
                                <p class="text-blue-700 text-lg">{{ $book->published_year }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Book Details -->
        <div class="bg-white rounded-lg p-4 border border-blue-100 shadow-md mb-6">
            <h3 class="font-semibold text-blue-800 mb-3 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
            </svg>
            Book Details
            </h3>
            <div class="grid grid-cols-1 gap-3">
            <div class="flex justify-between border-b border-blue-100 pb-2">
                <span class="font-medium text-blue-600">ISBN:</span>
                <span class="text-blue-700">{{ $book->isbn ?? 'N/A' }}</span>
            </div>
            <div class="flex justify-between border-b border-blue-100 pb-2">
                <span class="font-medium text-blue-600">Publisher:</span>
                <span class="text-blue-700">{{ $book->publisher ?? 'N/A' }}</span>
            </div>
            <div class="flex justify-between border-b border-blue-100 pb-2">
                <span class="font-medium text-blue-600">Language:</span>
                <span class="text-blue-700">{{ $book->language ?? 'English' }}</span>
            </div>
            <div class="flex justify-between border-b border-blue-100 pb-2">
                <span class="font-medium text-blue-600">Available Copies:</span>
                <span class="text-blue-700">{{ $book->available_copies ?? '1' }}</span>
            </div>
            </div>
        </div>

        <!-- Reading Stats -->
        <div class="bg-white rounded-lg p-4 border border-blue-100 shadow-md">
            <h3 class="font-semibold text-blue-800 mb-3 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5 3a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2H5zm9 4a1 1 0 10-2 0v6a1 1 0 102 0V7zm-3 2a1 1 0 10-2 0v4a1 1 0 102 0V9zm-3 3a1 1 0 10-2 0v1a1 1 0 102 0v-1z" clip-rule="evenodd" />
            </svg>
            Reading Stats
            </h3>
            <div class="grid grid-cols-1 gap-3">
            <div class="flex justify-between border-b border-blue-100 pb-2">
                <span class="font-medium text-blue-600">Borrowed Times:</span>
                <span class="text-blue-700">{{ $book->borrow_count ?? '0' }}</span>
            </div>
            <div class="flex justify-between border-b border-blue-100 pb-2">
                <span class="font-medium text-blue-600">Average Rating:</span>
                <span class="text-blue-700 flex items-center">
                {{ $book->average_rating ?? '4.5' }}/5
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 ml-1" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                </span>
            </div>
            <div class="flex justify-between border-b border-blue-100 pb-2">
                <span class="font-medium text-blue-600">Reading Time:</span>
                <span class="text-blue-700">{{ ceil($book->page_count / 30) ?? '5' }} hours</span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium text-blue-600">Category:</span>
                <span class="text-blue-700">{{ $book->category ?? 'Fiction' }}</span>
            </div>
            </div>
        </div>

        <!-- Similar Books -->
        <div class="bg-white rounded-lg p-4 border border-blue-100 shadow-md">
            <h3 class="font-semibold text-lg text-blue-800 mb-3 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                </svg>
                You May Also Like
            </h3>
            <div class="text-blue-600 italic">
                Related books will appear here
            </div>
        </div>
    </div>
</section>
@endsection
