<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Packages\Catalog\Usecase\ProductGetAction;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, ProductGetAction $procuctGetAction)
    {
        $productData = $procuctGetAction($id);
        return new ProductResource($productData);
    }
}
