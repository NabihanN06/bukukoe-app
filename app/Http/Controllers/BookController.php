<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
// use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::latest()->paginate(10);
        
        if ($request->has('query')) {
            $query = $request->input('query');
            $books = Book::where('title', 'LIKE', "%{$query}%")
                ->orWhere('author', 'LIKE', "%{$query}%")
                ->latest()
                ->paginate(10);
        }

        return view("books.index", compact("books"));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $books = Book::where('title', 'LIKE', "%{$query}%")
            ->orWhere('author', 'LIKE', "%{$query}%")
            ->latest()
            ->paginate(10);
        
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view("books.create");
    }
    public function store(Request $request)
    {
        // validasi
        $request->validate([
            "title" => "required|unique:books|min:3|max:255",
            "description" => "required|min:3|max:255",
            "page_count" =>"required|numeric|min:1",
            "author" => "required|min:3|max:255",
            "published_year" => "required|numeric|digits:4",
            "image" => "required|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
        ],[
            "title.required" => "Title cannot be empty",
            "title.unique" => "Title already exists",
            "published_year.digits" => "Year must be between",
            "image.max" => "File is too large",
        ]);

        try {
            // get uploaded image
            $image = $request->file("image");
            // dd($image);
            // rename the uploaded image
            $renamedImage = time(). "-" . rand(1, 1000) .".". $image->getClientOriginalExtension();
            // store the image into specific folder
            $image->storeAs("book-images", $renamedImage,"public");

            $slugTitle = Str::slug($request->title);

            $book = new Book();
            $book->title = $request->title;
            $book->slug = $slugTitle;
            $book->description = $request->description;
            $book->page_count = $request->page_count;
            $book->author = $request->author;
            $book->published_year = $request->published_year;
            $book->image = $renamedImage;
            $book->save();

            $book = Book::create([
                "title"=> $request->title,
                "slug" => $slugTitle,
                "description" => $request->description,
                "page_count" => $request->page_count,
                "author" => $request->author,
                "published_year" => $request->published_year,
                "image"=> $renamedImage,
            ]);

            // dd($book);

            // $book = DB::table("books")->insert([
            //     "title" => $request->title,
            //     "slug" => $slugTitle,
            //     "description" => $request->description,
            //     "page_count" => $request->page_count,
            //     "author" => $request->author,
            //     "published_year" => $request->published_year,
            //     "image" => $renamedImage,
            //     ]);

            if ($book) {
            return redirect()->route("book.index")->with("success", "Book created successfully");
            } else {
                throw new \Exception("Failed to create book");
            }

        } catch (\Exception $e) {
            // dd($e->getMessage());
            return redirect()->back()->with("error", $e->getMessage())->withInput(request()->all());
        }
    }

    public function show(Request $request)
    {
        $book = Book::where("slug", $request->slug)->first();
        return view("books.detail", compact("book"));
    }
    public function edit(Request $request)
    {
        $book = Book::where("slug", $request->slug)->first();
        
        if (!$book) {
            return redirect()->route("book.index")->with("error", "Book not found");
        }
        
        return view("books.edit", compact("book"));
    }
    public function update(Request $request)
    {
        $request->validate([
            "title" => "required|min:3|max:255",
            "description" => "required|min:3|max:255",
            "page_count" =>"required|numeric|min:1",
            "author" => "required|min:3|max:255",
            "published_year" => "required|numeric|digits:4",
            "image" => "image|mimes:jpeg,png,jpg,gif,svg|max:2048",
        ],[
            "title.required" => "Title cannot be empty",
            "title.unique" => "Title already exists",
            "published_year.digits" => "Invalid year",
            "image.max" => "Image is too large",
        ]);

        try {
            $book = Book::where("slug", $request->slug)->first();

            // check if image is uploaded
            if ($request->hasFile("image")) {
                // check if book has image

                if ($book->image) {
                    // if exsits, delete
                    Storage::disk("public")->delete("book-images/" . $book->image);
                }
                
                $image = $request->file("image");
                $renamedImage = time(). "-" . rand(1, 1000) .".". $image->getClientOriginalExtension();
                $image->storeAs("book-images", $renamedImage,"public");
            } else {
                $renamedImage = $book->image;
            }

            $slugTitle = Str::slug($request->title);

            $book->update([
                "title"=> $request->title,
                "slug" => $slugTitle,
                "description" => $request->description,
                "page_count" => $request->page_count,
                "author" => $request->author,
                "published_year" => $request->published_year,
                "image"=> $renamedImage,
            ]);

            if ($book) {
            return redirect()->route("book.index")->with("success", "Book updated successfully");
            } else {
                throw new \Exception("Failed to create book");
            }

        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with("error", $e->getMessage())->withInput(request()->all());
        }
    }
    public function destroy(Request $request)
    {
        $book = Book::find( $request->id );

        if ($book) {
            if ($book->image) {
                Storage::disk("public")->delete("book-images/" . $book->image);
            }
            $book->delete();
            return redirect()->route("book.index")->with("success", "Book deleted successfully");
        }

        return redirect()->back()->with("error","Book not found");
    }
}
