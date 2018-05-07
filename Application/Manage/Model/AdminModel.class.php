<?
namespace Manage\Model;

use Think\Model;

class AdminModel extends Model {

    //判断当前用户是否登录
    /*
     * return true/false
     */
    public function islogin() {
        $admin_id = session('admin.admin_id', ""); //用户id
        $username = session('admin.username', ""); //用户username
		$admin_type = session('admin.admin_type', ""); //管理员role
        if (!$admin_id || !$username||!$admin_type) {
            return false;
        } else {
            return true;
        }
    }

    //用户登录
    /*
     * username 用户名
     * password 密码
     * return true/false
     */
    public function adminlogin($username, $password) {
        if (!$username || !$password)
            return false;

        $data = $this->where(" username='" . $username . "' ")->field(" ec_admin.* ")->find();
        if ($data) {
            
            if ($data['password'] == md5($password)) {
				if($data['admin_type']==1){
				     $data['admin_type_name']='老板';
				}else if($data['admin_type']==2){
					 $data['admin_type_name']='员工';
				}
                session('admin', $data);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
	//管理员修改密码
    /*
     * admin_id 管理员id
     * oldpassword 原密码
     * newpassword 新密码
     * return true/false
     */
    public function pswadmin($admin_id, $oldpassword, $newpassword) {
        if (!$admin_id || !$oldpassword || !$newpassword)
            return false;

        $data = $this->where("admin_id=" . $admin_id)->find();
        if ($data) {
            if ($data['password'] == md5(md5($oldpassword) . $data['username'])) {
                $newpassword = md5(md5($newpassword) . $data['username']);
                $this->where("admin_id=" . $admin_id)->save(array("password" => $newpassword));
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

	//管理员级别
	public function get_admin_type(){
		return array(
			'1'=>'老板',
			'2'=>'员工',
		);
	}

	//管理员级别
	public function get_able_type(){
		return array(
			'1'=>'正常',
			'2'=>'禁用',
		);
	}
}
