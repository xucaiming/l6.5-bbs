<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
//        $faker = app(\Faker\Generator::class);

        $avatars = [
            'https://ss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=2188301108,2208747323&fm=26&gp=0.jpg',
            'https://ss0.bdstatic.com/70cFvHSh_Q1YnxGkpoWK1HF6hhy/it/u=1076168490,3117261774&fm=26&gp=0.jpg',
            'https://ss1.bdstatic.com/70cFvXSh_Q1YnxGkpoWK1HF6hhy/it/u=3974834430,2578081919&fm=26&gp=0.jpg',
            'https://ss1.bdstatic.com/70cFuXSh_Q1YnxGkpoWK1HF6hhy/it/u=1334953102,2491427455&fm=26&gp=0.jpg',
            'https://ss0.bdstatic.com/70cFuHSh_Q1YnxGkpoWK1HF6hhy/it/u=3136075639,3338708347&fm=26&gp=0.jpg',
            'https://ss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=3393805308,1492477291&fm=26&gp=0.jpg',
            'https://ss1.bdstatic.com/70cFuXSh_Q1YnxGkpoWK1HF6hhy/it/u=2717062052,3164034025&fm=26&gp=0.jpg',
            'https://ss0.bdstatic.com/70cFvHSh_Q1YnxGkpoWK1HF6hhy/it/u=4090061760,3566002114&fm=26&gp=0.jpg',
            'https://ss2.bdstatic.com/70cFvnSh_Q1YnxGkpoWK1HF6hhy/it/u=1226778478,3432630272&fm=26&gp=0.jpg',
            'https://ss1.bdstatic.com/70cFvXSh_Q1YnxGkpoWK1HF6hhy/it/u=1897589137,2261370756&fm=26&gp=0.jpg',
        ];

        // 生成数据集合
        $users = factory(User::class)
                    ->times(10)
                    ->make()
                    ->each(function($user, $index) use ($faker, $avatars){
                        // $user->avatar = $faker->randomElement($avatars);
                        $user->avatar = $avatars[$index];
                    });

        // 让隐藏字段可见，并将数据集合转换成数组
        $users_array = $users->makeVisible(['password', 'remember_token'])->toArray();
        User::insert($users_array);

        $user = User::find(1);
        $user->name = 'Sam';
        $user->email = 'sam@to6c.com';
        $user->save();

        $user->assignRole('Founder');// 初始化用户角色，将 1 号用户指派为『站长』

        $user = User::find(2);
        $user->name = 'Song';
        $user->email = '1003356845@qq.com';
        $user->save();
        $user->assignRole('Maintainer');// 将 2 号用户指派为『管理员』
    }
}
