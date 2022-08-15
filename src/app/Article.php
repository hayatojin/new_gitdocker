<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    protected $fillable = [
        'title',
        'body',
    ];
    
    // userモデルと関連づけるための記述
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\User');
    }

    // 「いいね」における記事モデルとユーザーモデルの関係は多対多
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany('App\User', 'likes')->withTimestamps();
    }

    // あるユーザーがいいね済みかどうかを判定する
    public function isLikedBy(?User $user): bool //?をつけることで、userモデルのnullを許可してる
    {
        return $user
            ? (bool)$this->likes->where('id', $user->id)->count() //記事（this）モデルからいいねモデルを参照し、whereメソッドでlikesモデルに入ったuser_idを取得している
            : false;
    }

    public function getCountLikesAttribute(): int
    {
        return $this->likes->count();
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }
}
