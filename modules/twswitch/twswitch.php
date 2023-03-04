<?php
class modTwswitch {
    public $app;
    public $dom;
    function __construct($obj)
    {
        if (wbIsApp($obj)) {
            $app = &$obj;
            if (substr($app->route->mode, -3) == '.js') {
                header('Content-Type: application/javascript');
                echo file_get_contents(__DIR__ . '/' . $app->route->mode);
                exit;
            } else {
                header('HTTP/1.1 404 Not Found');
            }
            exit;
        }
        $this->app = &$obj->app;
        $this->dom = &$obj;
        $this->init();
    }

    function init() {
        $twswitch = $this->app->fromFile(__DIR__ . '/twswitch_ui.php');
        $xref = $twswitch->find("input[x-ref='switch']");
        foreach($this->dom->attributes() as $at => $val) {
            if ($at !== 'class') $xref->attr($at, $val);
        }
        $this->dom->after($twswitch);
        $this->dom->remove();
    }
}
?>