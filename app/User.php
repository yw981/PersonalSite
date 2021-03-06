<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Mail;
use Naux\Mail\SendCloudTemplate;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'confirmation_token', 'api_token', 'settings'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token){
        // TODO 修改模板，发送人等
        $data = [
            'url' => url('password/reset',$token),
        ];
        $template = new SendCloudTemplate('zhihu_reset_password', $data);

        Mail::raw($template, function ($message){
            $message->from('reset_password@yangtaocun.cn', 'Zhihu');
            $message->to($this->email);
        });
    }

    /**
     * @var array
     */
    protected $casts = [
        'settings' => 'json'
    ];

    /**
     * @return Setting
     */
    public function settings()
    {
        return new Setting($this);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * @param Favorite $favorite
     * @return bool
     */
    public function ownFavorite(Favorite $favorite)
    {
        // PHP是弱类型语言，不支持函数重载，不能owns(不同参数)
        return $this->id == $favorite->user_id;
    }

    /**
     * @param Article $article
     * @return bool
     */
    public function ownArticle(Article $article)
    {
        return $this->id == $article->user_id;
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function follows()
    {
        return $this->belongsToMany(Question::class, 'user_question')->withTimestamps();
    }
    /**
     * @param $question
     * @return array
     */
    public function followThis($question)
    {
        return $this->follows()->toggle($question);
    }
    /**
     * @param $question
     * @return bool
     */
    public function followed($question)
    {
        return !!$this->follows()->where('question_id', $question)->count();
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany(self::class, 'followers', 'follower_id', 'followed_id')->withTimestamps();
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followersUser()
    {
        return $this->belongsToMany(self::class, 'followers', 'followed_id', 'follower_id')->withTimestamps();
    }
    /**
     * @param $user
     * @return array
     */
    public function followThisUser($user)
    {
        return $this->followers()->toggle($user);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function votes()
    {
        return $this->belongsToMany(Answer::class, 'votes')->withTimestamps();
    }
    /**
     * @param $answer
     * @return array
     */
    public function voteFor($answer)
    {
        return $this->votes()->toggle($answer);
    }
    /**
     * @param $answer
     * @return bool
     */
    public function hasVotedFor($answer)
    {
        return !!$this->votes()->where('answer_id', $answer)->count();
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'to_user_id');
    }
}
