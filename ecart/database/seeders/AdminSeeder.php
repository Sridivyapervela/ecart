<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin=new User([
            'first_name'=>"sri",
         	'last_name' => "divya",
            'email' => 'sridivyapervela357@gmail.com',
            'password' =>Hash::make('password1'), // password
            'remember_token' => Str::random(10),
            'role'=>'admin',
        ]);
        $admin->save();
    }
}
