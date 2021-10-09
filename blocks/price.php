<edit header="Прайс-лист">
    <wb-include wb-src="/modules/yonger/common/blocks/common.inc.php" />
    <div class="row">
        <div class="col-12">
                <div class="form-group">
                    <label class="control-label">Текст под заголовком</label>
                    <textarea class="form-control" name="text" rows="auto"></textarea>
                </div>

            <wb-multiinput name="price">
                <div class="col-12">
                    <input class="form-control" type="text" name="title" placeholder="Заголовок">
                </div>
                <div class="col-4">
                    <input class="form-control" type="number" name="price" placeholder="Цена">
                </div>
                <div class="col-8">
                    <input class="form-control" type="text" name="sub" placeholder="Подпись под ценой">
                </div>
                <div class="col-12">
                    <textarea class="form-control" name="text" rows="auto" placeholder="Описание"></textarea>
                </div>
            </wb-multiinput>
                <div class="form-group">
                    <label class="control-label">Текст внизу</label>
                    <textarea class="form-control" name="sub" rows="auto"></textarea>
                </div>

        </div>
    </div>
</edit>

<view>
<section>
        <div class="container">
            <div class="section-header animated hiding" data-animation="fadeInDown">
                <h2>{{header}}</h2>
                <div class="sub-heading text">
                    {{text}}
                </div>
            </div>
            <div class="section-content row">
                <wb-foreach wb="from=price">
                <div class="col-sm-4 mb-20">
                    <div class="package-column animated hiding" data-animation="flipInY">
                        <div class="package-title">{{title}}</div>
                        <div class="package-price">
                            <div class="price"><span class="currency"></span>{{price}}</div>
                            <div class="period">{{sub}}</div>
                        </div>
                        <div class="package-detail">
                            <ul class="list-unstyled">
                                <li>{{text}}</li>
                            </ul>
                            <a href="#" class="btn btn-secondary btn-block">Записаться!</a>
                        </div>
                    </div>
                </div>
                </wb-foreach>
            </div>

        </div>
    </section>

</view>