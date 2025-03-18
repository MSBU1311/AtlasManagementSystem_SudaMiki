<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    // ...$roles: ...はPHPの可変長引数演算子。複数の引数を配列として受け取る。
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // ログインユーザーが、許可されたrole（1,2,3）に含まれない(in_array)場合、403エラー
        // 上記で取得している$rolesの値がログインユーザーのroleと一致するかどうかをチェック
        if (!in_array(Auth::user()->role,$roles)){
            abort(403,'アクセス権限がありません');
        }

        return $next($request);
    }
}
