<?php

class modPhonecheck {
    public function __construct($app)
    {
        $this->checkRequires(['curl']);
        $mode = $app->route->mode;
        if (isset(($app->route->params))) $param = $app->route->params[0];
        in_array($mode,['reg','check','getcode','login']) ? null : $app->apikey('module');
        $this->app = $app;
        if (method_exists($this, $mode)) {
            echo $this->$mode();
        } else if ($this->isPhone($param)) {
            echo $this->reg($param);
        } else {
            $form = $app->controller('form');
            echo $form->get404();
        }
        die;
    }

    private function getcode() {
        header('Content-Type: application/json');
        $this->code = rand(123,999).'-'.rand(123,999);
        $this->phone = $this->app->vars('_post.phone');
        $this->type = $this->app->vars('_post.type');
        $this->number = preg_replace('/[^0-9]/','',$this->phone);
        $this->check = $this->app->PasswordMake($this->code.$this->number);
        $_SESSION['reg'] = ['phone'=>$this->phone, 'control'=>$this->check];
        $this->type == 'login' ? $this->setcode() : null;
        return json_encode([
            'phone'=>$this->app->vars('_post.phone'),
            'code'=>$this->code,
            'check'=>$this->check
        ]);
    }

    private function setcode() {
        $number = preg_replace('/[^0-9]/','',$this->phone);
        $user = $this->app->checkUser($number,'phone');
        if ($user) {
            $user = $this->app->itemSave('users',[
                'id'        =>  $user->id,
                'password'  =>  $this->check
            ]);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['error' => true, 'msg' => 'Пользователь не зарегистрирван']);
            die;
        }
    }

    private function login() {
        header('Content-Type: application/json');
        $phone = $this->app->vars('_post.phone');
        $check = $this->app->vars('_post.check');
        $number = preg_replace('/[^0-9]/','',$phone);
        if ($phone == '' OR $check == '') {
            return json_encode(['login'=>false,'error'=>true]);
        }
        $user = $this->app->checkUser($number, 'phone', $check.$number);
        if ($user) {
            $this->app->login($user);
            return json_encode(['login'=>true,'error'=>false,'redirect'=>$user->group->url_login,'user'=>$user,'role'=>$user->role]);
        } else {
            return json_encode(['login'=>false,'error'=>true,'msg'=>'Ошибка! Вход не выполнен.']);
        }
    }

    private function reg() {
        header('Content-Type: application/json');
        $control = $_SESSION['reg']['control'];
        $phone = $_SESSION['reg']['phone'];
        $number = preg_replace('/[^0-9]/','',$phone);
        $code = $this->app->vars('_post.check');
        $check = $check = md5($code.$phone);
        $demo = '79883471188';
        if ($check == $control) {
            $user = $this->app->checkUser($number, 'phone');
            if ($user && $number !== $demo) {
                echo json_encode(['error' => true, 'msg' => 'Пользователь уже зарегистрирван']);    
                die;
            }
            if ($number !== $demo) {
                $user = [
                    'first_name' => 'Пользователь'
                    ,'last_name' => ''
                    ,'active' => 'on'
                    ,'phone' => $phone
                    ,'role' => 'user'
                    ,'password' => wbPasswordMake($code)
                    ,'login' => '_new'
                ];
                $user = $_SESSION['user'] = $this->app->itemSave('users',$user);
                if ($user) {
                    $this->app->login($user);
                } else {
                    echo json_encode(['error' => false, 'msg' => 'Неизвестная ошибка. Попробуйте позже.']);        
                    die;
                }
            }
            echo json_encode(['error' => false, 'msg' => 'Регистрация успешно завершена']);
        } else {
            echo json_encode(['error' => true,'msg' => 'Неверный проверочный код']);
        }
    }

    private function isPhone() {
        return true;
    }


    private function checkRequires($req = []) {
        $ready = true;
        foreach((array)$req as $mod) {
            if (!extension_loaded($mod)) {$ready = false; echo 'Warning: PHP module '.$mod.' not intalled!<br>';}
        }
        
    }
    
}
?>