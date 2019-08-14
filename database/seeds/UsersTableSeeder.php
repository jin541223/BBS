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
    public function run()
    {
        // 获取 facker 实例
        $faker = app(Faker\Generator::class);

        $avatars = [
            'https://avatars3.githubusercontent.com/u/2994718?s=460&v=4',
            'https://cdn.learnku.com/uploads/images/201710/14/1/Lhd1SHqu86.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/LOnMrqbHJn.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/xAuDMxteQy.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/NDnzMutoxX.png',
        ];

        $users = factory(User::class)
            ->times(10)
            ->make()
            ->each(function ($user, $index) use ($faker, $avatars) {
                $user->avatar = $faker->randomElement($avatars);
            });
        // 让隐藏字段课件将数据集合转换为数组
        $userArr = $users->makeVisible(['password', 'remember_token'])->toArray();
        User::insert($userArr);

        $user = User::find(1);
        $user->name = 'cici';
        $user->email = '474638401@qq.com';
        $user->avatar = 'https://avatars3.githubusercontent.com/u/2994718?s=460&v=4';
        $user->save();
    }
}
