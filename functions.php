<?php
@include_once(__DIR__ . '/engine/modules/yonger/common/scripts/functions.php');
    function siteMenu($path = '') {
        $app = &$_ENV['app'];
        $list = $app->itemList('pages',['filter'=>[
            'active'=>'on'
            ,'path' => $path
            ,'_site'=>$app->vars('_sett.site')
            ,'_login'=>$app->vars('_sett.login')
        ]]);
        $list = $list['list'];
        foreach($list as &$item) {
            $path = $item['path'];
            $name = $item['name'];
            $path.'/'.$name == '/' ? $path = '/home' : $path .= '/'.$name;
            $item['children'] = siteMenu($path);
            $path == '/home' ? $path =  '/' : null;
            $item['path'] = $path;
            if (count($item['children'])) {
                $self = $item;
                $self['divider'] = 'divider-after';
                unset($self['children']);
                array_unshift($item['children'],$self);
            }
        }
        return $list;
    }
?>