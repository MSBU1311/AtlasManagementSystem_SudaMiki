<?php
namespace App\Searchs;

use App\Models\Users\User;

class SelectNames implements DisplayUsers{

  public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects){
    // もし空の場合は1,2,3を代入して、空じゃない場合は、その数字を代入する
    if(empty($gender)){
      $gender = ['1', '2', '3'];
    }else{
      $gender = array($gender);
    }

    if(empty($role)){
      $role = ['1', '2', '3', '4'];
    }else{
      $role = array($role);
    }

    // Userモデルのsubjectsメソッドを利用して取得
    $users = User::with('subjects')
    // 取得するものは、入力されたキーワードを利用した$qに当てはまるもの
    ->where(function($q) use ($keyword){
      $q->where('over_name', 'like', '%'.$keyword.'%')
      ->orWhere('under_name', 'like', '%'.$keyword.'%')
      ->orWhere('over_name_kana', 'like', '%'.$keyword.'%')
      ->orWhere('under_name_kana', 'like', '%'.$keyword.'%');
    })
    // 指定しているカラムの値が、選択された項目を含んでいるかどうか
    ->whereIn('sex', $gender)
    ->whereIn('role', $role)
    // 上の名前のカナを基準に昇順降順の選択通りに表示する
    ->orderBy('over_name_kana', $updown)->get();

    return $users;
  }
}
