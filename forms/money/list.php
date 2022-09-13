<html>
<div class="m-3" id="blockMoney" wb-allow="admin,reg">
    <div id="moneyList" wb-off>
    <nav class="nav navbar navbar-expand-md col">
        <h3 class="tx-bold tx-spacing--2 order-1">Финансы</h3>
        <button class="navbar-toggler order-2" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
            <i class="wd-20 ht-20 fa fa-ellipsis-v"></i>
        </button>

        <div class="collapse navbar-collapse order-2" id="navbarSupportedContent">
            <form class="form-inline mg-t-10 mg-lg-0  ml-auto" onsubmit="javascript:return false">
                <div class="form-group">
                    
                    <div class="input-group mg-r-10">
                        <input class="form-control col-auto" type="search" placeholder="Поиск..." aria-label="Поиск..." on-change="find">
                        <div class="input-group-append">
                            <span class="input-group-text cursor-pointer" onclick="javascript:$(this).parents('.input-group').children('input').trigger('change')">Найти</span>
                        </div>
                    </div>

                    <a href="#" data-ajax="{'url':'/cms/ajax/form/money/edit/_new','html':'.content-body modals'}" class="btn btn-primary">
                        <img src="/module/myicons/24/FFFFFF/item-select-plus-add.svg" width="24" height="24" /> Добавить оплату
                    </a>
                </div>
            </form>
        </div>
    </nav>
    <ul class="list-group">
            {{#each result}}
            <li data-id="{{.id}}" class="list-group-item">
                <div class="row">
                <div class="col-sm-2">
                    {{#if .once == 'on'}}
                    <span class="badge badge-warning">{{.date}}</span>
                    {{else}}
                    <span class="badge badge-info">{{.period}}</span>
                    {{/if}}
                </div>
                <div class="col-sm-4">{{.fullname}}</div>
                <div class="col-sm-2 tx-12">{{.amount}}₽</div>
                <div class="col-sm-2 tx-12">{{.account}}</div>
                <div class="tx-right pos-absolute t-10 r-10">

                    <a href="javascript:" data-ajax="{'url':'/cms/ajax/form/money/edit/{{.id}}','html':'.content-body modals'}" class="d-inline">
                        <img src="/module/myicons/content-edit-pen.svg?size=24&stroke=323232">
                    </a>

                    <div class="dropdown dropright d-inline">
                        <a class="cursor-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="/module/myicons/trash-delete-bin.2.svg?size=24&stroke=dc3545" class="d-inline">
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#" on-click="remove">
                                <span class="fa fa-trash tx-danger"></span> Удалить</a>
                            <a class="dropdown-item" href="#">
                                <span class="fa fa-close tx-primary"></span> Отмена</a>
                        </div>
                    </div>
                </div>
                </div>
            </li>
            {{else}}
            <li class="list-group-item">
                <p>Ничего не найдено...</p>
            </li>
            {{/each}}
        </ul>
        {{#~/pages }} {{#if ~/pages != 1 }}
        <nav aria-label="Page navigation">
            <ul class="pagination mg-b-0 mg-t-10">
                {{#each pagination}} {{#if ~/page == .page}}
                <li class="page-item active">
                    <a class="page-link" data-page="{{.page}}" on-click="setPage" href="#">
                        {{.label}}
                    </a>
                </li>
                {{/if}} {{#if ~/page != .page}}
                <li class="page-item">
                    <a class="page-link" data-page="{{.page}}" on-click="setPage" href="#">
                        {{#if .label == "prev"}}
                        <img src="/module/myicons/interface-essential-181.svg?size=18&stroke=0168fa"
                            class="d-inline">{{/if}} {{#if .label == "next"}}
                        <img src="/module/myicons/interface-essential-35.svg?size=18&stroke=0168fa"
                            class="d-inline">{{/if}} {{#if .label != "prev"}}{{#if .label != "next"}}{{.label}}{{/if}}{{/if}}
                    </a>
                </li>
                {{/if}} {{/each}}
            </ul>
        </nav>
        {{/if}} {{/pages}}
    </div>
    <script>
        var api = "/api/v2"
        var form = "money"
        var base = api + "/list/" + form + "/?@size=12&@sort=_created:d"
        var moneyList = new Ractive({
            el: "#moneyList",
            template: $("#moneyList").html(),
            data: {
                "base": base,
                "result": [],
                "pagination": [],
            },
            on: {
                init() {
                    wbapp.post(`${base}`, {}, function(data) {
                        moneyList.fire("setData", null, data)
                    })
                },
                setData(ev, data) {
                    moneyList.set("result", data.result);
                    moneyList.set("pagination", data.pagination);
                    moneyList.set("page", data.page);
                    moneyList.set("pages", data.pages);
                },
                setPage(ev) {
                    let page = $(ev.node).attr("data-page");
                    this.fire("loadPage", page)
                    return false
                },
                remove(ev) {
                    let id = $(ev.node).parents('[data-id]').attr('data-id');
                    let result = moneyList.get("result")
                    let page = moneyList.get("page") * 1
                    let pages = moneyList.get("pages") * 1
                    delete result[id]
                    if (Object.keys(result).length == 0 && pages > 0 && page >= pages) page--
                        wbapp.post(`${api}/delete/${form}/${id}`, {}, function(data) {
                            if (data.error == false) {
                                moneyList.fire("loadPage", page)
                            }
                        });
                },
                find(ev) {
                    let value = $(ev.node).val()
                    wbapp.post(`${base}`, {
                        filter: {
                            '$or': [{
                                    'fullname': {
                                        '$like': value
                                    }
                                },
                                {
                                    'account': {
                                        '$like': value
                                    }
                                },
                                {
                                    'period': {
                                        '$like': value
                                    }
                                }
                            ]
                        }
                    }, function(data) {
                        moneyList.fire("setData", null, data)
                    })
                },
                loadPage(ev, page) {
                    wbapp.post(`${base}&@page=${page}`, {}, function(data) {
                        moneyList.fire("setData", null, data)
                    })
                }
            }
        })

        $(document).undelegate("#moneyEditForm", 'wb-form-save');
        $(document).delegate("#moneyEditForm", 'wb-form-save', function(ev, res) {
            if (res.params.item !== undefined && res.data !== undefined) {
                moneyList.set("result." + res.data.id, res.data);
            }
        })
    </script>
    <modals></modals>
</div>

</html>