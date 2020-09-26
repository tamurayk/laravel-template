<?php
declare(strict_types=1);

namespace Tests\Traits;

use App\Http\Requests\Interfaces\FormRequestInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

trait ValidationTestTrait
{
    public function validationTestDataProvider()
    {
        return [
            /**
             * // テストデータの概要
             * '正常' => [
             *
             *   // テスト対象: formRequest
             *   'formRequest' => new TaskStoreRequest(),
             *
             *   // テスト対象: formData
             *   'formData' => [
             *     'name' => str_repeat('a', 10)
             *   ],
             *
             *   // 期待値: バリデーションが通るかどうか
             *   '$isPass' => true,
             *
             *   // 期待値: エラーメッセージ
             *   '$expectedMegs' => [],
             *  ],
             */
            [
                //
            ],
        ];
    }

    /**
     * @dataProvider validationTestDataProvider
     * @param FormRequestInterface $formRequest
     * @param array $formDara
     * @param bool $isPass
     * @param array $expectedMegs
     */
    public function testValidationRules(
        FormRequestInterface $formRequest,
        array $formDara,
        bool $isPass,
        array $expectedMegs
    ) {
        // Validator を生成
        $validator = Validator::make(
            $formDara,
            $formRequest->rules(), //formRequest から バリデーションルール を取得
            $formRequest->messages(), //formRequest から カスタムエラーメッセージ を取得
            $formRequest->attributes() //formRequest から カスタムAttributes を取得
        );

        // assert
        $this->assertEquals($isPass, $validator->passes(), 'バリデーション結果(エラー有無)が期待値通りである事');
        foreach ($expectedMegs as $itemName => $errMsgs) {
            $nameErrMsg = Arr::get($validator->getMessageBag()->getMessages(), $itemName);
            $this->assertNotNull($nameErrMsg, '期待した項目がバリデーションエラーになる事');
            foreach ($errMsgs as $msg) {
                $this->assertTrue(in_array($msg, $nameErrMsg), '期待値通りのエラーメッセージが返る事');
            }
        }
    }
}
