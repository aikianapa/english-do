<?php
class visitsClass extends cmsFormsClass
{

    function afterItemRead(&$item) {
        $item['month'] = date('Y-m', strtotime($item['date']));
        $item['day'] = date('d', strtotime($item['date']));
    }

    function scan()
    {
        $code = $_GET['card'];
        $get = $this->app->itemList('users', ["filter" => [
            'active' => 'on',
            'card' => $code
        ]]);
        header("Content-type:application/json");
        if ($get['count'] > 0) {
            $member = array_shift($get['list']);
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

    function get()
    {
        header("Content-type:application/json");
        $result = [
            'error' => true,
            'msg' => 'Посещение не зафиксировано',
            'status' => false
        ];
        $uid = $this->app->vars('_post.uid');
        $date = $this->app->vars('_post.date');
        if ($uid > '' && $date > '2000') {
            $id = 'id' . md5($uid . $date);
            $check = $this->app->itemRead('visits', $id);
            if ($check) {
                $result = [
                    'error' => false,
                    'msg' => 'Посещение отмечено',
                    'status' => true
                ];
            } else {
                $result = [
                    'error' => false,
                    'msg' => 'Посещение не зафиксировано',
                    'status' => false
                ];
            }
        }
        return json_encode($result);
    }


    function check()
    {
        header("Content-type:application/json");
        $result = [
            'error' => true,
            'msg' => 'Ошибка',
            'check' => null
        ];
        $uid = $this->app->vars('_post.uid');
        $date = $this->app->vars('_post.date');
        if ($uid > '' && $date > '2000') {
            $id = 'id' . md5($uid . $date);
            $item = [
                'id' => $id,
                'date' => $date,
                'uid' => $uid
            ];
            $check = $this->app->itemSave('visits', $item);
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

    function uncheck()
    {
        header("Content-type:application/json");
        $result = [
            'error' => true,
            'msg' => 'Ошибка',
            'check' => null
        ];
        $uid = $this->app->vars('_post.uid');
        $date = $this->app->vars('_post.date');
        if ($uid > '' && $date > '') {
            $id = 'id' . md5($uid . $date);
            $check = $this->app->itemRemove('visits', $id);
            if ($check && isset($check['_removed']) && $check['_removed'] == 'true') {
                $result = [
                    'error' => false,
                    'msg' => 'Посещение удалено',
                    'check' => $check
                ];
            }
        }
        return json_encode($result);
    }

    public function rep_month()
    {
        $app = $this->app;
        $form = $app->fromFile(__DIR__ . "/rep_month.php");
        $list = [];
        $line = [];
        $rep = [];
        $month = $app->vars('_post.formdata.month');
        if ($month == "") {
            $month = date('Y-m');
        }
        if ($month > "") {
            $mon = explode("-", $month);
            $days = cal_days_in_month(CAL_GREGORIAN, $mon[1], $mon[0]);
            for ($i = 1; $i <= $days; $i++) {
                $day = $i < 10 ? '0'.$i : ''.$i;
                $line[$i] = $day;
            }
            $list = $this->app->itemList("visits", ['filter' => [
                '$and' => [
                    'date' => [
                        '$gte' => $month . '-01',
                        '$lte' => $month . '-31'
                    ],
                ]
            ], 'sort' => 'date:d','return'=>'uid,date']);
            $list = $this->app->json($list['list']);
            $list = $list->groupBy('uid')->get();
            foreach($list as &$item) {
                $arr = [];
                foreach($item as $iday) {
                    $arr[] = $iday['date'];
                }
                $item = $arr;
            }
        }
        $form->fetch(['rep' => $list, 'days' => $line, 'month'=>$month]);
        echo $form->outer();
        die;
    }

    public function member_visits() {
        $app = $this->app;
        $uid = $app->vars('_route.id');
        $month = $app->vars('_post.month');
        $month == "" ? $month = date('Y-m') : null;
        $list = $this->app->itemList("visits", ['filter' => [
            '$and' => [
                'date' => [
                    '$gte' => $month . '-01',
                    '$lte' => $month . '-31',
                    'uid' => $uid
                ]
            ]
        ], 'sort' => 'date:a','return'=>'date']);
        $list = array_values($list['list']);
        foreach($list as &$date) {
            $date['day'] = date('d',strtotime($date['date']));
            $date['weekday'] = date('w',strtotime($date['date']));
        }
        header("Content-type:application/json");
        echo wbJsonEncode($list);
    }
}
