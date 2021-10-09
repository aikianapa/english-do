<?php
class homeworksClass extends cmsFormsClass {
    function beforeItemShow(&$item) {
        isset($item['date']) ? $item['date'] = date('d.m.Y',strtotime($item['date'])) : null;
    }
    
    function afterItemRead(&$item)
    {
        $app = &$this->app;
        if ($app->vars('_env.tmp.users')) {
            $users = $app->vars('_env.tmp.users');
        } else {
            $users = $app->itemList('users',['filter'=>['active'=>'on','role'=>'student']]);
            $users = $users['list'];  
            $app->vars('_env.tmp.users',$users);
        }
        $item['fStudents'] = json_decode($item['students'],true);
        $name = '';
        foreach($item['fStudents'] as $uid) {
            $name > '' ? $name.=', ' : null;
            $user = $users[$uid];
            $name .= $user['first_name']. ' '.$user['last_name'];
        }
        $item['fStudents'] = $name;
        isset($item['date']) ? $item['fDate'] = date('d.m.Y',strtotime($item['date'])) : $item['fDate'] = '';
    }
}
?>