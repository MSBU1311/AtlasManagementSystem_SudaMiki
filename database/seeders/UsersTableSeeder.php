<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['over_name'=>'須田',
            'under_name'=>'実紀',
            'over_name_kana'=>'スダ',
            'under_name_kana'=>'ミキ',
            'mail_address'=>'miki@atlas',
            'sex'=>'2',
            'birth_day'=>'2010/6/1',
            'role'=>'4',
            'password'=>Hash::make('mikimiki'),
            'created_at'=>'2025-03-15 10:44:48',
            'updated_at'=>'2025-03-15 10:44:48'],
            ['over_name'=>'佐藤',
            'under_name'=>'花子',
            'over_name_kana'=>'サトウ',
            'under_name_kana'=>'ハナコ',
            'mail_address'=>'hanako@atlas',
            'sex'=>'3',
            'birth_day'=>'2009/4/3',
            'role'=>'1',
            'password'=>Hash::make('hanakohanako'),
            'created_at'=>'2025-03-15 10:44:48',
            'updated_at'=>'2025-03-15 10:44:48'],
            ['over_name'=>'田中',
            'under_name'=>'優希',
            'over_name_kana'=>'タナカ',
            'under_name_kana'=>'ユウキ',
            'mail_address'=>'yuki@atlas',
            'sex'=>'1',
            'birth_day'=>'2021/12/26',
            'role'=>'2',
            'password'=>Hash::make('yukiyuki'),
            'created_at'=>'2025-03-15 10:44:48',
            'updated_at'=>'2025-03-15 10:44:48'],
        ]);
    }
}
