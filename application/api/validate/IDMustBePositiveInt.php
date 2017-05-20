<?php
/**
 * Created by 七月
 * User: 七月
 * Date: 2017/2/18
 * Time: 12:35
 */
namespace app\api\validate;

class IDMustBePositiveInt extends ApiBase
{
    protected $rule = [
        'id' => 'require|isPositiveInteger',
    ];
}
