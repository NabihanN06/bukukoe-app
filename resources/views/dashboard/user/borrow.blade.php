@extends('layout.app')

@section('title')
    Borrow | {{$book->title}}
@endsection

@section('content')
<section class="p-6 md:p-8 max-w-7xl mx-auto">
    <div class="flex flex-col gap-6">
        <!-- Header and Back Button -->
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-blue-600">Borrow Book</h1>
            <a href="{{ url()->previous() }}" class="px-4 py-2 bg-blue-100 text-blue-600 rounded-full hover:bg-blue-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Books
            </a>
        </div>

        <!-- Book Details Card -->
        <div class="bg-white rounded-lg p-6 border border-blue-200">
            <div class="grid grid-cols-1 md:grid-cols-7 gap-6">
                <!-- Book Image -->
                <div class="md:col-span-3 flex justify-center">
                    <img src="{{ asset('storage/book-images/' . $book->image) }}" alt="{{ $book->title }}" class="w-full max-w-sm rounded-lg object-cover" />
                </div>

                <!-- Book Info -->
                <div class="md:col-span-4 flex flex-col gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-blue-600">{{ $book->title }}</h2>
                        <p class="text-gray-500">by {{ $book->author }} ({{ $book->published_year }})</p>
                    </div>

                    <div>
                        <h3 class="font-semibold text-blue-600">Description</h3>
                        <p class="text-gray-700">{{ $book->description }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h3 class="font-semibold text-blue-600">Total Pages</h3>
                            <p class="text-gray-700">{{ $book->page_count }}</p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-blue-600">Borrowed Times</h3>
                            <p class="text-gray-700">{{ $book->borrow_count }}</p>
                        </div>
                    </div>

                    <!-- Borrow Section -->
                    <div class="mt-auto">
                        <div class="mb-4">
                            <h3 class="font-semibold text-blue-600">Approximate Return Date</h3>
                            <p class="text-gray-700">{{ now()->addDays(7)->format('l, j F Y') }}</p>
                        </div>
                        
                        <div class="text-right">
                            <form action={{route('borrow.request', $book->id)}} method="POST">
                                @csrf
                                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition">
                                    Proceed to Borrow
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Borrowing Policy -->
        <div class="bg-white rounded-lg p-4 border border-blue-200">
            <h3 class="font-semibold text-blue-600 mb-2">Borrowing Policy</h3>
            <ul class="list-disc list-inside text-gray-700 space-y-1">
                <li>Books can be borrowed for a maximum of 7 days.</li>
                <li>Late returns will incur a fee of $0.50 per day.</li>
                <li>Books must be returned in the same condition.</li>
                <li>You may renew your borrow period once if the book is not reserved by another user.</li>
            </ul>
        </div>
    </div>
</section>
@endsection
