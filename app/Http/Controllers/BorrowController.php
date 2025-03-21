<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowController extends Controller
{
    public function request(Request $request)
    {
        $book = Book::find($request->id);
        if (!$book) {
            return redirect()->back()->with('error', 'Book not found');
        }

        try {
            if($book->status == 'unavailable'){
                throw new \Exception('Book is not available');
            }
            
            $returnedAt = now()->addDays(7);
            $user = Auth::user();
            $borrow = $user->borrows()->create([
                'book_id' => $book->id,
                'returned_at' => $returnedAt,
            ]);

            if ($borrow) {
                $borrow->book()->update(['status' => 'unavailable']);
                return redirect()->route('dashboard.index')->with('success','Book borrowed successfully');
            } else {
                throw new \Exception('Failed to borrow book');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function accept(Request $request)
    {
     $request->validate([
        'id' => "required|exists:borrows,id",
     ]);

     try {
        $borrow = Borrow::find($request->id);
        $borrow -> update([
            'status' => 'borrowed',
        ]);
        return redirect()->route('dashboard.index')->with('success','Book request accepted');
    
         } catch (\Exception $e) {
        return redirect()->back()->with('error', $e->getMessage());
         }
    }

    public function reject(Request $request)
    {
     $request->validate([
        'id' => "required|exists:borrows,id",
     ]);

     try {
        $borrow = Borrow::find($request->id);
        $borrow -> update([
            'status' => 'rejected',
        ]);
        return redirect()->route('dashboard.index')->with('success','Book request rejected');
    
         } catch (\Exception $e) {
        return redirect()->back()->with('error', $e->getMessage());
         }
    }

    public function return(Request $request)
{
    $request->validate([
        'id' => "required|exists:borrows,id",
    ]);

    try {
        $borrow = Borrow::find($request->id);
        $borrow->update([
            'status' => 'returned',
            'returned_at' => now(),
        ]);
        
        // Set book status back to available
        $book = Book::find($borrow->book_id);
        $book->update(['status' => 'available']);
        
        return redirect()->route('dashboard.index')->with('success', 'Book has been returned successfully');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', $e->getMessage());
    }
}
}

