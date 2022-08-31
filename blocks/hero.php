<edit header="Верхняя картинка">
    <div class="alert alert-info">
        Смотри в /blocks/hero.php
    </div>
    <div>
        <wb-include wb-src="/modules/yonger/common/blocks/common.inc.php" />
    </div>
    <div class="form-group row">
        <label class="col-lg-3 form-control-label">Текст</label>
        <div class="col-lg-9">
            <textarea name="text" class="form-control" rows="auto" placeholder="Текст"></textarea>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-lg-4">
            <label class="form-control-label">Кнопка</label>
            <input type="text" name="button" class="form-control" placeholder="Кнопка">
        </div>
        <div class="col-lg-4">
            <label class="form-control-label">Ссылка</label>
            <input type="text" name="link" class="form-control" placeholder="Ссылка">
        </div>
        <div class="col-lg-4">
            <label class="form-control-label">Цвет</label>
            <select name="color" class="form-control">
                <wb-foreach wb="render=server" wb-json='["success","primary","secondary","danger","warning"]'>
                    <option value="{{_val}}">{{_val}}</option>
                </wb-foreach>
            </select>
        </div>
        <div class="col-12">
            <label class="form-control-label">Фоновое изображение</label>
            <wb-module wb="module=filepicker&mode=single" name="bkg" wb-path="/assets/images/backgrounds/" wb-ext="webp,jpg,png,jpeg,svg" />
        </div>
    </div>
</edit>

<view header>

<wb-var style="background: url({{bkg.0.img}}) center center no-repeat; background-size: cover;" wb-if="'{{bkg.0.img}}'>''" else='' />

<section id="hero" class="static-header register-version light clearfix" style="{{_var.style}}">



    <div class="container">
        <div class="signup-wrapper animated hiding" data-animation="bounceInUp" data-delay="1">
            <div class="row">
                <div class="text-heading">
                    <h1 class="animated hiding" data-animation="bounceInDown" data-delay="1">{{header}}</h1>
                    <p class="animated hiding text" data-animation="fadeInDown" data-delay="500">{{text}} {{_sett.phone}}</p>
                    <p><a href="{{link}}" wb-if="button > ''" target="_blank">
                            <img src="/assets/img/btn-vk.png" style="width:200px;margin-top:30px;" alt="{{button}}">
                        </a></p>
                </div>
            </div>
        </div>
    </div>

</section>

</view>