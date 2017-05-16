<?php

namespace app\api\model;

use think\Model;

class BannerItemModel extends ApiBaseModel
{
    protected $hidden = ['id', 'img_id', 'banner_id', 'delete_time'];

    public function img()
    {
        return $this->belongsTo('Image', 'img_id', 'id');
    }
    //
}
