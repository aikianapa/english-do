<html wb-allow="admin">
<input type="hidden" name="__jsonfile">

<button type="button" data-toggle="modal" data-target="#tgbotModal" class="btn btn-info pos-absolute r-0 t-20">Сообщение всем</button>

<div id="tgbotModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="tgbotModal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <ul class="nav" data-wb-allow="admin">
                    <li class="nav-item">
                        <button class="btn btn-sm btn-danger"  onclick="tgbotCast()" type="button">
                            <i class="fa fa-send"> Отправить</button>
                    </li>
                    <li class="nav-item"></li>
                </ul>
                <a class="btn btn-sm btn-light ml-1" href="#" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-close"> Закрыть</a>
            </div>
            <div class="modal-body">
                <div id="tgbotFormCast">
                    <wb-include file="./tgbot_dict.php" />
                </div>
            </div>
        </div>
    </div>
    <script>
        var tgbotCast = function() {
            var form = $('<form></form>').html($('#tgbotFormCast').clone());
            let post = form.serializeJson();
            wbapp.post('/module/tgbot/cast',post,function(res){
                console.log(res);
            })
        }
    </script>
</div>

<div class="form-group row">
    <label class="form-control-label col-sm-4">Включить бота</label>
    <div class="col-sm-8">
        <wb-module wb="module=switch" name="active" />
    </div>
</div>

<div class="form-group row">
    <label class="form-control-label col-sm-4">Debug</label>
    <div class="col-sm-8">
        <wb-module wb="module=switch" name="debug" />
    </div>
</div>

<div class="form-group row">
    <label class="form-control-label col-sm-4">Bot ID</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" name="botid" placeholder="@botid" />
    </div>
</div>

<div class="form-group row">
    <label class="form-control-label col-sm-4">Токен</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" name="token" />
    </div>
</div>
<div class="divider-text">Команды</div>
<input wb-tree name="menu">
<div class="divider-text">Трансляция</div>
<wb-multiinput name="trans">
    <div class="col-sm-6">
        <input class="form-control" wb-module="module=tagsinput" type="text" name="phrase" placeholder="Фраза">
    </div>
    <div class="col-sm-6">
        <input class="form-control" type="text" name="command" placeholder="Команда">
    </div>
</wb-multiinput>

</html>