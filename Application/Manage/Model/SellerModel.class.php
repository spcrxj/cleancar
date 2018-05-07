<?
namespace manage\Model;
use Think\Model;

class SellerModel extends Model {


	//账号状态
	public function get_type(){
		return array(
			'1'=>'启用',
			'2'=>'禁用',
		);
	}

}