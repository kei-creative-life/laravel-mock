<form method="POST" action="{{ route('signin') }}">
    @csrf
    <input type="text" name="name" required placeholder="名前">
    <input type="email" name="email" required placeholder="メールアドレス">
    <input type="password" name="password" required placeholder="パスワード">
    <input type="password" name="password_confirmation" required placeholder="パスワード（確認）">
    <button type="submit">サインイン</button>
</form>