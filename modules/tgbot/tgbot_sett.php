<html wb-allow="admin">
<input type="hidden" name="__jsonfile">
<div class="form-group row">
    <label class="form-control-label col-sm-4">Включить бота</label>
    <div class="col-sm-8">
        <wb-module wb="module=switch" name="active" />
    </div>
</div>

<div class="form-group row">
    <label class="form-control-label col-sm-4">Degug</label>
    <div class="col-sm-8">
        <wb-module wb="module=switch" name="debug" />
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
        <input class="form-control" type="text" name="phrase" placeholder="Фраза">
    </div>
    <div class="col-sm-6">
        <input class="form-control" type="text" name="command" placeholder="Команда">
    </div>
</wb-multiinput>

</html>