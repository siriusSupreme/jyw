<?php

namespace app\api\model;

use think\Model;

class ImageModel extends ApiBaseModel
{
    protected $hidden = ['delete_time', 'id', 'from'];

    public function getUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }
}

