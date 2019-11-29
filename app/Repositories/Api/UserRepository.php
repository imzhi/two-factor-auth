<?php namespace App\Repositories;

use App\Traits\Wechat;
use App\Models\UserModel;
use App\Models\UserSecretModel;

class UserRepository
{
    use Wechat;

    /**
     * 登录
     */
	public function login(string $code)
	{
        $result = $this->miniProgram()->auth->session($code);
        if (!empty($result['errcode'])) {
            return [true, '__login_fail'];
        }

        $model = $this->getUserByOpenid($result['openid']) ?: $this->createUser($result);
        $uid = $model->buildUid;

        $key = Cache::get("sign:key:{$uid}");
        if ($key) {
            Cache::forget("sign:key:{$uid}");
            Cache::forget("login:session_key:{$key}");
            Cache::forget("login:openid:{$key}");
        }

        helper('text');
        $key = random_string('alnum', 32);
        $expire = DAY;
        Cache::put("sign:key:{$uid}", $key, $expire / 60);
        Cache::put("login:session_key:{$key}", $result['session_key'], $expire / 60);
        Cache::put("login:openid:{$key}", $result['openid'], $expire / 60);

        return [false, compact('key', 'expire', 'uid')];
    }

    /**
     * 密钥存储
     */
    public function store(array $args, int $uid)
    {
        $model = new UserSecretModel;
        $data = [
            'uid' => $uid,
            'title' => $args['title'] ?? '',
            'name' => $args['name'] ?? '',
            'secret' => $args['secret'] ?? '',
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $result = $model->insert($data);

        return $result;
    }

    /**
     * 密钥列表
     */
    public function secret(int $uid)
    {
        $list = $this->findAllSecret($uid);
        $result = [];
        // @todo
        foreach ($list as $item)
        {
        }
    }

    protected function findAllSecret(int $uid)
    {
        $result = UserSecretModel::where('uid', $uid)->findAll();

        return $result;
    }

    /**
     * 删除密钥
     */
    public function del(array $sid, int $uid)
    {
        $result = UserSecretModel::where('uid', $uid)->whereIn('sid', $sid)->delete();

        return $result;
    }

    protected function getUserByOpenid(string $openid)
    {
        $model = UserModel::where('openid', $openid)->first();

        return $model;
    }

    protected function getUserByUid(int $uid)
    {
        $model = UserModel::where('uid', $uid)->first();

        return $model;
    }

    protected function createUser(array $args)
    {
        $model = new UserModel;
        $data = [
            'uid' => $this->buildUid(),
            'openid' => $args['openid'],
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $result = $model->insert($data);

        return $result;
    }

    protected function buildUid()
    {
        do {
            $uid = mt_rand(10000000, 99999999);
        } while (UserModel::where('uid', $uid)->selectCount('*'));

        return $uid;
    }

    protected function buildSid()
    {
        do {
            $sid = mt_rand(10000000, 99999999);
        } while (UserSecretModel::where('sid', $sid)->selectCount('*'));

        return $sid;
    }
}
