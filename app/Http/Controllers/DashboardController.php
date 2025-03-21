<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            // Get all borrow requests with related user and book data
            $borrowRequests = Borrow::with(['user', 'book'])
                ->orderBy('created_at', 'desc')
                ->get();
                
            // Calculate statistics for the dashboard
            $totalRequests = Borrow::count();
            $pendingRequests = Borrow::where('status', 'pending')->count();
            $borrowedCount = Borrow::where('status', 'borrowed')->count();
            $rejectedCount = Borrow::where('status', 'rejected')->count();
            $returnedCount = Borrow::where('status', 'returned')->count();
            
            // Get counts for the statistics cards
            $totalBooks = Book::count();
            $totalUsers = User::where('role', '!=', 'admin')->count();
            
            // Get recently added books
            $recentBooks = Book::orderBy('created_at', 'desc')
                ->take(5)
                ->get();
            
            // Get book categories for chart
$categories = Book::select('category')
->whereNotNull('category')
->distinct()
->get();

$categoryLabels = [];
$categoryData = [];

foreach ($categories as $category) {
$categoryLabels[] = $category->category ?: 'Uncategorized';
$categoryData[] = Book::where('category', $category->category)->count();
}
            
            // If there are no categories or all books have null category,
            // show one category for all books
            if (empty($categoryLabels)) {
                $categoryLabels[] = 'All Books';
                $categoryData[] = Book::count();
            }
            
            return view('dashboard.admin.dashboard', compact(
                'borrowRequests',
                'totalRequests',
                'pendingRequests',
                'borrowedCount',
                'rejectedCount',
                'returnedCount',
                'totalBooks',
                'totalUsers',
                'recentBooks',
                'categoryLabels',
                'categoryData'
            ));
        }

        // User dashboard view
        $books = Book::latest()->paginate(10);
        return view('dashboard.user.dashboard', compact('books'));
    }
    
    public function borrow(Request $request)
    {
        $book = Book::where('slug', $request->slug)->first();
        if (!$book) {
            return redirect()->route('dashboard.index')->with('error', 'Book not found');
        }

        return view('dashboard.user.borrow', compact('book'));
    }
}