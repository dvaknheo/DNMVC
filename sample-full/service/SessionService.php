<?php
class SessionService extends DnService
{
	public function __construct()
	{
		session_name('x');
		session_start();
		
	
	}
	public function getCurrentUser()
	{
		$user=isset($_SESSION['user'])?$_SESSION['user']:array();
		return $user;
	}
	public function setCurrentUser($user)
	{
		$_SESSION['user']=$user;
	}
	public function logout()
	{
		//unset($_SESSION):
		session_destroy();
	}
}