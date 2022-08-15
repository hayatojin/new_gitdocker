@extends('app') <!-- appファイルを親として使うことを宣言 -->

@section('title', '記事一覧') <!-- 親ファイルのyieldと対応 -->

@section('content')
 @include('nav') 
  <div class="container">
  @foreach($articles as $article)
    @include('articles.card') 
  @endforeach
  </div>
@endsection
