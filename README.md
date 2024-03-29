**京东联盟SDK**

本项目由 yumufeng 的项目修改，如有需要可以访问原repository：[链接](https://github.com/yumufeng/jd-union-sdk "链接")

京东联盟SDK，基于新版的

PHP =>7.0

`composer require zhaozhaoxiao/jd-union-sdk`

如果是在swoole 扩展下使用，支持协程并发，需要在编译swoole扩展的时候开启，系统会自动判断是否采用swoole

```./configure --enable-openssl```

### 使用示例

```php
$config = [
    'appkey' => '', // AppId
    'appSecret' => '', // 密钥
    'unionId' => '', // 联盟ID
    'positionId' => '', // 推广位ID
    'siteId' => '' // 网站ID,
    'apithId' => '',  // 第三方网站Apith的appid （可选，不使用apith的，可以不用填写）
    'apithKey' => '', // 第三方网站Apith的appSecret (可选，不使用apith的，可以不用填写)
    'isCurl' => true // 设置为true的话，强制使用php的curl，为false的话，在swoole cli环境下自动启用 http协程客户端
];
$client = new \JdMediaSdk\JdFatory($config);
$result = $client->apith->querySeckillGoods();
if ($result == false ) {
    var_dump($client->getError());
}

var_dump($result);

```


## 说明文档


### 1.官方版本

以下**官方版本**传参参考：https://union.jd.com/#/openplatform/api

| 接口名称 [**基础**]   | 对应方法  |
| --------   | ---- |
| jd.union.open.order.query (订单查询接口)     | \$client->promotion->order() |
| jd.union.open.goods.promotiongoodsinfo.query (获取推广商品信息接口)     | \$client->good->info() |
| jd.union.open.category.goods.get(商品类目查询)     | \$client->good->category() |
| jd.union.open.user.pid.get(获取PID)     | \$client->promotion->pid() |
| jd.union.open.promotion.common.get(获取通用推广链接)     | \$client->link->get() |
| jd.union.open.goods.jingfen.query (京粉精选商品查询接口)     | \$client->good->jingfen() |
| (京东商品详情图片集合接口)     | \$client->good->detailImgLists() |
| (京东主图图片集合接口)     | \$client->good->goodImgLists() |

| 接口名称 [**高级**] **官方版**   | 对应方法  |
| --------   | ---- |
|jd.union.open.coupon.query(优惠券领取情况查询接口【**申请**】)   | \$client->coupon->query()   |
|jd.union.open.goods.seckill.query(秒杀商品查询接口【**申请**】)   | \$client->good->seckill()   |
|jd.union.open.goods.query(关键词商品查询接口【**申请**】)   | \$client->good->query()   |
|jd.union.open.promotion.byunionid.get(通过unionId获取推广链接【**申请**】)   | \$client->link->byUnionId()   |
|jd.union.open.coupon.importation(优惠券导入【**申请**】)   | \$client->coupon->importation()   |
|jd.union.open.position.query(查询推广位【**申请**】)   | \$client->promotion->queryPosition()   |
|jd.union.open.position.create(创建推广位【**申请**】)   | \$client->promotion->createPosition()   |





## License

MIT



