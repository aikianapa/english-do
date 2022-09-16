<?php

use Adbar\Dot;

if (is_file(__DIR__.'/tgbot_ext.php')) {
    include __DIR__.'/tgbot_ext.php';
}

class modTgbot
{
    public $app;
    private $token;
    private $chat_id;
    public $data;
    private $is_command;
    public $sett;

    public function __construct($app)
    {
        set_time_limit(600);
        $this->sett = wbJsonDecode(file_get_contents(__DIR__.'/tgbot_sett.json'));
        if ($this->sett['active'] !== 'on' && !$app->route->mode) {
      //      exit;
        }

        $this->app = $app;
        
        $data = file_get_contents('php://input');
        $data = json_decode($data, true);
        $data = (array)$data;
        //file_put_contents(__DIR__.'/log_'.date("j.n.Y").'.log', json_encode($data)."\n\r", FILE_APPEND);

        $this->data = $app->dot($data);
        $this->chat_id = $this->data->get('callback_query') ? $this->data->get('callback_query.message.chat.id') : $this->data->get('message.chat.id');

        if ($this->sett['debug'] == 'on') {
            $this->sendMessage(wbJsonEncode($data));
        }

        if ($app->route->mode) {
                $call = "tgbot_{$app->route->mode}";
                if (is_callable($call)) {
                    $msg = $call($this);
                    print_r($msg);
                }
        }

        if ($this->data->get('callback_query')) {
            $this->callback();
        } 
        $this->message();

        exit;
    }

    public function callback()
    {
        $data = (array)$this->data->get('callback_query');
        $this->data = $this->app->dot($data);
            if ($this->data->get('data.mode')) {
                $text = $this->data->get('data.mode');
            } else {
                $text = $this->data->get('data');
            }
            $this->data->set('message.text', $text);
    }

    public function message()
    {
        $app = &$this->app;
//        file_put_contents(__DIR__.'/log_'.date("j.n.Y").'.log', json_encode($this->data->get('message'))."\n\r", FILE_APPEND);
        @$text = trim($this->data->get('message.text'));
        foreach ($this->sett['trans'] as $trans) {
            if (strtolower($trans['phrase']) == strtolower($text)) {
                $text = $trans['command'];
            }
        }
        //$text='/start';
        if (substr($text, 0, 1) == '/') {
            $btns = [];
            $com = substr($text, 1);
            $item = wbTreeFindBranchById($this->sett['menu']['data'], $com);
            if (isset($item['active']) && $item['active'] == 'on') {
                $reply = '';
                if (isset($item['data']['image']) && $item['data']['image'][0]['img'] > ' ') {
                    $reply .= '<a href="'.$app->vars('_route.host').$item['data']['image'][0]['img'].'">
                    </a>';
                }
                $reply .= '<b>'.$item['name'].'</b>';
                if (strip_tags($item['data']['text']) > '') {
                    $reply .= "\n".$item['data']['text'];
                }
                foreach (explode(',', $item['data']['buttons']) as $btn) {
                    $btns[] = ['text'=>$btn, 'callback_data'=>$btn];
                }

                $reply = str_replace(['<br>','<br/>','<br />'], "\n", $reply);
                $reply = str_replace(['&nbsp;'], " ", $reply);

                if (!count($btns)) {
                    $keyboard = ['remove_keyboard' => true];
                } else {
                    $keytype = $item['data']['inline'] == 'on' ? 'inline_keyboard' : 'keyboard';

                    $keyboard = [
                        'resize_keyboard' => true,
                        'one_time_keyboard' =>true,
                        $keytype => [
                            $btns
                        ]
                    ];
                }

                $allowed_tags = ['<b>','<strong>','<u>','<i>','<em>','<u>','<ins>','<s>','<strike>','<del>','<a>','<code>','<pre>'];

                $msg = [
                    'chat_id' => $this->chat_id,
                    'text' => strip_tags($reply, $allowed_tags),
                    'parse_mode' => 'HTML',
                    'reply_markup' => json_encode($keyboard)
                ];

                $this->send('sendMessage', $msg);
            } else {
                $call = "tgbot_{$com}";
                if (is_callable($call)) {
                    $msg = $call($this);
                    $this->send('sendMessage', $msg);
                } else {
                    $this->error();
                }
            }
        } else {
            $this->error();
        }
        exit;
    }

    public function error($text=null, $btns = null)
    {
        if ($btns == null) {
            $btns[] =['text'=>'Старт', 'callback_data'=>'/start'];
            $btns[] =['text'=>'Справка', 'callback_data'=>'/help'];
        }

        if ($text==null) {
            $text= "Я вас не понял!\nВоспользуйтесь командой /help для получения списка доступных запросов.";
        }
        $keyboard = [
            'resize_keyboard' => true,
            'one_time_keyboard' =>true,
            'keyboard' => [
                $btns
            ]
        ];

        $msg = [
            'text' => $text,
            'reply_markup' => json_encode($keyboard)
        ];
        $this->send('sendMessage', $msg);
    }
    public function sendMessage($text)
    {
        $msg = [
                    'text' => $text
                ];
        return $this->send('sendMessage', $msg);
    }
    public function send($method, $response)
    {
        $response['chat_id'] = $this->chat_id;
        $response['parse_mode'] = 'HTML';
        $ch = curl_init('https://api.telegram.org/bot' . $this->sett['token'] . '/' . $method);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }
}
