<?php
/**
 * Created by Z2y3ystem.
 * User: Acer
 * Date: 2017/5/22
 * Time: 16:36
 */

return [
    //  +---------------------------------
    //  微信相关配置
    //  +---------------------------------
    'app_id' => '',
    'app_secret' => '',
    // 微信使用code换取用户openid及session_key的url地址
    'login_url' => "https://api.weixin.qq.com/sns/jscode2session?" .
        "appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",
    // 微信获取access_token的url地址
    'access_token_url' => "https://api.weixin.qq.com/cgi-bin/token?" .
        "grant_type=client_credential&appid=%s&secret=%s",
];