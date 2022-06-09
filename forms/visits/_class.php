<?php
class visitsClass extends cmsFormsClass {

    function scan() {
        $code = $_GET['card'];
        $get = $this->app->itemList('users',["filter"=>[
            'active'=>'on',
            'card'=>$code
        ]]);
        header("Content-type:application/json");
        if ($get['count']>0) {
            $member=array_shift($get['list']);
            $result = [
                "error" => false,
                "msg" => "Карта успешно найдена",
                "member" => $member
            ];
            return json_encode($result);
        } else {
            return '{"error":true,"msg":"Карта не найдена"}';
        }
    }

    function get() {
        header("Content-type:application/json");
        $result = [
            'error' => true,
            'msg' => 'Посещение не зафиксировано',
            'status' => false
        ];
        $uid = $this->app->vars('_post.uid');
        $date = $this->app->vars('_post.date');
        if ($uid>'' && $date>'2000') {
            $id = 'id'.md5($uid.$date);
            $check = $this->app->itemRead('visits',$id);
            if ($check) {
                $result = [
                    'error' => false,
                    'msg' => 'Посещение отмечено',
                    'status' => true
                ];
            }
        }
        return json_encode($result);
    }


    function check() {
        header("Content-type:application/json");
        $result = [
            'error' => true,
            'msg' => 'Ошибка',
            'check' => null
        ];
        $uid = $this->app->vars('_post.uid');
        $date = $this->app->vars('_post.date');
        if ($uid>'' && $date>'2000') {
            $id = 'id'.md5($uid.$date);
            $item = [
                'id' => $id,
                'date' => $date,
                'uid' => $uid
            ];
            $check = $this->app->itemSave('visits',$item);
            if ($check) {
                $result = [
                    'error' => false,
                    'msg' => 'Посещение отмечено',
                    'check' => $check
                ];
            }
        }
        return json_encode($result);
    }

    function uncheck() {
        header("Content-type:application/json");
        $result = [
            'error' => true,
            'msg' => 'Ошибка',
            'check' => null
        ];
        $uid = $this->app->vars('_post.uid');
        $date = $this->app->vars('_post.date');
        if ($uid>'' && $date>'') {
            $id = 'id'.md5($uid.$date);
            $check = $this->app->itemRemove('visits',$id);
            if ($check && isset($check['_removed']) && $check['_removed']=='true') {
                $result = [
                    'error' => false,
                    'msg' => 'Посещение удалено',
                    'check' => $check
                ];
            }
        }
        return json_encode($result);
    }

}
?>