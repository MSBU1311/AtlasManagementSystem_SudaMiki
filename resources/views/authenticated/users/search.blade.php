<x-sidebar>
<div class="search_content w-100 d-flex">
  <div class="reserve_users_area">
    @foreach($users as $user )
    <div class="border one_person">
      <div>
        <span style="color: #9E9E9E;">ID : </span><span>{{ $user->id }}</span>
      </div>
      <div>
        <span style="color: #9E9E9E;">名前 : </span>
        <a href="{{ route('user.profile', ['id' => $user->id]) }}">
          <span>{{ $user->over_name }}</span>
          <span>{{ $user->under_name }}</span>
        </a>
      </div>
      <div>
        <span style="color: #9E9E9E;">カナ : </span>
        <span>({{ $user->over_name_kana }}</span>
        <span>{{ $user->under_name_kana }})</span>
      </div>
      <div>
        @if($user->sex == 1)
        <span style="color: #9E9E9E;">性別 : </span><span>男</span>
        @elseif($user->sex == 2)
        <span style="color: #9E9E9E;">性別 : </span><span>女</span>
        @else
        <span style="color: #9E9E9E;">性別 : </span><span>その他</span>
        @endif
      </div>
      <div>
        <span style="color: #9E9E9E;">生年月日 : </span><span>{{ $user->birth_day }}</span>
      </div>
      <div>
        @if($user->role == 1)
        <span style="color: #9E9E9E;">権限 : </span><span>教師(国語)</span>
        @elseif($user->role == 2)
        <span style="color: #9E9E9E;">権限 : </span><span>教師(数学)</span>
        @elseif($user->role == 3)
        <span style="color: #9E9E9E;">権限 : </span><span>講師(英語)</span>
        @else
        <span style="color: #9E9E9E;">権限 : </span><span>生徒</span>
        @endif
      </div>
      <div>
        @if($user->role == 4)
          <span style="color: #9E9E9E;">選択科目 :
            <!-- userモデルの中の、subjectメソッドのリレーションを呼び出して、その値を$subjectに代入する -->
            @foreach($user->subjects as $subject)
            {{ $subject->subject}}
            @endforeach
          </span>
        @endif
      </div>
    </div>
    @endforeach
  </div>
  <div class="search_area w-25">
    <div class="">
      <div class="search_box">
        <lavel class="kye_word" style="font-size: 20px; color: #4C5F7B;">検索</lavel>
        <input type="text" class="free_word" name="keyword" placeholder="キーワードを検索" form="userSearchRequest">
      </div>
      <div class="search_box">
        <lavel style="color: #4C5F7B;">カテゴリ</lavel>
        <select class="category" form="userSearchRequest" name="category">
          <option value="name">名前</option>
          <option value="id">社員ID</option>
        </select>
      </div>
      <div class="search_box">
        <label style="color: #4C5F7B;">並び替え</label>
        <select class="updown" name="updown" form="userSearchRequest">
          <option value="ASC">昇順</option>
          <option value="DESC">降順</option>
        </select>
      </div>
      <div class="search_container">
        <p class="m-0 search_conditions"><span style="color: #4C5F7B;">検索条件の追加</span><span class="arrow">&#8744;</span></p>
        <div class="search_conditions_inner">
          <div class="sex_box">
            <label style="color: #4C5F7B; margin:0;">性別</label>
            <div>
              <span>男</span><input type="radio" name="sex" value="1" form="userSearchRequest">
              <span>女</span><input type="radio" name="sex" value="2" form="userSearchRequest">
              <span>その他</span><input type="radio" name="sex" value="3" form="userSearchRequest">
            </div>
          </div>
          <div class="role_search">
            <label style="color: #4C5F7B; margin:0;">権限</label>
            <select name="role" form="userSearchRequest" class="engineer">
              <option selected disabled>----</option>
              <option value="1">教師(国語)</option>
              <option value="2">教師(数学)</option>
              <option value="3">教師(英語)</option>
              <option value="4" class="">生徒</option>
            </select>
          </div>
          <div class="selected_engineer">
            <label style="color: #4C5F7B; margin:0;">選択科目</label>
            <div class="subject_inner">
              @foreach($subjects as $subject )
                <span>{{$subject->subject}}</span>
                <input type="checkbox" name="subject[]" value="{{$subject->id}}" form="userSearchRequest"><br>
              @endforeach
            </div>
          </div>
        </div>
      </div>
      <div>
        <input class="new_create btn btn-primary" style="background: #4CA7CE; border-color: #4CA7CE;" type="submit" name="search_btn" value="検索" form="userSearchRequest">
      </div>
      <div>
        <input class="search_reset" type="reset" value="リセット" form="userSearchRequest">
      </div>
    </div>
    <form action="{{ route('user.show') }}" method="get" id="userSearchRequest"></form>
  </div>
</div>
</x-sidebar>
