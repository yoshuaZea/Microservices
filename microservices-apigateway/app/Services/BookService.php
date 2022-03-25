<?php

namespace App\Services;

use App\Traits\ConsumeExternalService;

class BookService {

    use ConsumeExternalService;

    /**
     * The base uri to be used to consume the books service
    */
    public $baseUri;

    /**
     * The secret to be used to consume the authors service
    */
    public $secret;

    public function __construct(){
        $this->baseUri = config('services.books.base_uri');
        $this->secret = config('services.books.secret');
    }

    /**
     * Get the full list of books from the books service
     * @return string
     */
    public function obtainBooks(){
        return $this->performRequest('GET', '/books');
    }

    /**
     * Create an books from the books service
     * @return string
     */
    public function createBook($data){
        return $this->performRequest('POST', '/books', $data);
    }

     /**
     * Get an specific book from the books service
     * @return string
     */
    public function obtainBook($id){
        return $this->performRequest('GET', "/books/{$id}");
    }

    /**
     * Update an book from the books service
     * @return string
     */
    public function editBook($data, $id){
        return $this->performRequest('PUT', "/books/$id", $data);
    }

     /**
     * Remove an specific book from the books service
     * @return string
     */
    public function deleteBook($id){
        return $this->performRequest('DELETE', "/books/{$id}");
    }
}
