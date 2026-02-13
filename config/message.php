<?php

return [
    'default' => env('NOTIFY_DEFAULT_CHANNEL', 'dingtalk'),
    'channels' => [
        'dingtalk' => [
            'driver' => Summer\ExceptionNotify\Channel\Dingtalk::class,

            /*
             * 自定义机器人调用接口的凭证
             * 自定义机器人安装后webhook地址中的access_token值。详情参考获取自定义机器人 Webhook 地址。
             */
            'access_token' => env('DINGTALK_ACCESS_TOKEN', 'your access token'),

            /*
             * 安全设置
             * 添加机器人时选择的安全设置类型, 支持自定义关键词(keyword) 和 加签(sign)
             */
            'auth_type' => env('DINGTALK_AUTH_TYPE', 'keyword'),

            /*
             * When the auth type is keyword, this refers to the keyword added to the bot.
             */
            'keyword' => env('DINGTALK_KEYWORD', 'your keyword'),

            /*
             * When the auth type is sign, this refers to the secret adding the bot.
             */
            'secret' => env('DINGTALK_SECRET', 'your secret'),

            /*
             * 被@的群成员手机号
             */
            'at' => explode(',', env('DINGTALK_AT', '')),
        ],
        'feishu' => [
            'driver' => Summer\ExceptionNotify\Channel\Feishu::class,
            'access_token' => env('FEISHU_ACCESS_TOKEN', 'your access token'),
            'auth_type' => env('FEISHU_KEYWORD', 'keyword'),
            'keyword' => env('FEISHU_KEYWORD', 'your keyword'),
            'secret' => env('FEISHU_SECRET', 'your secret'),
        ],
        'wechat' => [
            // 'driver' => Summer\ExceptionNotify\Channel\Wechat::class,
            'access_token' => env('WECHAT_ACCESS_TOKEN', 'your access token'),
        ],
    ],
];
