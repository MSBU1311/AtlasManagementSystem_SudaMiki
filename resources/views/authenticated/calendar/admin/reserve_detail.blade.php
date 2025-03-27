<x-sidebar>
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="w-50 m-auto h-75">
    <!-- parse($date)：Carbonライブラリが扱える日付データに変換 -->
    <p><span>{{ \Carbon\Carbon::parse($date)->format('Y年m月d日') }}</span><span class="ml-3">{{ $part }}部</span></p>
    <div class="reserve_detail">
      <table class="table table-striped">
        <thead>
          <tr class="detail_list">
            <th style="text-align: center;">ID</th>
            <th style="text-align: center;">名前</th>
            <th style="text-align: center;">場所</th>
          </tr>
        </thead>
        <tbody style="padding-left: 20px;">
          <!-- その日のそのパート(reserve_setting_id)で予約した人が誰なのか(user_id)を反復表示させる（ここにその人のusersテーブルにある詳細情報は入っていない） -->
          @foreach($reservePersons as $reservePerson)
          <!-- 上の記載で予約したとされる人のusersテーブルの詳細情報を取得する -->
            @foreach($reservePerson->users as $user)
              <tr class="detail_list">
                <td style="text-align: center;">{{ $user->id }}</td>
                <td style="text-align: center;">{{ $user->over_name.$user->under_name}}</td>
                <td style="text-align: center;">リモート</td>
              </tr>
            @endforeach
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
</x-sidebar>
