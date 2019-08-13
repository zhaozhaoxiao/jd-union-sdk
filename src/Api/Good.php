<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/24
 * Time: 9:56
 */

namespace JdMediaSdk\Api;


use JdMediaSdk\Tools\Helpers;
use JdMediaSdk\Tools\JdGateWay;

class Good extends JdGateWay
{
    /**
     * @api 关键词商品查询接口【申请】
     * @line https://union.jd.com/#/openplatform/api/628
     * @param array $params
     * @param bool $raw
     * @return bool|string
     * @throws \Exception
     */

    public function query(array $params, $raw = false)
    {
        if (!isset($params['pageIndex'])) {
            $params['pageIndex'] = 1;
        }
        $sends = [
            'goodsReqDTO' => $params
        ];
        $result = $this->send('jd.union.open.goods.query', $sends, $raw);
        return $result;
    }

    /**
     * @api 学生价商品查询接口【申请】
     * @link https://union.jd.com/openplatform/api/666
     * @param array $param
     * @return bool|string
     * @throws \Exception
     */
    public function stuprice(array $param)
    {
        //TODO
        if (!isset($param['pageIndex'])) {
            $params['pageIndex'] = 1;
        }
        $params = [
            'goodsReq' => $param
        ];

        return $this->send('jd.union.open.goods.stuprice.query', $params);
    }

    /**
     * @api 秒杀商品查询接口【申请】
     * @line https://union.jd.com/openplatform/api/667
     * @param array $params
     * @return bool|string
     * @throws \Exception
     */
    public function seckill(array $params)
    {
        $params = [
            'goodsReq' => $params
        ];
        return $this->send('jd.union.open.goods.seckill.query', $params);
    }

    /**
     * @api 获取推广商品信息接口
     * @line https://union.jd.com/#/openplatform/api/563
     * @param $skuIds
     * @return bool|string
     * @throws \Exception
     */
    public function info($skuIds)
    {
        if (is_array($skuIds)) {
            $skuIds = implode(',', $skuIds);
        }
        $params = [
            'skuIds' => $skuIds
        ];
        $result = $this->send('jd.union.open.goods.promotiongoodsinfo.query', $params);
        return $result;
    }

    /**
     * @api 获取详情的图片集合
     * @param $skuId
     * @param bool $raw
     * @return bool|mixed|string|null |null |null array
     * @throws \Exception
     */
    public function detailImgLists($skuId, $raw = false)
    {
        $link = "https://item.jd.com/{$skuId}.html";
        $html = Helpers::curl_get($link);
        $html_one = explode("desc: '", $html, 2);
        if (!isset($html_one[1]) || empty($html_one[1])) {
            return null;
        }
        $html_two = explode("',", $html_one[1], 2);
        $imgLink = 'http:' . $html_two[0];
        $detail = Helpers::curl_get($imgLink);
        if (strpos($detail, 'showdesc') !== false) {
            $detail = str_replace(['showdesc(', '\\'], '', $detail);
            $detail = rtrim($detail, ')');
        } else {
            $json = json_decode($detail, true);
            $detail = $json['content'];
        }
        $content_detail = $detail;
        $detail = Helpers::get_images_from_html($content_detail);
        if (empty($detail)) {
            $detail = Helpers::get_images_from_css($content_detail);
        }
        return $detail;
    }

    /**
     * 获取商品主图信息
     * @param $skuId
     * @return mixed
     */
    public function goodImgLists($skuId)
    {
        $link = "http://item.jd.com/{$skuId}.html";
        $html = Helpers::curl_get($link);
        preg_match("/imageList: \[(\S+)\]/", $html, $regs);
        $imgList = explode(',', $regs[1]);
        foreach ($imgList as &$item) {
            $item = 'http://img14.360buyimg.com/n1/' . trim($item, '"');
        }
        return $imgList;
    }

    /**
     * @api  商品类目查询
     * @line https://union.jd.com/#/openplatform/api/693
     * @param $parentId
     * @param $grade
     * @return bool|string
     * @throws \Exception
     */
    public function category($parentId = 0, $grade = 0)
    {
        $params = [
            'req' => [
                'parentId' => $parentId,
                'grade' => $grade
            ]
        ];
        $result = $this->send('jd.union.open.category.goods.get', $params);
        return $result;
    }

    /**
     * @api 京粉精选商品查询接口
     * @line https://union.jd.com/openplatform/api/739
     * @param int $eliteId
     * 频道id：1-好券商品；
     *        2-京粉APP.大咖推荐；
     *        3-小程序-好券商品；
     *        4-京粉APP-.主题街.服装运动；
     *        5-京粉APP-主题街.精选家电；
     *        6-京粉APP-主题街.超市；
     *        7-京粉APP-主题街.居家生活；
     *        10-9.9专区；
     *        11-品牌好货.潮流范儿；
     *        12-品牌好货.精致生活；
     *        13-品牌好货.数码先锋；
     *        14-品牌好货.品质家电；
     *        15-京仓配送；
     *        16-公众号.好券商品；
     *        17-公众号.9.9；
     *        18-公众号-京仓京配
     * @param int $pageIndex 页码
     * @param int $pageSize 每页数量, 最大50
     * @param string $sortName 排序字段(price：单价, commissionShare：佣金比例, commission：佣金， inOrderCount30DaysSku：sku维度30天引单量，comments：评论数，goodComments：好评数
     * @param string $sort 默认降序  asc,desc升降序
     * @return bool|string
     * @throws \Exception
     */
    public function jingfen($eliteId = 1, $pageIndex = 1, $pageSize = 50, $sortName = 'price', $sort = 'desc')
    {

        $params = [
            'goodsReq' => [
                'eliteId' => $eliteId,
                'pageIndex' => $pageIndex,
                'pageSize' => $pageSize,
                'sortName' => $sortName,
                'sort' => $sort
            ]
        ];

        $result = $this->send('jd.union.open.goods.jingfen.query', $params, true);

        return $result;
    }
}