<!-- resources/views/dashboard/admin/dashboard.blade.php -->
@extends('layout.app')

@section('title')
    Admin Dashboard
@endsection

@section('content')
<section class="p-6 max-w-screen mx-auto bg-white min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Admin Dashboard</h1>
        <div class="flex gap-2">
            <button id="refreshDashboard" class="px-4 py-2 bg-blue-200 text-blue-800 rounded-md hover:bg-blue-300 transition">
                Refresh
            </button>
            <a href="{{ route('book.index') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                Manage Books
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-100 p-4 rounded-md shadow-sm">
            <h3 class="text-blue-600 text-sm">Total Borrow Requests</h3>
            <p class="text-2xl font-semibold">{{ $totalRequests }}</p>
        </div>
        <div class="bg-blue-100 p-4 rounded-md shadow-sm">
            <h3 class="text-blue-600 text-sm">Pending Requests</h3>
            <p class="text-2xl font-semibold">{{ $pendingRequests }}</p>
        </div>
        <div class="bg-blue-100 p-4 rounded-md shadow-sm">
            <h3 class="text-blue-600 text-sm">Total Books</h3>
            <p class="text-2xl font-semibold">{{ $totalBooks }}</p>
        </div>
        <div class="bg-blue-100 p-4 rounded-md shadow-sm">
            <h3 class="text-blue-600 text-sm">Total Users</h3>
            <p class="text-2xl font-semibold">{{ $totalUsers }}</p>
        </div>
    </div>

    <!-- Analytics Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Borrow Status Chart -->
        <div class="bg-blue-100 p-4 rounded-md shadow-sm">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Borrow Statistics</h2>
                <button id="borrowChartType" class="px-3 py-1 bg-blue-200 text-blue-800 rounded-md hover:bg-blue-300 transition">
                    Switch to Bar
                </button>
            </div>
            <div class="h-64">
                <canvas id="borrowChart"></canvas>
            </div>
        </div>
        
        <!-- Book Categories Chart -->
        <div class="bg-blue-100 p-4 rounded-md shadow-sm">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Book Categories</h2>
                <button id="categoryChartType" class="px-3 py-1 bg-blue-200 text-blue-800 rounded-md hover:bg-blue-300 transition">
                    Switch to Bar
                </button>
            </div>
            <div class="h-64">
                <canvas id="categoriesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Borrow Requests Table -->
    <div class="bg-blue-100 p-4 rounded-md shadow-sm mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Borrow Requests</h2>
            <select id="requestFilter" class="px-3 py-1 bg-blue-200 text-blue-800 rounded-md hover:bg-blue-300 transition">
                <option value="all">All Requests</option>
                <option value="pending">Pending</option>
                <option value="borrowed">Borrowed</option>
                <option value="returned">Returned</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-blue-200 text-blue-800">
                        <th class="p-3 text-left">User</th>
                        <th class="p-3 text-left">Book</th>
                        <th class="p-3 text-left">Requested At</th>
                        <th class="p-3 text-left">Return Date</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($borrowRequests->count() === 0)
                        <tr>
                            <td colspan="6" class="p-3 text-center text-blue-500">No borrow requests found</td>
                        </tr>
                    @endif
                    @foreach ($borrowRequests as $request)
                        <tr class="border-b border-blue-200 hover:bg-blue-300 transition request-row" data-status="{{ $request->status }}">
                            <td class="p-3">{{ $request->user->name }}</td>
                            <td class="p-3">{{ $request->book->title }}</td>
                            <td class="p-3">{{ $request->created_at ? \Carbon\Carbon::parse($request->created_at)->format('Y-m-d') : '' }}</td>
                            <td class="p-3">{{ $request->returned_at ? \Carbon\Carbon::parse($request->returned_at)->format('Y-m-d') : '' }}</td>
                            <td class="p-3">
                                @if($request->status == 'pending')
                                    <span class="px-3 py-1 bg-yellow-200 text-yellow-800 rounded-md text-xs">Pending</span>
                                @elseif($request->status == 'borrowed')
                                    <span class="px-3 py-1 bg-green-200 text-green-800 rounded-md text-xs">Borrowed</span>
                                @elseif($request->status == 'rejected')
                                    <span class="px-3 py-1 bg-red-200 text-red-800 rounded-md text-xs">Rejected</span>
                                @elseif($request->status == 'returned')
                                    <span class="px-3 py-1 bg-blue-200 text-blue-800 rounded-md text-xs">Returned</span>
                                @endif
                            </td>
                            <td class="p-3 text-center">
                                @if($request->status == 'pending')
                                    <div class="flex gap-2 justify-center">
                                        <form action="{{ route('borrow.accept') }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="id" value="{{ $request->id }}">
                                            <button type="submit" class="px-3 py-1 bg-green-500 text-white rounded-md hover:bg-green-600 transition">Accept</button>
                                        </form>
                                        <form action="{{ route('borrow.reject') }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="id" value="{{ $request->id }}">
                                            <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 transition">Reject</button>
                                        </form>
                                    </div>
                                @elseif($request->status == 'borrowed')
                                    <form action="{{ route('borrow.return') }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="id" value="{{ $request->id }}">
                                        <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">Return</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Books -->
    <div class="bg-blue-100 p-4 rounded-md shadow-sm">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Recent Books</h2>
            <a href="{{ route('book.create') }}" class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                Add Book
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-blue-200 text-blue-800">
                        <th class="p-3 text-left">Title</th>
                        <th class="p-3 text-left">Cover</th>
                        <th class="p-3 text-left">Author</th>
                        <th class="p-3 text-left">Year</th>
                        <th class="p-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($recentBooks->count() === 0)
                        <tr>
                            <td colspan="5" class="p-3 text-center text-blue-500">No books found</td>
                        </tr>
                    @endif
                    @foreach ($recentBooks as $book)
                        <tr class="border-b border-blue-200 hover:bg-blue-300 transition">
                            <td class="p-3">{{ $book->title }}</td>
                            <td class="p-3">
                                <img src="{{ asset('storage/book-images/' . $book->image) }}" alt="{{ $book->title }}" class="w-16 h-24 object-cover rounded-md" />
                            </td>
                            <td class="p-3">{{ $book->author }}</td>
                            <td class="p-3">{{ $book->published_year }}</td>
                            <td class="p-3 text-center">
                                @if($book->status == 'available')
                                    <span class="px-3 py-1 bg-green-200 text-green-800 rounded-md text-xs">Available</span>
                                @else
                                    <span class="px-3 py-1 bg-red-200 text-red-800 rounded-md text-xs">Unavailable</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Chart variables
            let borrowChartInstance = null;
            let categoriesChartInstance = null;
            let borrowChartType = 'pie';
            let categoryChartType = 'doughnut';
            
            // Initialize charts
            initBorrowChart();
            initCategoriesChart();

            // Initialize filters
            initRequestFilter();
            
            // Borrow Status Chart
            function initBorrowChart() {
                const borrowCtx = document.getElementById('borrowChart').getContext('2d');
                
                if (borrowChartInstance) {
                    borrowChartInstance.destroy();
                }
                
                borrowChartInstance = new Chart(borrowCtx, {
                    type: borrowChartType,
                    data: {
                        labels: ['Pending', 'Borrowed', 'Returned', 'Rejected'],
                        datasets: [{
                            data: [{{ $pendingRequests }}, {{ $borrowedCount }}, {{ $returnedCount ?? 0 }}, {{ $rejectedCount }}],
                            backgroundColor: [
                                '#FBBF24',
                                '#10B981',
                                '#3B82F6',
                                '#EF4444'
                            ],
                            borderColor: [
                                '#F59E0B',
                                '#059669',
                                '#2563EB',
                                '#DC2626'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    padding: 20
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = Math.round((value / total) * 100);
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Book Categories Chart
            function initCategoriesChart() {
                const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
                
                if (categoriesChartInstance) {
                    categoriesChartInstance.destroy();
                }
                
                categoriesChartInstance = new Chart(categoriesCtx, {
                    type: categoryChartType,
                    data: {
                        labels: {!! json_encode($categoryLabels) !!},
                        datasets: [{
                            data: {!! json_encode($categoryData) !!},
                            backgroundColor: [
                                '#3B82F6',
                                '#8B5CF6',
                                '#F59E0B',
                                '#06B6D4',
                                '#EC4899',
                                '#6366F1',
                                '#10B981',
                                '#EF4444',
                                '#14B8A6',
                                '#F97316'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    padding: 20
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = Math.round((value / total) * 100);
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Initialize request filter
            function initRequestFilter() {
                const requestFilter = document.getElementById('requestFilter');
                const rows = document.querySelectorAll('.request-row');
                
                requestFilter.addEventListener('change', function() {
                    const status = this.value;
                    
                    rows.forEach(row => {
                        if (status === 'all' || row.dataset.status === status) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }
            
            // Toggle borrow chart type
            document.getElementById('borrowChartType').addEventListener('click', function() {
                borrowChartType = borrowChartType === 'pie' ? 'bar' : 'pie';
                this.textContent = `Switch to ${borrowChartType === 'pie' ? 'Bar' : 'Pie'}`;
                initBorrowChart();
            });
            
            // Toggle category chart type
            document.getElementById('categoryChartType').addEventListener('click', function() {
                categoryChartType = categoryChartType === 'doughnut' ? 'bar' : 'doughnut';
                this.textContent = `Switch to ${categoryChartType === 'doughnut' ? 'Bar' : 'Doughnut'}`;
                initCategoriesChart();
            });
            
            // Category sort
            document.getElementById('categorySort').addEventListener('change', function() {
                const sortType = this.value;
                const labels = {!! json_encode($categoryLabels) !!};
                const data = {!! json_encode($categoryData) !!};
                
                // Create pairs of label and data for sorting
                let pairs = labels.map((label, i) => {
                    return { label: label, data: data[i] };
                });
                
                // Sort based on selection
                if (sortType === 'alphabetical') {
                    pairs.sort((a, b) => a.label.localeCompare(b.label));
                } else {
                    pairs.sort((a, b) => b.data - a.data);
                }
                
                // Update chart data
                categoriesChartInstance.data.labels = pairs.map(pair => pair.label);
                categoriesChartInstance.data.datasets[0].data = pairs.map(pair => pair.data);
                categoriesChartInstance.update();
            });
            
            // Refresh dashboard
            document.getElementById('refreshDashboard').addEventListener('click', function() {
                window.location.reload();
            });
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
                background: "#A7D7C5", // Success - keep green color
                color: "#4A4A4A",
                borderRadius: "8px",
                boxShadow: "0 4px 0 #86c0ae, 0 6px 15px rgba(0,0,0,0.1)",
                padding: "12px 20px",
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
            stopOnFocus: true,
            style: {
                background: "#EF4444", // Red for warnings/errors
                color: "#FFFFFF",
                borderRadius: "8px",
                boxShadow: "0 4px 0 #b91c1c, 0 6px 15px rgba(0,0,0,0.1)",
                padding: "12px 20px",
                fontWeight: "500"
            },
            onClick: function(){}
        }).showToast();
    </script>
    @endif
@endsection