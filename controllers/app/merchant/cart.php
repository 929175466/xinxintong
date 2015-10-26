<?php
namespace app\merchant;

require_once dirname(dirname(dirname(__FILE__))) . '/member_base.php';
/**
 * 购物车
 */
class cart extends \member_base {
	/**
	 *
	 */
	public function get_access_rule() {
		$rule_action['rule_type'] = 'black';
		$rule_action['actions'] = array();

		return $rule_action;
	}
	/**
	 * 进入发起订单页
	 *
	 * 要求当前用户必须是关注用户
	 *
	 * @param string $mpid mpid'id
	 * @param int $product
	 * @param int $sku
	 *
	 */
	public function index_action($mpid, $product = null, $skus = null, $mocker = null, $code = null) {
		/**
		 * 获得当前访问用户
		 */
		$openid = $this->doAuth($mpid, $code, $mocker);

		$this->afterOAuth($mpid, $product, $skus, $openid);
	}
	/**
	 * 返回页面
	 */
	public function afterOAuth($mpid, $productId, $skuIds, $openid) {
		\TPL::output('/app/merchant/cart');
		exit;
	}
	/**
	 *
	 */
	public function pageGet_action($mpid, $shop) {
		// current visitor
		$user = $this->getUser($mpid);
		// page
		$page = $this->model('app\merchant\page')->byType($shop, 'cart');
		if (empty($page)) {
			return new \ResponseError('没有获得购物车页定义');
		}
		$page = $page[0];

		$params = array(
			'user' => $user,
			'page' => $page,
		);

		return new \ResponseData($params);
	}
}