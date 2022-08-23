<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
       
        $post = Post::create($inputs);
        if(isset($inputs['images'])){
        
            foreach($inputs['images'] as $image){
                $file= $image->file('image');
                $filename= date('YmdHi').$file->getClientOriginalName();
                $file->move(public_path('public/Image'), $filename);
                $data['image']= $filename;
                $post->images()->create([
                    'image' => $data['image'],
                ]);
            }
        }
        return json_encode(array(
            "statusCode"=>200
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $like = Post::find($id)->delete();
        return json_encode(array(
            "statusCode"=>200
        ));
    }
}
