<html>
<div class="m-3" id="yongerSpace">
    <nav class="nav navbar navbar-expand-md col">
        <h3 class="tx-bold tx-spacing--2 order-1">Homeworks</h3>
        <div class="ml-auto order-2 float-right">
            <a href="#" data-ajax="{'url':'/cms/ajax/form/homeworks/check','html':'#yongerSpace'}"
                class="btn btn-success">
                <img src="/module/myicons/24/FFFFFF/checkmark-done-check.5.svg" width="24" height="24" /> Check
            </a>

            <a href="#" data-ajax="{'url':'/cms/ajax/form/homeworks/edit/_new','html':'#yongerSpace modals'}"
                class="btn btn-primary">
                <img src="/module/myicons/24/FFFFFF/item-select-plus-add.svg" width="24" height="24" /> Create
            </a>
        </div>
    </nav>

    <div class="yonger-nested mb-1">
        <span class="bg-light">
            <div class="header p-2">
                <span clsss="row">
                    <div class="col-3">
                    <input class="form-control" type="search" placeholder="Поиск..."
                    data-ajax="{'target':'#{{_form}}List','filter_add':{'$or':[{ 'fDate': {'$like' : '$value'} }, { 'subject': {'$like' : '$value'} }, { 'fStudents': {'$like' : '$value'} }  ]} }">
                    </div>
                </span>
            </div>
        </span>


        <table class="table table-striped table-hover tx-15">
            <thead>
                <tr>
                    <td>Дата</td>
                    <td>Тема</td>
                    <td>Студенты</td>
                    <td class="text-right">Действия</td>
                </tr>
            </thead>
            <tbody id="{{_form}}List">
                <wb-foreach wb="{'ajax':'/api/query/{{_form}}/',
                            'render':'server',
                            'bind':'cms.list.{{_form}}',
                            'sort':'date:d',
                            'size':'{{_sett.page_size}}',
                            'filter': {'_site':'{{_sett.site}}'}
                }">
                    <tr class="bg-transparent">
                        <td data-ajax="{'url':'/cms/ajax/form/homeworks/edit/{{_id}}','html':'#yongerSpace modals'}">
                            <span class="tx-13 tx-inverse tx-semibold mg-b-0">{{date}}</span>
                        </td>
                        <td class="w-25">
                            {{subject}}
                        </td>
                        <td class="w-25 tx-12">
                            {{fStudents}}
                        </td>

                        <td class="text-right">
                            <div class="custom-control custom-switch d-inline">
                                <input type="checkbox" class="custom-control-input" name="active"
                                    id="{{_form}}SwitchItemActive{{_idx}}"
                                    onchange="wbapp.save($(this),{'table':'{{_form}}','id':'{{_id}}','field':'active','silent':true})">
                                <label class="custom-control-label"
                                    for="{{_form}}SwitchItemActive{{_idx}}">&nbsp;</label>
                            </div>
                            <a href="javascript:"
                                data-ajax="{'url':'/cms/ajax/form/homeworks/edit/{{_id}}','update':'cms.list.{{_form}}','html':'#yongerSpace modals'}"
                                class=" d-inline"><img src="/module/myicons/24/323232/content-edit-pen.svg" width="24"
                                    height="24"></a>
                            <a href="javascript:"
                                data-ajax="{'url':'/ajax/rmitem/{{_form}}/{{_id}}','update':'cms.list.{{_form}}','html':'#yongerSpace modals'}"
                                class=" d-inline"><img src="/module/myicons/24/323232/trash-delete-bin.2.svg" width="24"
                                    height="24"></a>
                        </td>
                    </tr>
                </wb-foreach>
            </tbody>
        </table>
    </div>
    <modals></modals>
</div>

</html>