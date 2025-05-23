<?php
namespace App\Calendars\General;

use Carbon\Carbon;
use Auth;

class CalendarView{

  private $carbon;
  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  public function getTitle(){
    return $this->carbon->format('Y年n月');
  }

  function render(){
    $html = [];
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th>月</th>';
    $html[] = '<th>火</th>';
    $html[] = '<th>水</th>';
    $html[] = '<th>木</th>';
    $html[] = '<th>金</th>';
    $html[] = '<th class="day-sat">土</th>';
    $html[] = '<th class="day-sun">日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';
    $weeks = $this->getWeeks();
    foreach($weeks as $week){
      $html[] = '<tr class="'.$week->getClassName().'">';

      $days = $week->getDays();
      foreach($days as $day){
        $startDay = $this->carbon->copy()->format("Y-m-01");
        $toDay = $this->carbon->copy()->format("Y-m-d");

        // 今日以前〜今日までの場合
        if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
          // グレーアウトする
          $html[] = '<td class="past-day border calendar-td '.$day->getClassName().'">';
        }else{
          $html[] = '<td class="calendar-td '.$day->getClassName().'">';
        }
        // カレンダーの日付を取得
        $html[] = $day->render();

        // 今日以前〜今日までの場合
        if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
          if(in_array($day->everyDay(), $day->authReserveDay())){
            $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;
            if($reservePart == 1){
              $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px; color: black;">1部参加</p>';
            }else if($reservePart == 2){
              $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px; color: black;">2部参加</p>';
            }else if($reservePart == 3){
              $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px; color: black;">3部参加</p>';
            }
          }else{
          // 受付終了を表示
          $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px; color: black;">受付終了</p>';
          }
        // それ以外の場合
        }else{
        if(in_array($day->everyDay(), $day->authReserveDay())){
          $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;
          if($reservePart == 1){
            $reservePart = "リモ1部";
          }else if($reservePart == 2){
            $reservePart = "リモ2部";
          }else if($reservePart == 3){
            $reservePart = "リモ3部";
          }
          if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
            $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px"></p>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          }else{

            $html[] = '<input
            type="hidden"
            name="getPart[]" value="' . $day->getReserveSettingId($day->everyDay()) .'"
            form="reserveParts">';

            // 対象の日付・部数・reserve_settingsのidをそれぞれ格納してJSに送る
            // ?条件がtrueの時に実行、：条件がfalseの場合に実行
            $html[] = '<button
              type="submit"
              class="delete-modal-open btn btn-danger p-0 w-75"
              name="delete_date"
              style="font-size:12px"
              data-date=" '. $day->everyDay() .'"
              data-part="'. $reservePart .'"
              data-reserve-id="' . ($day->authReserve($day->everyDay()) ? $day->authReserve($day->everyDay())->id : null) . '">
              '. $reservePart .'</button>';
          }
        }else{
          $html[] = $day->selectPart($day->everyDay());
        }
        $html[] = $day->getDate();
        $html[] = '</td>';
      }
    }
      $html[] = '</tr>';
    }
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';
    $html[] = '<form action="/reserve/calendar" method="post" id="reserveParts">'.csrf_field().'</form>';
    $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">'.csrf_field().'</form>';

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
