<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use App\Http\Resources\UserResource;
use App\Packages\Cart\Domain\CartFactoryInterface;
use App\Packages\Cart\Domain\CartRepositoryInterface;
use App\Packages\Cart\Usecase\CartCreateAction;
use App\Packages\Cart\Usecase\CartGetAction;
use Illuminate\Http\Request;


class CartController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CartRepositoryInterface $cartRepositoryInterface, CartFactoryInterface $cartFactoryInterface)
    {
        // 
        $cartCreateAction = new CartCreateAction($cartRepositoryInterface, $cartFactoryInterface);
        $cartData = $cartCreateAction($request->input('userId'));
        return new CartResource($cartData);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, CartRepositoryInterface $cartRepositoryInterface)
    {
        $cartGetAction = new CartGetAction($cartRepositoryInterface);
        $cartData = $cartGetAction($id);
        return new CartResource($cartData);
    }
}
