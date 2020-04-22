<?php

namespace App\Repositories\Gdt;

class GdtFunc
{
    // 创建用户行为数据源
    public function user_action_sets_add($access_token)
    {
        $interface = 'user_action_sets/add';
        $url = 'https://api.e.qq.com/v1.1/' . $interface;

        $common_parameters = array (
            'access_token' => $access_token,
            'timestamp' => time(),
            'nonce' => md5(uniqid(config('gdt.nonce'), true))
        );

        $parameters = array (
            'account_id' => config('gdt.my.account_id'),
            'type' => 'WEB',
            'name' => 'test',
            'description' => '',
        );

        $parameters = json_encode($parameters);
        $request_url = $url . '?' . http_build_query($common_parameters);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $request_url);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Content-Type:application/json"
        ));
        $response = curl_exec($curl);
        if (curl_error($curl)) {
            $error_msg = curl_error($curl);
            $error_no = curl_errno($curl);
            curl_close($curl);
            throw new \Exception($error_msg, $error_no);
        }
        curl_close($curl);
        return $response;
    }

    // 上报用户行为
    public function user_actions_add($clickId=null,$access_token=null)
    {
        $interface = 'user_actions/add';
        $url = 'https://api.e.qq.com/v1.1/' . $interface;

        $common_parameters = array (
            'access_token' => config('gdt.my.access_token'),
            'timestamp' => time(),
            'nonce' => md5(uniqid(config('gdt.nonce'), true))
        );

        $parameters = array (
            'account_id' => config('gdt.my.account_id'),
            'user_action_set_id' => config('gdt.my.user_action_set_id'),
            'actions' =>
                array (
                    0 =>
                        array (
                            'url' => url()->current(),
                            'action_time' => time(),
                            'action_type' => 'VIEW_CONTENT',
                            'trace' => array('click_id' => $clickId),
                        ),
                ),
        );

        $parameters = json_encode($parameters);
        $request_url = $url . '?' . http_build_query($common_parameters);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $request_url);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Content-Type:application/json"
        ));
        $response = curl_exec($curl);
        if (curl_error($curl)) {
            $error_msg = curl_error($curl);
            $error_no = curl_errno($curl);
            curl_close($curl);
            throw new \Exception($error_msg, $error_no);
        }
        curl_close($curl);
        return json_decode($response);
    }

}
