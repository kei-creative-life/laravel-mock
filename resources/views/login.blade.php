<form method="POST" action="{{ route('login') }}">
    @csrf
    <input type="email" name="email" required placeholder="メールアドレス">
    <input type="password" name="password" required placeholder="パスワード">
    <button type="submit">ログイン</button>
</form>
<a href="{{ route('signin') }}">新規登録</a>