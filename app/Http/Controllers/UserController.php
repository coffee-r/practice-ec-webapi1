<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Packages\User\Usecase\UserGetAction;
use App\Packages\User\Usecase\UserRegisterAction;
use App\Packages\User\Usecase\UserRegisterCommand;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, UserRegisterAction $userRegisterAction)
    {
        $userRegisterCommand = new UserRegisterCommand(
            $request->input('name'),
            $request->input('nameFurigana'),
            $request->input('gender'),
            $request->input('birthdayYear'),
            $request->input('birthdayMonth'),
            $request->input('email'),
            $request->input('password'),
            $request->input('postalCode'),
            $request->input('addressPrefectures'),
            $request->input('addressMunicipalities'),
            $request->input('addressOthers'),
            $request->input('tel'),
            $request->input('emailMagazineSubscription'),
        );
        
        $userRegisterAction($userRegisterCommand);
        echo 'aaa';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, UserGetAction $userGetAction)
    {
        $userData = $userGetAction($id);
        var_dump($userData) ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}