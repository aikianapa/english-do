<html>
<div class="modal fade effect-scale show removable" id="modalMoneyEdit" data-backdrop="static" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header row">
                <div class="col-5">
                    <h5>Оплата</h5>
                </div>
                <div class="col-7">
                    <h5 class='header'></h5>
                </div>
                <i class="fa fa-close r-20 position-absolute cursor-pointer" data-dismiss="modal" aria-label="Close"></i>
            </div>
            <div class="modal-body pd-20">
                <form class="row" method="post" id="{{_form}}EditForm">
                    <div class="col-12">

                            <div class="form-group">
                                <label class="form-control-label">Студент</label>
                                <select class="form-control" wb-select2 placeholder="Студент" name="student" required>
                                    <wb-foreach wb="table=users" wb-filter="active=on&role=student">
                                        <option value="{{id}}">{{last_name}} {{first_name}}</option>
                                    </wb-foreach>
                                </select>
                            </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="form-control-label">Период</label>
                                <input type="month" name="period" class="form-control" placeholder="Период" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label class="form-control-label">Сумма</label>
                                <input type="number" name="amount" class="form-control" placeholder="Сумма" required>
                            </div>

                            <div class="form-group  col-md-4">
                                <label class="form-control-label">Тип оплаты</label>
                                <select class="form-control" wb-select2 placeholder="" name="account">
                                        <option value="cash">Наличные</option>
                                        <option value="card">Безналичные</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label">Примечание</label>
                            <textarea class="form-control" name="text" placeholder="Примечание"></textarea>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer pd-x-20 pd-b-20 pd-t-0 bd-t-0">
                <wb-include wb="{'form':'common_formsave.php'}" />
            </div>
        </div>
    </div>
</div>

</html>