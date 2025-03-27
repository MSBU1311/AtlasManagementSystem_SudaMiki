<x-guest-layout>
  <form action="{{ route('loginPost') }}" method="POST">
    <div class="w-100 vh-100 d-flex" style="align-items:center; justify-content:center; flex-direction: column;">
      <img class="Atlas_logo"src="/image/atlas-black.png" alt="Atlasロゴ"></br>
      <div class="login_content border vh-50 w-25">
        <div class="w-75 m-auto pt-5">
          @if ($errors->has('mail_address'))
            <span class="error_message">{{ $errors->first('mail_address') }}</span>
          @endif
          <label class="d-block m-0" style="font-size:13px;">メールアドレス</label>
          <div class="border-bottom border-primary w-100">
            <input type="text" class="w-100 border-0" name="mail_address">
          </div>
        </div>
        <div class="w-75 m-auto pt-5">
          @if ($errors->has('password'))
            <span class="error_message">{{ $errors->first('password') }}</span>
          @endif
          <label class="d-block m-0" style="font-size:13px;">パスワード</label>
          <div class="border-bottom border-primary w-100">
            <input type="password" class="w-100 border-0" name="password">
          </div>
        </div>
        <div class="text-right m-3">
          <input type="submit" class="btn btn-primary" value="ログイン">
        </div>
        <div class="text-center">
          <a href="{{ route('registerView') }}">新規登録はこちら</a>
        </div>
      </div>
      {{ csrf_field() }}
    </div>
  </form>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="{{ asset('js/register.js') }}" rel="stylesheet"></script>
</x-guest-layout>
