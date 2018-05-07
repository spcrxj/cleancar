<?
namespace Manage\Model;
use Think\Model;

class ClearlogModel extends Model {

	//是否确定
	public function is_checked(){
		return array(
			'1'=>'未确定',
			'2'=>'已确定',
		);
	}
}