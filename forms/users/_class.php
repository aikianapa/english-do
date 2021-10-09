<?php
class usersClass extends cmsFormsClass
{
    public function profile()
    {
        $out = $this->app->getForm('users', 'profile');
        $out->find('[name=phone]')->attr('disabled', true);
        $out->fetch();
        $out->find('[name=phone]')->removeAttr('name');
        echo $out;
    }

    public function beforeItemShow(&$item)
    {
        $item['phone'] = $this->app->phoneFormat($item['phone']);
    }

    public function afterItemRead(&$item)
    {
        isset($item['phone']) ? null : $item['phone'] = '';
        $item['phone'] = preg_replace('/[^0-9]/', '', $item['phone']);
        return $item;
    }

    public function student_login() {
        header('Content-Type: application/json; charset=utf-8');
        $res = ['error'=>true,'msg'=>'Login error'];
        $app = &$this->app;
        $card = $app->vars('_post.card');
        $secret = $app->vars('_post.secret');
        if ($app->vars('_sett.secret') !== $secret) {
            return json_encode($res);
            die;
        }
        $users = $app->itemList('users',['filter'=>[
            'active'=>'on',
            'role'=>'student',
            'card'=>$card
        ],'limit'=>1]);
        if ($users['count'] > 0) {
            $user = array_pop($users['list']);
            $app->login($user);
            $res=['error'=>false,'msg'=>'Logged in','user'=>$user];
        }
        return json_encode($res);
        die;
    }
}
