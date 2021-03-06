<?php declare(strict_types=1);
/**
 * DuckPHP
 * From this time, you never be alone~
 */
namespace SimpleAuth\Controller;

use SimpleAuth\Business\UserBusiness;
use SimpleAuth\Business\UserBusinessException;
use SimpleAuth\Helper\ControllerHelper as C;

class Home
{
    public function __construct()
    {
        $this->initController();
    }
    protected function initController()
    {

       
        $method = C::getRouteCallingMethod();
        //C::SessionManager()->checkCsrf();
        //C::assignExceptionHandler(C::SessionManager()::ExceptionClass(), [static::class, 'OnSessionException']);
        $this->setLayoutData();
    }
    public static function OnSessionException($ex = null)
    {
        if(!isset($ex)){
            C::Exit404();
            return;
        }
        $code = $ex->getCode();
        __logger()->warning(''.(get_class($ex)).'('.$ex->getCode().'): '.$ex->getMessage());
        if (C::SessionManager()->isCsrfException($ex) && __is_debug()) {
            C::exit(0);
        }
        C::ExitRouteTo('login');
    }
    protected function setLayoutData()
    {
        $csrf_token = C::SessionManager()->csrf_token();
        $csrf_field = C::SessionManager()->csrf_field();
         
        $user = C::SessionManager()->getCurrentUser();
        $user_name = $user['username'] ?? '';

        C::setViewHeadFoot('home/inc-head','home/inc-foot');
        C::assignViewData(get_defined_vars());
    }
    public function index()
    {
        $url_logout = C::Url('logout');
        C::Show(get_defined_vars());
    }
    public function password()
    {
        C::Show(get_defined_vars());
    }
    //////////////////////////
    public function do_password()
    {
        $error = '';
        try {
            $uid = C::SessionManager()->getCurrentUid();

            $old_pass = C::POST('oldpassword','');
            $new_pass = C::POST('newpassword','');
            $confirm_pass = C::POST('newpassword_confirm','');
            
            if($new_pass !== $confirm_pass) {
                throw new \Exception('重复密码不一致');
            }
            UserBusiness::G()->changePassword($uid, $old_pass, $new_pass);
            $error = "密码修改完毕";            
        } catch (\Exception $ex) {
            $error = $ex->getMessage();
        }
        C::Show(get_defined_vars());
    }
}