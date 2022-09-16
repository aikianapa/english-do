<html>
    <div class="row">
        <div class="col-sm-3">
            <wb-module wb="module=filepicker&mode=single&ext=jpg,png,gif,svg" wb-path="/uploads/mod_tgbot" name="image"></wb-module>
        </div>
        <div class="col-sm-9">
            <wb-module wb="module=froalaeditor" name="text"></wb-module>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-sm-3">
            <div class="form-group">
                <label for="my-input">Кнопки в поле ввода</label>
                <wb-module wb="module=switch" name="inline" />
            </div>
        </div>
        <div class="col-sm-9">
            <wb-module wb="module=tagsinput" name="buttons"></wb-module>
        </div>
    </div>
</html>