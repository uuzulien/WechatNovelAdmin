<?php

/*
 * This file is part of the overtrue/laravel-wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

return [
    /*
     * 默认配置，将会合并到各模块中
     */

    'default' => [
        'access_token' => '9b2dc679854cda21a5b16f79a8696630',
        'refresh_token' => 'a831b9f75be9137ca5e42ccc036460ae',
        'account_id' => '4012484', // 授权的id
        'user_action_set_id' => '', // 用户行为数据源
    ],
    /*
     * 我的配置，正在使用的
     */

    'my' => [
        'authorization_code' => '1217186a6bdca37286468d40e3f44a5b',
        'access_token' => '641cfc80fbc1313b436cdcfb91f24f81', // 不同账号需要用不同的
        'refresh_token' => '0637302d48659ae0d3ebf4c963a34a49',
        'account_id' => '14821178',
        'user_action_set_id' => 1110364861, // 用户行为数据源，可只用一个
    ],
    'nonce' => '5s8a58dlk96s463didhg'
];
