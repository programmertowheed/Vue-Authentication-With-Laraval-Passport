<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $blogs = Blog::orderBy('id', 'DESC')->get();
        if($blogs){
            return sendResponse('success', BlogResource::collection($blogs));
        }else{
            return sendError('Data not found', []);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "title"       => "required|min:10|max:255",
            "description" => "required|min:20"
        ]);

        if($validator->fails()){
            return sendError('Validation Error', $validator->errors(),422);
        }

        try {
            $blog = Blog::create([
                'title'    => $request->title,
                'description'    => $request->description
            ]);

            return sendResponse('Blog create successful', new BlogResource($blog));

        }catch (Exception $e){
            return sendError('Something wrong', []);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $blog = Blog::find($id);
        if($blog){
            return sendResponse('success', new BlogResource($blog));
        }else{
            return sendError('Data not found', []);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            "title"       => "required|min:10|max:255",
            "description" => "required|min:20"
        ]);

        if($validator->fails()){
            return sendError('Validation Error', $validator->errors(),422);
        }

        try {
            $blog = Blog::find($id);
            if($blog){
                $blog->title       = $request->title;
                $blog->description = $request->description;
                $blog->save();
                return sendResponse('Blog update successful', new BlogResource($blog));
            }else{
                return sendError('Data not found', []);
            }
        }catch (Exception $e){
            return sendError('Something wrong', []);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $blog = Blog::find($id);
            if($blog){
                $blog->delete();
            }
            return sendResponse('Blog deleted successfully');
        }catch (Exception $e){
            return sendError('Something wrong', []);
        }
    }
}
