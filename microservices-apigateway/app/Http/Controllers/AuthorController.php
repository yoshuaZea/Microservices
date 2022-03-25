<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\AuthorService;

class AuthorController extends Controller {

    use ApiResponser;

    /**
     * The service to consume the author service
     * @return AuthorService
     */
    public $authorService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AuthorService $authorService){
        $this->authorService = $authorService;
    }

    /**
     * Retrieve and show all the authors.
     * @return Illuminate/Http/Response
     */
    public function index(){
        return $this->successResponse($this->authorService->obtainAuthors());
    }

    /**
     * Create an instance of authors.
     * @return Illuminate/Http/Request
     */
    public function store(Request $request){
        return $this->successResponse($this->authorService->createAuthor($request->all(), Response::HTTP_CREATED));
    }

    /**
     * Obtain and show an instance of authors.
     * @return Illuminate/Http/Request
     */
    public function show($author){
        return $this->successResponse($this->authorService->obtainAuthor($author));
    }

    /**
     * Updates an instance of authors.
     * @return Illuminate/Http/Request
     */
    public function update(Request $request, $author){
        return $this->successResponse($this->authorService->editAuthor($request->all(), $author));
    }

    /**
     * Removes an instance of authors.
     * @return Illuminate/Http/Request
     */
    public function destroy($author){
        return $this->successResponse($this->authorService->deleteAuthor($author));
    }
}
