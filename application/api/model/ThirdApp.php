<?php

namespace app\api\model;

use think\Model;

class ThirdApp extends ApiBase
{
    public static function check($ac, $se)
    {
        $app = self::where('app_id','=',$ac)
            ->where('app_secret', '=',$se)
            ->find();
        return $app;

    }
}
