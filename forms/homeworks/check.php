<html>
<div class="m-3" id="blockHomework" wb-allow="admin,reg">
    <div id="homeworkList" wb-off>
    <nav class="nav navbar navbar-expand-md col">
        <h3 class="tx-bold tx-spacing--2 order-1">Студенты</h3>
        <button class="navbar-toggler order-2" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
            <i class="wd-20 ht-20 fa fa-ellipsis-v"></i>
        </button>

        <div class="collapse navbar-collapse order-2" id="navbarSupportedContent">
            <form class="form-inline mg-t-10 mg-lg-0  ml-auto" onsubmit="javascript:return">
                <div class="form-group">
                    <input class="form-control mg-r-10 col-auto" type="search" placeholder="Поиск..." aria-label="Поиск..." on-keyup="find">
                    <a href="#" data-ajax="{'url':'/cms/ajax/form/homeworks/list','html':'.content-body'}" class="btn btn-primary">
                        <img src="/module/myicons/24/FFFFFF/checklist.svg" width="24" height="24" /> Back to homeworks
                    </a>
                </div>
            </form>
        </div>
    </nav>
    <ul class="list-group">
            {{#each result}}
            <li data-id="{{.id}}" class="list-group-item">
                <div><span class="badge badge-info">{{._lastdate}}</span> {{.last_name}} {{.first_name}}</div>
                <div class="tx-right pos-absolute t-10 r-10">

                    <a href="javascript:" data-ajax="{'url':'/cms/ajax/form/homeworks/view/{{.id}}','html':'#blockHomework modals'}" class="d-inline">
                        <img src="/module/myicons/content-edit-pen.svg?size=24&stroke=323232">
                    </a>
                </div>
            </li>
            {{else}}
            <li class="list-group-item">
                <p>Items not found...</p>
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
        var form = "users"
        var base = api + "/list/" + form + "/?@size=100&@sort=_lastdate:d"
        var filter = {active:'on',role:'student'}
        var homeworkList = new Ractive({
            el: "#homeworkList",
            template: $("#homeworkList").html(),
            data: {
                "base": base,
                "result": [],
                "pagination": [],
            },
            on: {
                init() {
                    wbapp.post(`${base}`, {filter: filter}, function(data) {
                        homeworkList.fire("setData", null, data)
                    })
                },
                setData(ev, data) {
                    homeworkList.set("result", data.result);
                    homeworkList.set("pagination", data.pagination);
                    homeworkList.set("page", data.page);
                    homeworkList.set("pages", data.pages);
                },
                setPage(ev) {
                    let page = $(ev.node).attr("data-page");
                    this.fire("loadPage", page)
                    return false
                },
                find(ev) {
                    let value = $(ev.node).val()
                    wbapp.post(`${base}`, {
                        filter: {
                            '$or': [{
                                    'first_name': {
                                        '$like': value
                                    }
                                },
                                {
                                    'last_name': {
                                        '$like': value
                                    }
                                }
                            ],
                            active:'on',
                            role: 'student'
                        }
                    }, function(data) {
                        homeworkList.fire("setData", null, data)
                    })
                },
                loadPage(ev, page) {
                    wbapp.post(`${base}&@page=${page}`, {filter: filter}, function(data) {
                        homeworkList.fire("setData", null, data)
                    })
                }
            }
        })
    </script>
    <modals></modals>
</div>

</html>