<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function allItems()
    {
        $items = Item::all();
       
        if(sizeof($items) == 0)
        {
            return response()->json(['error'=>"No hay productos"],404);
        }else{
            return response()->json(['items'=>$items],200);
        } 

       
    }
}
