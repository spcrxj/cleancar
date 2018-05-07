<?
namespace Bussniess\Model;

use Think\Model;

class SellerModel extends Model {

    //判断当前用户是否登录
    /*
     * return true/false
     */
    public function islogin() {
        $seller_id = session('seller.seller_id', ""); //用户id
        $username = session('seller.username', ""); //用户username
        if (!$seller_id || !$username) {
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
    public function sellerlogin($username, $password) {
        if (!$username || !$password)
            return false;

        $data = $this->where("username='" . $username . "' ")->field("ec_seller.*")->find();
        if ($data) {
            if ($data['password'] == md5($password)) {
                session('seller', $data);
				
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
