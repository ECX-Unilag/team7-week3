<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Posts\CreatePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Post;
use App\Category;
use App\Tag;
use App\User;
use App\Http\Middleware\VerifyCatgoryCount;





class PostController extends Controller
{
    public function __construct(){
        $this->middleware('VerifyCategoryCount')->only(['create', 'store']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // var_dump( Post::all());
        return view('post.index')->with('posts', Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    
        return view('post.create')->with('categories', Category::all())->with('post','')
        ->with('tags', Tag::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {

   
       
    
         //upload image
         $image = $request->image->store('posts');
       
      // store data 
      $post =  Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'content'=> $request->content,
            'category_id'=>$request->category,
            'publish_at'=> $request->publish_at,
            'user_id' => auth()->user()->id,
            'image'=>$image

        ]);
        // $tag = Tag::find(['tag[]']);
        // $post->tags()->attach($post);
        // $category = Category::find([3, 4]);
        // $product->categories()->attach($category);
       
            $post->tags()->attach($request->tag);
        
        // $user->roles()->attach($roleIds);
        // if($request->tags){
        //     $post->tags()->sync($request->$tags);
        // }
       
        //    // store data
        // $post->title =$data['title'];
        // $post->description =$data['description'];
        // $post->content = $data['content'];
        // $post->publish_at = $data['publish_at'];
        // $post->$image ;

    
        //flash messages
        session()->flash('success','data successfully stored');
        //redirect
        return redirect(route('post.index'));
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
    public function edit(Post $post)
    {
        return view('post.create', compact('posts'))->with('posts',$post)->with('categories', Category::all())
        ->with('tags', Tag::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = request()->all();
        if ($request->hasFile('image')){
            $image = $request->image->store('posts');
            Storage::delete($post->image);
            $data['image'] = $image;
        }
            $post->title = $data['title'];
            $post->description =$data['description'];
            $post->content = $data['content'];
            $post->category_id= $data['category'];
            $post->publish_at = $data['publish_at']; 

            
            if($request->tags){
                $post->tags()->sync($request->$tags);
            }
            $post->update();


            session()->flash('success', 'post successfully updated');

            return redirect('/post');
        


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posts =Post::withTrashed()->where('id', $id)->first();
        if($posts->trashed()){

        $posts->forceDelete();
        Storage::delete($posts->image);
        }
        else{

        $posts->delete();
        }

        session()->flash('success','post succesfully deleted');
        return redirect('/post');
    }

    public function trashed()
    {
        $trashed = Post::onlyTrashed()->get();
        return view('post.index')->with('posts', $trashed);
    } 
}
