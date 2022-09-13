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
                            <div class="form-group col-md-4" id="{{_form}}EditFormPeriod">
                                <label class="form-control-label">
                                    <a href="#period" on-click="setView">Период</a> /
                                    <a href="#once" on-click="setView">Разово</a>
                                </label>
                                <input type="month" name="period" class="form-control" placeholder="Период" required>
                                <input type="date" name="date" class="form-control" placeholder="Дата" required>
                                <input type="checkbox" name="once" value="{{once}}" class="d-none">
                            </div>
                            <script>
                                var moneyPeriod = new Ractive({
                                    el: '#{{_form}}EditFormPeriod',
                                    template: $('#{{_form}}EditFormPeriod').html(),
                                    on: {
                                        init() {
                                            let that = this
                                            setTimeout(function() {
                                                that.fire('setView')
                                            }, 100)
                                        },
                                        setView(ev, value) {
                                            if (ev.node == undefined) {
                                                if ($(moneyPeriod.find('[name=once]')).val() == 'on') {
                                                    $(moneyPeriod.find('[name=once]')).prop('checked', true)
                                                } else {
                                                    $(moneyPeriod.find('[name=once]')).prop('checked', false)
                                                }
                                            } else {
                                                if ($(ev.node).attr('href') == '#once') {
                                                     $(moneyPeriod.find('[name=once]')).prop('checked', true)
                                                } else {
                                                    $(moneyPeriod.find('[name=once]')).prop('checked', false)
                                                }
                                            }
                                            let once = $(moneyPeriod.find('[name=once]')).prop('checked')

                                            if (once == true) {
                                                $(moneyPeriod.find('[name=period]')).addClass('d-none');
                                                $(moneyPeriod.find('[name=date]')).removeClass('d-none');
                                            } else {
                                                $(moneyPeriod.find('[name=date]')).addClass('d-none');
                                                $(moneyPeriod.find('[name=period]')).removeClass('d-none');
                                            }

                                        }
                                    }
                                })
                            </script>

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