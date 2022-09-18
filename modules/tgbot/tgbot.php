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
    private $chatdb = __DIR__.'/tgbot_chatdb.json';

    public function __construct($app)
    {
        set_time_limit(600);
        $this->sett = wbJsonDecode(file_get_contents(__DIR__.'/tgbot_sett.json'));
        if ($this->sett['active'] !== 'on' && !$app->route->mode) {
      //      exit;
        }

        $this->app = $app;
        $mode = $app->vars('_route.mode');
        $data = file_get_contents('php://input');
        $data = json_decode($data, true);
        $data = (array)$data;
        //file_put_contents(__DIR__.'/log_'.date("j.n.Y").'.log', json_encode($data)."\n\r", FILE_APPEND);

        $this->data = $app->dot($data);
        $this->chat_id = $this->data->get('callback_query') ? $this->data->get('callback_query.message.chat.id') : $this->data->get('message.chat.id');
        $this->storage();

        if ($this->sett['debug'] == 'on') {
            $this->sendMessage(wbJsonEncode($data));
        }

        if ($mode > '' && method_exists($this, $mode)) {
            $this->$mode();
        } elseif ($mode > '') {
            $call = "tgbot_{$mode}";
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
        file_put_contents(__DIR__.'/log_'.date("j.n.Y").'.log', json_encode($this->data->get('message'))."\n\r", FILE_APPEND);
        @$text = trim($this->data->get('message.text'));
        foreach ($this->sett['trans'] as $trans) {
            foreach (explode(',', $trans['phrase']) as $phrase) {
                if (strtolower($trans['phrase']) == strtolower($text)) {
                    $text = $trans['command'];
                    break;
                }
            }
        }
        //$text='/start';
        if (substr($text, 0, 1) == '/') {
            $btns = [];
            $com = substr($text, 1);
            $item = wbTreeFindBranchById($this->sett['menu']['data'], $com);
            if (isset($item['active']) && $item['active'] == 'on') {
                $reply = '';
                if (@isset($item['data']['image'][0]) && $item['data']['image'][0]['img'] > ' ') {
                    $reply .= '<a href="'.$app->vars('_route.host').$item['data']['image'][0]['img'].'">
                    </a>';
                }
                $reply .= '<b>'.$item['name'].'</b>';
                if (strip_tags($item['data']['text']) > '') {
                    $reply .= "\n".$item['data']['text'];
                }

                $keyboard = $this->keyboard($item['data']['buttons']);

                $msg = [
                    'text' => $reply,
                    'reply_markup' => $keyboard
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

    private function striptags($reply)
    {
        $reply = str_replace(['<br>','<br/>','<br />'], "\n", $reply);
        $reply = str_replace(['&nbsp;'], " ", $reply);
        $allowed_tags = ['<b>','<strong>','<u>','<i>','<em>','<u>','<ins>','<s>','<strike>','<del>','<a>','<code>','<pre>'];
        $reply = strip_tags($reply, $allowed_tags);
        return $reply;
    }

        private function keyboard($buttons, $inline = true)
        {
            foreach (explode(',', $buttons) as $btn) {
                if ($btn > '') {
                    $btns[] = ['text'=>$btn, 'callback_data'=>$btn];
                }
            }

            if (!count($btns)) {
                $keyboard = ['remove_keyboard' => true];
            } else {
                $keytype = ($inline == true) ? 'inline_keyboard' : 'keyboard';
                $keyboard = [
                    'resize_keyboard' => true,
                    'one_time_keyboard' =>true,
                    $keytype => [
                        $btns
                    ]
                ];
            }
            return json_encode($keyboard);
        }

        private function cast()
        {
            $chatdb = explode(';', file_get_contents($this->chatdb));
            $chatdb = array_chunk($chatdb, 20);
            $text = $this->app->vars('_post.text');
            $inline = $this->app->vars('_post.inline') == 'on' ? true : false;
            $keyboard = $this->keyboard($this->app->vars('_post.buttons'), $inline);
            foreach ($chatdb as $ch) {
                foreach ($ch as $chat_id) {
                    if ($chat_id > '') {
                        $this->chat_id = $chat_id;
                        $msg = ['text' => $text,'reply_markup' => $keyboard];
                        $this->send('sendMessage', $msg);
                    }
                }
                sleep(1);
            }
            exit;
        }


    public function storage($mode = null)
    {
        if ($mode == null) {
            $chatdb = explode(';', file_get_contents($this->chatdb));
            if (!in_array($this->chat_id, $chatdb)) {
                $chatdb[] = $this->chat_id;
                file_put_contents($this->chatdb, implode(';', $chatdb));
            }
        }
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
        if (isset($response['text'])) {
            $response['parse_mode'] = 'HTML';
            $response['text'] = $this->striptags($response['text']);
        }
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
