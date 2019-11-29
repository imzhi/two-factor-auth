<?php namespace App\Controllers;

use App\Repositories\UserRepository;

class User extends BaseController
{
    protected $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository;
    }

    /**
     * 登录
     */
	public function login()
	{
        $code = $this->request->getGet('code');

        $result = $this->userRepository->login($code);

        // @todo
        return $result;
    }

    /**
     * 密钥列表
     */
    public function secret()
    {
        $uid = $this->request->getGet('uid');

        $list = $this->userRepository->secret($uid);

        // @todo
        return $list;
    }

    /**
     * 存储密钥
     */
    public function store()
    {
        $uid = $this->request->getPost('uid');
        $requestData = $this->request->getPost(['title', 'name', 'secret']);

        $result = $this->userRepository->store($requestData, $uid);

        // @todo
        return $result;
    }

    /**
     * 删除密钥
     */
    public function del()
    {
        $uid = $this->request->getPost('uid');
        $sid = $this->request->getPost('sid');

        $result = $this->userRepository->del((array) $sid, $uid);

        // @todo
        return $result;
    }
}
