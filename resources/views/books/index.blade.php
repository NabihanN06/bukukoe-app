@extends('layout.app')

@section('title')
    Books
@endsection

@section('content')
<section class="p-8 flex flex-col gap-6 max-w-7xl mx-auto bg-white min-h-screen">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <h1 class="text-4xl font-bold text-blue-800 tracking-tight">Books</h1>
        <a href="{{ route('book.create') }}" class="px-7 py-2.5 bg-blue-600 text-white rounded-full font-medium hover:bg-blue-700 transition-all duration-200 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Add New Book
        </a>
    </div>

    <!-- Search Bar -->
    <div class="mb-6 relative">
        <label for="search" class="sr-only">Search</label>
        <div class="relative">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
            </svg>
            <input type="text" id="search" name="search" placeholder="Search by title or author..." class="pl-12 pr-4 py-3 bg-gray-100 w-full border-2 border-gray-300 text-blue-800 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-30 transition-all">
        </div>
    </div>

    <div class="bg-gray-100 rounded-2xl shadow-lg overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-blue-600 text-white">
                        <th class="px-4 py-4 text-left font-semibold">#</th>
                        <th class="px-4 py-4 text-left font-semibold">Title</th>
                        <th class="px-4 py-4 text-left font-semibold">Cover</th>
                        <th class="px-4 py-4 text-left font-semibold">Author</th>
                        <th class="px-4 py-4 text-left font-semibold">Year</th>
                        <th class="px-4 py-4 text-center font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($books->count() === 0)
                    <tr>
                        <td colspan="6" class="p-6 text-center text-gray-500 font-medium">No books found</td>
                    </tr>
                    @endif
                    @foreach ($books as $book)
                        <tr class="border-b border-gray-200 hover:bg-blue-100 transition-colors">
                            <td class="px-4 py-4 text-blue-800">{{ $books->perPage() * ($books->currentPage() - 1) + $loop->index + 1 }}</td>
                            <td class="px-4 py-4 font-medium text-blue-800">{{ $book->title }}</td>
                            <td class="px-4 py-4">
                                <img src="{{ asset("storage/book-images/" . $book->image) }}" alt="{{ $book->title }}" class="w-16 h-24 object-cover rounded-lg shadow-lg transform transition-transform hover:scale-105">
                            </td>
                            <td class="px-4 py-4 text-blue-800">{{ $book->author }}</td>
                            <td class="px-4 py-4 text-blue-800">{{ $book->published_year }}</td>
                            <td class="px-4 py-4">
                                <div class="flex gap-2 justify-center">
                                    <a href="{{ route('book.show', $book->slug) }}" class="px-3 py-1.5 bg-blue-500 text-white rounded-full text-sm font-medium hover:bg-blue-600 transition-all duration-200">Detail</a>
                                    <a href="{{ route('book.edit', $book->slug) }}" class="px-3 py-1.5 bg-blue-500 text-white rounded-full text-sm font-medium hover:bg-blue-600 transition-all duration-200">Edit</a>
                                    <button 
                                        onclick="confirmDelete({{ $book->id }}, '{{ $book->title }}')" 
                                        class="px-3 py-1.5 bg-red-500 text-white rounded-full text-sm font-medium hover:bg-red-600 transition-all duration-200"
                                    >Delete</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-center mt-6">
        <div class="bg-gray-100 rounded-xl p-3 shadow-lg">
            <div class="flex items-center gap-3">
                @if ($books->onFirstPage())
                    <span class="px-5 py-2 bg-gray-200 text-gray-400 rounded-full font-medium cursor-not-allowed">Previous</span>
                @else
                    <a href="{{ $books->previousPageUrl() }}" class="px-5 py-2 bg-blue-500 text-white rounded-full font-medium hover:bg-blue-600 transition-all duration-200">Previous</a>
                @endif

                <div class="flex items-center gap-2">
                    @for ($i = 1; $i <= $books->lastPage(); $i++)
                        @if ($i == $books->currentPage())
                            <span class="w-10 h-10 flex items-center justify-center bg-blue-500 text-white rounded-full font-medium">{{ $i }}</span>
                        @else
                            <a href="{{ $books->url($i) }}" class="w-10 h-10 flex items-center justify-center bg-gray-200 text-blue-800 rounded-full font-medium hover:bg-gray-300 transition-all duration-200">{{ $i }}</a>
                        @endif
                    @endfor
                </div>

                @if ($books->hasMorePages())
                    <a href="{{ $books->nextPageUrl() }}" class="px-5 py-2 bg-blue-500 text-white rounded-full font-medium hover:bg-blue-600 transition-all duration-200">Next</a>
                @else
                    <span class="px-5 py-2 bg-gray-200 text-gray-400 rounded-full font-medium cursor-not-allowed">Next</span>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Confirmation Modal for Delete -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full shadow-2xl border-2 border-gray-200 transform transition-all">
        <h3 class="text-2xl font-bold text-blue-800 mb-4">Confirm Deletion</h3>
        <p id="deleteMessage" class="text-gray-700 mb-6">Are you sure you want to delete this book? This action cannot be undone.</p>
        <div class="flex justify-end gap-3">
            <button 
                onclick="closeModal()" 
                class="px-5 py-2.5 bg-gray-200 text-blue-800 rounded-full font-medium hover:bg-gray-300 transition-all duration-200"
            >
                Cancel
            </button>
            <form id="deleteForm" action="" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button 
                    type="submit" 
                    class="px-5 py-2.5 bg-red-500 text-white rounded-full font-medium hover:bg-red-600 transition-all duration-200"
                >
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    function confirmDelete(id, title) {
        document.getElementById('deleteMessage').textContent = `Are you sure you want to delete "${title}"? This action cannot be undone.`;
        document.getElementById('deleteForm').action = `{{ route('book.delete', '') }}/${id}`;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteModal').children[0].classList.add('scale-100');
    }
    
    function closeModal() {
        const modal = document.getElementById('deleteModal');
        modal.children[0].classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.children[0].classList.remove('scale-95');
        }, 150);
    }
    
    // Close modal if user clicks outside of it
    window.onclick = function(event) {
        const modal = document.getElementById('deleteModal');
        if (event.target == modal) {
            closeModal();
        }
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            closeModal();
        }
    });

    // Handle search functionality with debounce
    const searchInput = document.getElementById('search');
    let debounceTimeout;
    
    searchInput.addEventListener('keyup', function(e) {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(() => {
            const searchValue = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                if (row.children.length <= 1) return; // Skip "No books found" row
                
                const titleCell = row.querySelector('td:nth-child(2)');
                const authorCell = row.querySelector('td:nth-child(4)');
                if (titleCell.textContent.toLowerCase().includes(searchValue) || 
                    authorCell.textContent.toLowerCase().includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }, 300);
    });
</script>

@if (session('success'))
<script>
    Toastify({
        text: "{{ session('success') }}",
        duration: 3000,
        close: true,
        gravity: "top",
        position: "right",
        stopOnFocus: true,
        style: {
            background: "#3B82F6", // Success - blue color
            color: "#FFFFFF",
            borderRadius: "12px",
            boxShadow: "0 4px 0 #2563EB, 0 6px 15px rgba(0,0,0,0.1)",
            padding: "14px 22px",
            fontWeight: "500"
        },
        onClick: function(){}
    }).showToast();
</script>
@endif

@if (session('warning') || session('error') || session('danger'))
<script>
    Toastify({
        text: "{{ session('warning') ?? session('error') ?? session('danger') }}",
        duration: 3000,
        close: true,
        gravity: "top",
        position: "right",
        style: {
            background: "#EF4444", // Red color
            color: "#FFFFFF",
            borderRadius: "12px",
            boxShadow: "0 4px 0 #b91c1c, 0 6px 15px rgba(0,0,0,0.1)",
            padding: "14px 22px",
            fontWeight: "500"
        },
    }).showToast();
</script>
@endif
@endsection