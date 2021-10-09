<?php
    function customRoute($route = []) {
        $app = &$_ENV['app'];
        $pages = $app->itemList('pages',['filter'=>[
            "_site"=>$app->vars('_sett.site'),
            "_login"=>$app->vars('_sett.login'),
            "url" => $app->route->uri
        ]]);
        foreach($pages['list'] as $page) {
            if ($page['url'] == $app->route->uri) {
                $app->route->controller = 'form';
                $app->route->mode = 'show';
                $app->route->table = 'pages';
                $app->route->item = $page['_id'];
                $app->route->tpl = "page.php";
                $app->vars('_route',$app->objToArray($app->route));
                break;
            }
        }
    }

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

    function _beforeItemSave(&$item) {
        $app = &$_ENV['app'];
        $item['_site'] = $app->vars('_sett.site');
        $item['_login'] = $app->vars('_sett.login');
        return $item;
    }
?>