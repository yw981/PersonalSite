<?php
/**
 * Created by PhpStorm.
 * User: ytc
 * Date: 2018/9/17
 * Time: 下午4:30
 */

namespace App\Repositories;

use App\Article;

class ArticleRepository
{
    use NormalizeTopic;

    /**
     * @param $id
     * @return mixed
     */
//    public function byIdWithTopicsAndComments($id)
//    {
//        return Article::where('id',$id)->with(['topics',])->first();
//    }

    /**
     * @param array $input
     * @return static
     */
    public function create(array $input)
    {
        return Article::create($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function byId($id)
    {
        return Article::find($id);
    }

    /**
     * @return mixed
     */
    public function getArticlesFeed()
    {
        // 调用Model的scope
        return Article::published()->latest('updated_at')->get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getQuestionCommentsById($id)
    {
        $question = Question::with('comments','comments.user')->where('id',$id)->first();
        return $question->comments;
    }

}