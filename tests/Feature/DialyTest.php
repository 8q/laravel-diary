<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Validator;

use App\User;
use App\Dialy;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DialyTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * 正しいデータのバリデーションは通り、データベースに保存できる
     */
    public function testCorrectData()
    {
        $user = factory(User::class)->create();

        $dialyCols = [
            [
                'user_id' => $user->id,
            ],
            [   
                'user_id' => $user->id,
                'datetime' => '2018-09-02 23:55:00',
                'content' => 'Hello World!',
            ],
            [
                'user_id' => $user->id,
                'datetime' => '2018-09-02',
                'content' => 'こんにちは　世界！',
            ]
        ];

        foreach ($dialyCols as $dialyCol) {
            $dialy = factory(Dialy::class)->make($dialyCol);
            $validator = Validator::make($dialy->toArray(), Dialy::$rules);

            $this->assertFalse($validator->fails());
            $dialy->save();
            $this->assertDatabaseHas("dialies", $dialy->toArray());
        }
    }

    /**
     * 間違ったデータのバリデーションは通らない
     */
    public function testFailureData()
    {
        $user = factory(User::class)->create();

        $dialyCols = [
            [
                'user_id' => 'hogehoge', // idに数字以外を渡している
            ],
            [   
                'user_id' => $user->id,
                'datetime' => '2999:999:010101', // 時間がおかしい
                'content' => 'Hello World!',
            ],
            [
                'user_id' => $user->id,
                'datetime' => '2018-09-02',
                'content' => '', //空文字
            ]
        ];

        foreach ($dialyCols as $dialyCol) {
            $dialy = factory(Dialy::class)->make($dialyCol);
            $validator = Validator::make($dialy->toArray(), Dialy::$rules);
            
            $this->assertTrue($validator->fails());
        }
    }
}
