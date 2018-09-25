<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Repositories\FavoriteRepository;
use App\Topic;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    protected $favoriteRepository;

    public function __construct(FavoriteRepository $favoriteRepository)
    {
        $this->middleware('auth')->except(['index']);
        $this->favoriteRepository = $favoriteRepository;
    }

    public function index(){
        $favorites = Favorite::latest()->get();
        $topics = Topic::all();

        // TODO 分页
        return view('favorite.index',compact('favorites','topics'));
    }

    public function create(){
        return view('favorite.create');
    }

    public function store(Request $request){
        $user = $request->user();

        $topics = $this->favoriteRepository->normalizeTopic($request->get('topics'));

        $data = [
            'title' => $request->get('title'),
            'url' => $request->get('url'),
            'autoTitle' => $request->get('autoTitle'),
            'user_id' => $user->id,
        ];
        $favorite = $this->favoriteRepository->create($data);

        // 多对多关系保存
        $favorite->topics()->attach($topics);
        return redirect()->route('favorite.index');

    }

    public function topic($topic_id){
        // dd($topic_id);
        $topic = Topic::find($topic_id);
        $favorites = $topic->favorites;
        $topics = Topic::all();
        $curTopicId = $topic_id;
        //直接return $favorites就是JSON
        return view('favorite.index',compact('favorites','topics','curTopicId'));
    }
}
