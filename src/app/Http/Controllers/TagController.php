<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;

class TagController extends Controller
{
    public function show(string $name) // ルーティングに定義した、URL/tags/{name}の{name}の部分に入った文字列が渡ってくる
    {
        $tag = Tag::where('name',$name)->first(); 
        return view('tags.show', ['tag' => $tag]);
    }
}
