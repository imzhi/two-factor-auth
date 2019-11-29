<?php namespace App\Traits;

use EasyWeChat\Factory;

trait Wechat
{
    protected function miniProgram()
    {
        $config = [
            'app_id' => env('WECHAT_MINI_PROGRAM_APPID'),
            'secret' => env('WECHAT_MINI_PROGRAM_SECRET'),

            // 下面为可选项
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',

            'log' => [
                'level' => 'debug',
                'file' => WRITEPATH . '/logs/wechat.log',
            ],
        ];

        $app = Factory::miniProgram($config);

        return $app;
    }
}
