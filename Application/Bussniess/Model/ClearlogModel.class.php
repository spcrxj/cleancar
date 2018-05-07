<?
namespace Bussniess\Model;

use Think\Model;

class ClearlogModel extends Model {

    // 结算状态 1未结算，2已结算',
	public function log_backmoney(){
		return array(
			
			'1'=>'未结算',
			'2'=>'已结算',
			
		);
	}
}
