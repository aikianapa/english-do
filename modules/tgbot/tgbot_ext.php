<?php
function tgbot_docs($bot)
{
    $text = "Выберите интересующий вас документ";

    $docs = $bot->app->treeRead('reqlist');

    foreach($docs['tree']['data'] as $doc) {
        if ($doc['active']=='on') {
            $btns[] = [['text'=>$doc['name'], 'callback_data'=>'docs_'.$doc['id']]];
        }
    }

    $keyboard = [
        'inline_keyboard' => $btns
        
    ];

    $msg = ['text' => $text];

    if (count($btns)) {
        $msg['reply_markup'] = json_encode($keyboard,true);
    }
    return $msg;
}
?>