<?
namespace Manage\Model;

use Think\Model;

class UserModel extends Model {

	//会员类型 1普通会员，2特殊会员，3 黑名单会员',
	public function get_userflag(){
		return array(
			'1'=>'普通会员',
			'2'=>'特殊会员',
			'3'=>'黑名单会员'
		);
	}

	//会员状态 1启用，2禁用，
		public function get_userable(){
			return array(
				'1'=>'启用',
				'2'=>'禁用',
			);
		}


	
}
