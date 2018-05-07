<?
namespace Manage\Model;
use Think\Model;

class PayinfoModel extends Model {

	//支付方式
	public function paytype(){
		return array(
			'1'=>'微信',
			'2'=>'其他',
		);
	}
	//支付状态
	public function payflag(){
		return array(
			'1'=>'<span style="color:red;">未支付</sapn>',
			'2'=>'<span style="color:green;">已支付</sapn>',
		);
	}
}