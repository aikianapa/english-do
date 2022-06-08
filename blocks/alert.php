<edit header="Всплавающее окно сообщения">
    <div>
        <wb-include wb-src="/modules/yonger/common/blocks/common.inc.php" />
    </div>
    <div class="form-group">
        <label>Заголовок</label>
        <input class="form-control" type="text" name="title">
    </div>
    <div>
        <wb-module wb="module=editor" name="alert"></wb-module>
    </div>
</edit>

<view>
    <div id="modalAlert" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabelLarge">{{title}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{alert}}</p>
                </div>
            </div>
        </div>
    </div>
    <script wb-app>
        setTimeout(function() {
            $("#modalAlert").modal("show")
        }, 500)
    </script>
</view>