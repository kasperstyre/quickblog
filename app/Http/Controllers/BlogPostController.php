<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogPosts = BlogPost::all()->load('author');

        return response()->json($blogPosts, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'content' => 'required|string|max:250'
        ];

        $messages = [
            'required' => 'REQUIRED',
            'max' => 'LENGTH_EXCEEDED'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $blogPost = BlogPost::create($request->all());

        $author = User::where('name', 'Anonymous')->first();
        $blogPost = $blogPost->author()->associate($author);

        $blogPost->save();

        return response()->json($blogPost, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return \Illuminate\Http\Response
     */
    public function show(BlogPost $blogPost)
    {
        // Author is lazyloaded by default, so we need to load it explicitly
        $blogPost = $blogPost->load('author');

        return response()->json($blogPost);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BlogPost  $blogPost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlogPost $blogPost)
    {
        $rules = [
            'content' => 'required|string|max:250'
        ];

        $messages = [
            'required' => 'REQUIRED',
            'max' => 'LENGTH_EXCEEDED'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $blogPost->update($request->all());

        $blogPost = $blogPost->load('author');

        return response()->json($blogPost, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogPost $blogPost)
    {
        $blogPost->delete();

        return response()->json($blogPost, Response::HTTP_OK);
    }
}
