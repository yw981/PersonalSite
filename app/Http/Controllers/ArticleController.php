<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Markdown\Markdown;
use App\Repositories\ArticleRepository;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{

    protected $articleRepository;
    protected $markdown;

    public function __construct(ArticleRepository $articleRepository,Markdown $markdown)
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->articleRepository = $articleRepository;
        $this->markdown = $markdown;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = $this->articleRepository->getArticlesFeed();
        return view('article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('article.create');
    }

    public function markdownCreate()
    {
        return view('article.create_markdown');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ArticleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        $topics = $this->articleRepository->normalizeTopic($request->get('topics'));

        // dd($request->all());
        $data = [
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'user_id' => $request->user()->id,
        ];
        $article = $this->articleRepository->create($data);
        // 多对多关系保存
        $article->topics()->attach($topics);
        return redirect()->route('article.show',[$article->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = $this->articleRepository->byId($id);
        // dd($article);
        return view('article.show',compact('article'));
    }

    public function markdownShow($id)
    {
        $article = $this->articleRepository->byId($id);
        $html = $this->markdown->markdown($article->body);
        return view('article.show_markdown',compact('article','html'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = $this->articleRepository->byId($id);
        if ( Auth::user()->ownArticle($article) ) {
            return view('article.edit', compact('article'));
        }
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ArticleRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, $id)
    {
        $article = $this->articleRepository->byId($id);
        $topics = $this->articleRepository->normalizeTopic($request->get('topics'));
        $article->update([
            'title' => $request->get('title'),
            'body'  => $request->get('body'),
        ]);
        $article->topics()->sync($topics);
        return redirect()->route('article.show', [$article->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = $this->questionRepository->byId($id);
        if ( Auth::user()->owns($question) ) {
            $question->delete();
            return redirect('/');
        }
        abort(403, 'Forbidden'); // return back();
    }

}
