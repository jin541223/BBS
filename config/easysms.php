<?php
return [
    // 请求超时时间
    'timeout'  => 5.0,

    'default'  => [
        // 网关调用策略 默认顺序调用
        'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,
        // 可用发送网关
        'gateways' => ['yunpian'],
    ],
    // 可用网关配置
    'gateways' => [
        'errorlog' => [
            'file' => '/tmp/easy-sms.log',
        ],
        'yunpian'  => [
            'api_key' => env('YUNPIAN_API_KEY'),
        ],
    ],
];
