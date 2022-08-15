<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    // fillableに値をセットする理由：firstOrCreateメソッドを使って、タグモデルのnameプロパティに値をセットした上でタグモデルを保存することを可能にするため
    protected $fillable = [
        'name',
    ];

    // タグに、ハッシュタグのアクセサをつける
    public function getHashtagAttribute(): string
    {
        return '#' . $this->name;
    }

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany('App\Article')->withTimestamps();
    }
}
