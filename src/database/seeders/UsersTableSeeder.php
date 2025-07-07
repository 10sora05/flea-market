<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => '山田 太郎',
            'email' => 'test@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // パスワードはハッシュ化する
            'img' => 'default.png',
            'post' => '東京都新宿区',
            'address' => '西新宿1-1-1',
            'bldg' => 'NSビル',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
