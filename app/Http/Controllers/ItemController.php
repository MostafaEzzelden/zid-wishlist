<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Models\Item;
use Illuminate\Http\Response;
use App\Http\Resources\ItemResource;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();

        return new Response(['items' => ItemResource::collection($items),]);
    }

    public function store(ItemRequest $request)
    {
        $item = Item::create($request->only(['name', 'price', 'url', 'description']));

        return new Response(['item' => new ItemResource($item)]);
    }

    public function show(Item $item)
    {
        return new Response(['item' => new ItemResource($item)]);
    }

    public function update(ItemRequest $request, Item $item)
    {
        $item->name = $request->get('name');
        $item->url = $request->get('url');
        $item->price = $request->get('price');
        $item->description = $request->get('description');
        
        $item->save();

        return new Response(['item' => new ItemResource($item)]);
    }
}
