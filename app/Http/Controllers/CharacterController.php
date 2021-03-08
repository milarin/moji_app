<?php

namespace App\Http\Controllers;

use App\Http\Requests\CharacterRequest;
use App\Models\Character;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class CharacterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $message = '検索結果：' . $keyword;
            $characters = Character::where('title', 'LIKE', "%{$keyword}%")->orderBy('id', 'desc')->simplePaginate(21);
        } else {
            $message = '';
            // $characters = \DB::table('characters')->orderBy('id', 'desc')->simplePaginate(3);
            $characters = Character::orderBy('id', 'desc')->simplePaginate(21);
        }
        return view('index', ['characters' => $characters, 'message' => $message, 'keyword' => $request->input]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CharacterRequest $request)
    {
        $character = new Character;
        $user = Auth::user();
        $character->title = request('title');
        //image加工
        $uploadImg = $character->image_file = $request->file('image_file');
        $extension = $request->file('image_file')->getClientOriginalExtension();
        $filename = $request->file('image_file')->getClientOriginalName();
        $resize_image = Image::make($uploadImg)->fit(500, 500,  function ($constraint) {
            $constraint->upsize();
        })->encode($extension);
        $path = Storage::disk('s3')->put('/character/'.$filename, (string)$resize_image, 'public');
        $character->image_file = Storage::disk('s3')->url('character/'.$filename);

        $character->user_id = $user->id;
        $character->category_id = 1;
        $character->save();
        return redirect()->route('chara.detail', ['id' => $character->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $character = Character::find($id);
        $user = Auth::user();
        if ($user) {
            $login_user_id = $user->id;
        } else {
            $login_user_id = "";
        }
        return view('show', ['character' => $character, 'login_user_id' => $login_user_id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $character = Character::find($id);
        return view('edit', ['character' => $character]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function update(CharacterRequest $request, $id, Character $character)
    {
        $character = Character::find($id);
        $character->title = request('title');
        if (request('image_file')) {
            $uploadImg = $character->image_file = $request->file('image_file');
            $extension = $request->file('image_file')->getClientOriginalExtension();
            $filename = $request->file('image_file')->getClientOriginalName();
            $resize_image = Image::make($uploadImg)->fit(500, 500,  function ($constraint) {
                $constraint->upsize();
            })->encode($extension);
            $path = Storage::disk('s3')->put('/character/'.$filename, (string)$resize_image, 'public');
            $character->image_file = Storage::disk('s3')->url('character/'.$filename);
        }
        $character->save();
        return redirect()->route('chara.detail', ['id' => $character->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $character = Character::find($id);
        // $deleteimage = $character->image_file;
        // $delete_path = storage_path().'app/public/'.$deleteimage;
        // \File::delete($delete_path);
        $character->delete();
        return redirect('/characters');
    }
}
