<x-sidebar>
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="w-50 m-auto h-75">
    <p><span>{{ $date }}日</span><span class="ml-3">{{ $part }}部</span></p>
    <div class="h-75 border">
      <table class="">
        <tr class="text-center">
          <th class="w-25">ID</th>
          <th class="w-25">名前</th>
          <th class="w-25">場所</th>
        </tr>
        <!-- その日のそのパート(reserve_setting_id)で予約した人が誰なのか(user_id)を反復表示させる（ここにその人のusersテーブルにある詳細情報は入っていない） -->
        @foreach($reservePersons as $reservePerson)
        <!-- 上の記載で予約したとされる人のusersテーブルの詳細情報を取得する -->
          @foreach($reservePerson->users as $user)
            <tr class="text-center">
              <td class="w-25">{{ $user->id }}</td>
              <td class="w-25">{{ $user->over_name.$user->under_name}}</td>
              <td class="w-25">リモート</td>
            </tr>
          @endforeach
        @endforeach
      </table>
    </div>
  </div>
</div>
</x-sidebar>
