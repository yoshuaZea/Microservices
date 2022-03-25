<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller {

    use ApiResponser;

    public function __construct(){

    }

    /**
     * Return books list.
     *
     * @return Illuminate\Http\Response
     */
    public function index(){

        $books = Book::all();

        return $this->successResponse($books);
    }

    /**
     * Create an instance of book.
     *
     * @return Illuminate\Http\Response
     */
    public function store(Request $request){
        // Validation rules
        $rules = [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'price' => 'required|numeric|min:1',
            'author_id' => 'required|integer|min:1'
        ];

        // Exec validations
        $this->validate($request, $rules);

        // Create a new instance of book
        $book = Book::create($request->all());

        return $this->successResponse($book, Response::HTTP_CREATED);
    }

    /**
     * Return an specific book.
     *
     * @return Illuminate\Http\Response
     */
    public function show($book){
        // Find an specific book
        $book = Book::findOrFail($book);

        return $this->successResponse($book);
    }

    /**
     * Update an specific book.
     *
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $book){
        // Validation rules
        $rules = [
            'title' => 'max:255',
            'description' => 'max:255',
            'price' => 'numeric|min:1',
            'author_id' => 'integer|min:1'
        ];

        // Exec validations
        $this->validate($request, $rules);

        // Find an specific book
        $book = Book::findOrFail($book);

        // Fill values from the request to instance of book
        $book->fill($request->all());

        // Verify if there is at least one change
        if($book->isClean()){
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Save changes
        $book->save();

        return $this->successResponse($book);
    }

    /**
     * Remove an specific book.
     *
     * @return Illuminate\Http\Response
     */
    public function destroy($book){
        // Find an specific book
        $book = Book::findOrFail($book);

        // Delete from database
        $book->delete();

        return $this->successResponse($book);
    }

}
