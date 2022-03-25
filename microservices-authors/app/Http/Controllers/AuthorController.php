<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorController extends Controller {

    use ApiResponser;

    public function __construct(){

    }

    /**
     * Return authors list.
     *
     * @return Illuminate\Http\Response
     */
    public function index(){

        $authors = Author::all();

        return $this->successResponse($authors);
    }

    /**
     * Create an instance of author.
     *
     * @return Illuminate\Http\Response
     */
    public function store(Request $request){
        // Validation rules
        $rules = [
            'name' => 'required|max:255',
            'gender' => 'required|max:255|in:male,female',
            'country' => 'required|max:255',
        ];

        // Exec validations
        $this->validate($request, $rules);

        // Create a new instance of author
        $author = Author::create($request->all());

        return $this->successResponse($author, Response::HTTP_CREATED);
    }

    /**
     * Return an specific author.
     *
     * @return Illuminate\Http\Response
     */
    public function show($author){
        // Find an specific author
        $author = Author::findOrFail($author);

        return $this->successResponse($author);
    }

    /**
     * Update an specific author.
     *
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $author){
        // Validation rules
        $rules = [
            'name' => 'max:255',
            'gender' => 'max:255|in:male,female',
            'country' => 'max:255',
        ];

        // Exec validations
        $this->validate($request, $rules);

        // Find an specific author
        $author = Author::findOrFail($author);

        // Fill values from the request to instance of author
        $author->fill($request->all());

        // Verify if there is at least one change
        if($author->isClean()){
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Save changes
        $author->save();

        return $this->successResponse($author);
    }

    /**
     * Remove an specific author.
     *
     * @return Illuminate\Http\Response
     */
    public function destroy($author){
        // Find an specific author
        $author = Author::findOrFail($author);

        // Delete from database
        $author->delete();

        return $this->successResponse($author);
    }

}
