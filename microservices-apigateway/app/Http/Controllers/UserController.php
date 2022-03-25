<?php

namespace App\Http\Controllers;

use App\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {

    use ApiResponser;

    public function __construct(){

    }

    /**
     * Return users list.
     *
     * @return Illuminate\Http\Response
     */
    public function index(){

        $users = User::all();

        return $this->validResponse($users);
    }

    /**
     * Create an instance of user.
     *
     * @return Illuminate\Http\Response
     */
    public function store(Request $request){
        // Validation rules
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8|confirmed'
        ];

        // Exec validations
        $this->validate($request, $rules);

        // Hash password
        $fields = $request->all();
        $fields['password'] = Hash::make($request->password);

        // Create a new instance of user
        $user = User::create($fields);

        return $this->validResponse($user, Response::HTTP_CREATED);
    }

    /**
     * Return an specific user.
     *
     * @return Illuminate\Http\Response
     */
    public function show($user){
        // Find an specific user
        $user = User::findOrFail($user);

        return $this->validResponse($user);
    }

    /**
     * Update an specific user.
     *
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $user){
        // Validation rules
        $rules = [
            'name' => 'max:255',
            'email' => "email|max:255|unique:users,email,{$user}",
            'password' => 'min:8|confirmed'
        ];

        // Exec validations
        $this->validate($request, $rules);

        // Find an specific user
        $user = User::findOrFail($user);

        // Fill values from the request to instance of user
        $user->fill($request->all());

        // Hash password only isset
        if($request->has('password')){
            // Hash password
            $request->password = Hash::make($request->password);
        }

        // Verify if there is at least one change
        if($user->isClean()){
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Save changes
        $user->save();

        return $this->validResponse($user);
    }

    /**
     * Remove an specific user.
     *
     * @return Illuminate\Http\Response
     */
    public function destroy($user){
        // Find an specific user
        $user = User::findOrFail($user);

        // Delete from database
        $user->delete();

        return $this->validResponse($user);
    }

    /**
     * Identifies the current user
     *
     * @return Illuminate\Http\Response
     */
    public function me(Request $request){
        return $this->validResponse($request->user());
    }

}
