@if ($errors->any()) {{-- エラーメッセージの有無を返す --}}
  <div class="card-text text-left alert alert-danger">
    <ul class="mb-0">
      @foreach($errors->all() as $error) {{-- エラーがあれば、allメソッドで配列を取得し、foreachで回す --}}
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif