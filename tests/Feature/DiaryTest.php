<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Validator;

use App\User;
use App\Diary;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DiaryTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * 正しいデータのバリデーションは通り、データベースに保存できる
     */
    public function testCorrectData()
    {
        $user = factory(User::class)->create();

        $diaryCols = [
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

        foreach ($diaryCols as $diaryCol) {
            $diary = factory(Diary::class)->make($diaryCol);
            $validator = Validator::make($diary->toArray(), Diary::$rules);

            $this->assertFalse($validator->fails());
            $diary->save();
            $this->assertDatabaseHas("diaries", $diary->toArray());
        }
    }

    /**
     * 間違ったデータのバリデーションは通らない
     */
    public function testFailureData()
    {
        $user = factory(User::class)->create();

        $diaryCols = [
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

        foreach ($diaryCols as $diaryCol) {
            $diary = factory(Diary::class)->make($diaryCol);
            $validator = Validator::make($diary->toArray(), Diary::$rules);
            
            $this->assertTrue($validator->fails());
        }
    }
}
