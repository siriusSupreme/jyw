<?php
/**
 * Created by 七月
 * User: 七月
 * Date: 2017/2/15
 * Time: 13:40
 */

namespace app\api\controller\v1;


use app\api\controller\ApiBaseController;
use app\api\validate\IDMustBePositiveIntValidate;
use app\api\model\BannerModel;
use app\api\library\exception\MissException;

/**
 * Banner资源
 */
class BannerController extends ApiBaseController
{
//    protected $beforeActionList = [
//        'checkPrimaryScope' => ['only' => 'getBanner']
//    ];

    /**
     * 获取Banner信息
     * @url     /banner/:id
     * @http    get
     * @param   int $id banner id
     * @return  array of banner item , code 200
     * @throws  MissException
     */
    public function getBanner($id)
    {
        $validate = new IDMustBePositiveIntValidate();
        $validate->goCheck();
        $banner = BannerModel::getBannerById($id);
        if (!$banner ) {
            throw new MissException([
                'msg' => '请求banner不存在',
                'errorCode' => 40000
            ]);
        }
        return $banner;
    }
}
