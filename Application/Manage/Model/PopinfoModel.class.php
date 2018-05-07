<?
namespace Manage\Model;

use Think\Model;

class PopinfoModel extends Model {
	
	//商家申请提现
	public function get_popflag(){
		return array(
			'1'=>'未审核',
			'2'=>'审核通过',
		);
	}
	//商家申请提现
	public function get_modify_type(){
		return array(
			'1'=>'联系人',
			'2'=>'联系电话',
		);
	}
}
