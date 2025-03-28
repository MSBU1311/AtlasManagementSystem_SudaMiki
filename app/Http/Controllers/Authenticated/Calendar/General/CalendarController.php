<?php

namespace App\Http\Controllers\Authenticated\Calendar\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\General\CalendarView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\USers\User;
use Auth;
use DB;

class CalendarController extends Controller
{
    public function show(){
        $calendar = new CalendarView(time());
        return view('authenticated.calendar.general.calendar', compact('calendar'));
    }

    public function reserve(Request $request){
        // 複数のデータベースの処理をまとめて行う
        DB::beginTransaction();
        try{
            $getPart = $request->getPart;
            $getDate = $request->getData;
            // array_filtler：null要素を廃止,array_combine($getDate=>$getPart)の連想配列
            $reserveDays = array_filter(array_combine($getDate, $getPart));
            foreach($reserveDays as $key => $value){
                // 指定された日付と時間帯を取得する
                $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();
                // limit_usersを１減らす
                $reserve_settings->decrement('limit_users');
                // 予約設定と認証済みユーザーを関連付ける
                $reserve_settings->users()->attach(Auth::id());
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }

public function delete(Request $request)
{
    DB::beginTransaction();
    try {
        $reserve_id = $request->input('reserve_id');

        $reserve_settings = ReserveSettings::find($reserve_id);

        if (!$reserve_settings) {
            return redirect()->back()->with('error', '予約が見つかりませんでした。');
        }

        $reserve_settings->users()->detach(Auth::id());
        $reserve_settings->increment('limit_users');

        DB::commit();
        return redirect()->back()->with('success', '予約をキャンセルしました。');
    } catch (\Exception $e) {
        DB::rollback();
        return redirect()->back()->with('error', '予約キャンセル中にエラーが発生しました。');
    }
}
}
