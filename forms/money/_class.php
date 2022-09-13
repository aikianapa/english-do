<?php
class moneyClass extends cmsFormsClass {
    function afterItemRead(&$item)
    {
        if ($this->app->vars('_route.mode') == 'list') {
            $this->prepareItem($item);
        }
        $item["header"] = $item["fullname"];
    }

    function afterItemSave(&$item) {
        $this->prepareItem($item);
    }

    function prepareItem(&$item) {
        $student = $this->app->itemRead('users', $item['student']);
        $item['fullname'] = $student['last_name'] .' '. $student['first_name'] ;

        @$tmp = explode('-', $item['period']);
        $item['period'] = implode('.', array_reverse($tmp));

        @$tmp = explode('-', $item['date']);
        $item['date'] = implode('.', array_reverse($tmp));


    }
}
?>