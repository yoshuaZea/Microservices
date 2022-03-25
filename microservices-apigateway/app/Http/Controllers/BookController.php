<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Services\BookService;
use Illuminate\Http\Response;
use App\Services\AuthorService;

class BookController extends Controller {

    use ApiResponser;

    /**
     * The service to consume the book service
     * @return BookService
     */
    public $bookService;

    /**
     * The service to consume the book service
     * @return AuthorService
     */
    public $authorService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BookService $bookService, AuthorService $authorService){
        $this->bookService = $bookService;
        $this->authorService = $authorService;
    }

    /**
     * Retrieve and show all the books.
     * @return Illuminate/Http/Response
     */
    public function index(){
        return $this->successResponse($this->bookService->obtainBooks());
    }

    /**
     * Create an instance of books.
     * @return Illuminate/Http/Request
     */
    public function store(Request $request){

        // Make a request to verify if exists the author
        $this->authorService->obtainAuthor($request->author_id);

        return $this->successResponse($this->bookService->createBook($request->all(), Response::HTTP_CREATED));
    }

    /**
     * Obtain and show an instance of books.
     * @return Illuminate/Http/Request
     */
    public function show($book){
        return $this->successResponse($this->bookService->obtainBook($book));
    }

    /**
     * Updates an instance of books.
     * @return Illuminate/Http/Request
     */
    public function update(Request $request, $book){
        // Make a request to verify if exists the author
        $this->authorService->obtainAuthor($request->author_id);

        return $this->successResponse($this->bookService->editBook($request->all(), $book));
    }

    /**
     * Removes an instance of books.
     * @return Illuminate/Http/Request
     */
    public function destroy($book){
        return $this->successResponse($this->bookService->deleteBook($book));
    }
}
