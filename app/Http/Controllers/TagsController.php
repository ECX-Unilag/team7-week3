<?php

namespace App\Http\Controllers;
use App\Tag;
use Illuminate\Support\Facades\DB;




use Illuminate\Http\Request;
use App\Http\Requests\Tags\CreateTagRequest;
use App\Http\Requests\Tags\UpdateTagRequest;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tag.index')->with('tags', Tag::all())->with('tag', '');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tag.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTagRequest $request)
    {
        $data = request()->all();
        $tags = new Tag();
        $tags->name = $data['name'];
        $tags->save();
        session()->flash('success', 'new Tag has been added');
        return redirect('/tag');
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
    public function edit(Tag $tag)
    {
        return view('tag.create')->with('tags',$tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $data = request()->all();
       
        
        //  DB::table('tags')
        //       ->where('id', $tag)
        //       ->update(['name' => ' developmeAndroidnt']);

        //    DB::table('tags') ->where('id', $tag) ->limit(1) 
        //       ->update( [ 'name' => ['developmeAndroidnt'] ]); 
            
             $tag->name = $data['name'];
             $tag->update();

              session()->flash('success', 'Tag has been updated');
             return redirect()->back();
              
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        // if($tag->posts->count() > 0)
        // {
        //     session()->flash('error', 'Tag can not been deleted'); 
        //     return redirect()->back();
        // }
        $tag->delete();
        session()->flash('success', 'Tag has been delelted');
        return redirect('/tag');
    }
}
