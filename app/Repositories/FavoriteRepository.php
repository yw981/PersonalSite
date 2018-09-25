<?php
/**
 * Created by PhpStorm.
 * User: ytc
 * Date: 2018/9/17
 * Time: 下午4:30
 */

namespace App\Repositories;

use App\Favorite;
use App\Question;
use App\Topic;

class FavoriteRepository
{
    /**
     * @param $id
     * @return mixed
     */
    public function byIdWithTopicsAndAnswers($id)
    {
        return Question::where('id',$id)->with(['topics',])->first();
    }

    /**
     * @param array $input
     * @return static
     */
    public function create(array $input)
    {
        if(isset($input['autoTitle'])||!isset($input['title'])){
            $urlContent = file_get_contents($input['url']);
            // TODO 编码问题
            if(strpos($urlContent,'charset=gb2312')!==false||strpos($urlContent,'charset="gb2312"')!==false){
                $urlContent = iconv("gb2312","utf-8//IGNORE",$urlContent);
            }
            elseif(strpos($urlContent,'charset=gbk')!==false||strpos($urlContent,'charset="gbk"')!==false){
                $urlContent = iconv("gbk","utf-8//IGNORE",$urlContent);
                //iconv('UTF-8', 'GBK//IGNORE', unescape(isset($_GET['str'])? $_GET['str']:''));
            }
            $posBegin = strpos($urlContent,'<title>')+7;
            $posEnd = strpos($urlContent,'</title>');
            $length = $posEnd - $posBegin;
            $input['title'] = substr($urlContent,$posBegin,$length);
        }
        return Favorite::create($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function byId($id)
    {
        return Question::find($id);
    }

    /**
     * @return mixed
     */
    public function getQuestionsFeed()
    {
        return Question::published()->latest('updated_at')->with('user')->get();
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

    /**
     * @param array $topics
     * @return array
     */
    public function normalizeTopic($topics)
    {
        if(!isset($topics) || empty($topics)) return [];
        return collect($topics)->map(function ($topic) {
            // 如果是数字，说明是id，已有的topic
            if ( is_numeric($topic) ) {
                // TODO count数量+1
                // Topic::find($topic)->increment('questions_count');
                return (int) $topic;
            }
            // 不是数字，新建话题
            $newTopic = Topic::create(['name' => $topic, 'questions_count' => 1]);
            return $newTopic->id;
        })->toArray();
    }

}