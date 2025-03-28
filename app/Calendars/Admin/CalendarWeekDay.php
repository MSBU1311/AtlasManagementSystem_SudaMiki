<?php
namespace App\Calendars\Admin;

use Carbon\Carbon;
use App\Models\Calendars\ReserveSettings;

// カレンダーの日を出力する部分

class CalendarWeekDay{
  protected $carbon;

  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  // cssを当てることができるようにクラス名を出力
  // format("D")が、Sun、Monなどの曜日を省略形式で取得できる
  function getClassName(){
    return "day-" . strtolower($this->carbon->format("D"));
  }

  // カレンダーの日の内部を出力
  function render(){
    // format("j")が、先頭に０をつけない日付を取得
    return '<p class="day">' . $this->carbon->format("j") . '日</p>';
  }

  function everyDay(){
    return $this->carbon->format("Y-m-d");
  }

  // スクール予約確認
  function dayPartCounts($ymd){
    $html = [];
    $one_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '1')->first();
    $two_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '2')->first();
    $three_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '3')->first();

    $html[] = '<div class="text-left">';
    if($one_part){
      $date = $this->carbon->format("Y-m-d");
      $part = 1;
      $url = route('calendar.admin.detail', ['date' => $date, 'part' => $part]);
      $reservePersons = ReserveSettings::with('users')->where('setting_reserve', $date)->where('setting_part', $part)->get();
      foreach ($reservePersons as $reservePerson) {
        $userCount = $reservePerson->users()->get()->count();
        $text = '<span style="margin-left: 10px;">' . $userCount . '</span>';
        $date = Carbon::parse('' . $date . '');
        $weekDay = $date->format('D');
        $weekDayClass = 'day-' . strtolower($weekDay);
        $html[] = '<p class="day_part m-0 pt-1"><a href="' . $url . '" class="' . $weekDayClass . '">1部</a>' . $text . '</p>';
      }
    }
    if($two_part){
      $date = $this->carbon->format("Y-m-d");
      $part = 2;
      $url = route('calendar.admin.detail', ['date' => $date, 'part' => $part]);
      $reservePersons = ReserveSettings::with('users')->where('setting_reserve', $date)->where('setting_part', $part)->get();
      foreach ($reservePersons as $reservePerson) {
      $userCount = $reservePerson->users()->get()->count();
      $text = '<span style="margin-left: 10px;">' . $userCount . '</span>';
      $date = Carbon::parse('' . $date . '');
      $weekDay = $date->format('D');
      $weekDayClass = 'day-' . strtolower($weekDay);
      $html[] = '<p class="day_part m-0 pt-1"><a href="' . $url . '"class="' . $weekDayClass . '">2部</a>' . $text . '</p>';}
    }
    if($three_part){
      $date = $this->carbon->format("Y-m-d");
      $part = 3;
      $url = route('calendar.admin.detail', ['date' => $date, 'part' => $part]);
      $reservePersons = ReserveSettings::with('users')->where('setting_reserve', $date)->where('setting_part', $part)->get();
      foreach ($reservePersons as $reservePerson) {
      $userCount = $reservePerson->users()->get()->count();
      $text = '<span style="margin-left: 10px;">' . $userCount . '</span>';
      $date = Carbon::parse('' . $date . '');
      $weekDay = $date->format('D');
      $weekDayClass = 'day-' . strtolower($weekDay);
      $html[] = '<p class="day_part m-0 pt-1"><a href="' . $url . '"class="' . $weekDayClass . '">3部</a>' . $text . '</p>';}
    }
    $html[] = '</div>';

    return implode("", $html);
  }


  function onePartFrame($day){
    $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first();
    if($one_part_frame){
      $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first()->limit_users;
    }else{
      $one_part_frame = "20";
    }
    return $one_part_frame;
  }
  function twoPartFrame($day){
    $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first();
    if($two_part_frame){
      $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first()->limit_users;
    }else{
      $two_part_frame = "20";
    }
    return $two_part_frame;
  }
  function threePartFrame($day){
    $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first();
    if($three_part_frame){
      $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first()->limit_users;
    }else{
      $three_part_frame = "20";
    }
    return $three_part_frame;
  }

  //
  function dayNumberAdjustment(){
    $html = [];
    $html[] = '<div class="adjust-area">';
    $html[] = '<p class="d-flex m-0 p-0">1部<input class="w-25" style="height:20px;" name="1" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">2部<input class="w-25" style="height:20px;" name="2" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">3部<input class="w-25" style="height:20px;" name="3" type="text" form="reserveSetting"></p>';
    $html[] = '</div>';
    return implode('', $html);
  }

    protected function getWeeks(){
    $weeks = [];
    $firstDay = $this->carbon->copy()->firstOfMonth();
    $lastDay = $this->carbon->copy()->lastOfMonth();
    $week = new CalendarWeek($firstDay->copy());
    $weeks[] = $week;
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
    while($tmpDay->lte($lastDay)){
      $week = new CalendarWeek($tmpDay, count($weeks));
      $weeks[] = $week;
      $tmpDay->addDay(7);
    }
    return $weeks;
  }
}
