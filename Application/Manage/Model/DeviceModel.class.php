<?
namespace Manage\Model;
use Think\Model;

class DeviceModel extends Model {

	//设备状态
	public function deviceflag(){
		return array(
			'1'=>'<span style="color:green;">正常</span>',
			'2'=>'<span style="color:red;">异常</span>',
		);
	}
}