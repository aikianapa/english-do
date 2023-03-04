<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/engine/modules/yonger/tpl/assets/css/dashforge.css" />
    <link rel="stylesheet" href="/engine/modules/yonger/tpl/assets/css/yonger.less" />
    <link rel="stylesheet" href="/tpl/css/cabinet.less" />
    <script wb-app src="/engine/modules/yonger/tpl/assets/js/dashforge.js"></script>
    <wb-meta />
</head>

<div wb-if="'{{_sess.user.role}}'!=='student'" class="ht-100v pd-t-100">
    <div class="m-5 row" id="signinForm">
        <div class="p-3 shadow col-sm-4 offset-sm-4 bg-dark tx-white rounded-20">
            <h5 class="tx-center tx-white tx-20">English Do</h5>
            <div class="form-group">
                <label>Card number</label>
                <input wb-mask="9990000000999" class="form-control" type="text" name="card">
            </div>
            <div class="form-group">
                <label>Secret key</label>
                <input class="form-control" type="password" name="secret">
            </div>
            <button type="button" class="btn btn-primary btn-block rounded-20" on-click="signin">Sign in</button>
        </div>
    </div>
    <script wb-app>
        var cabinetSignin = new Ractive({
            el: '#signinForm',
            template: $('#signinForm').html(),
            data: {},
            on: {
                signin(ev) {
                    wbapp.post('/form/users/student_login', {
                        'card': $('#signinForm [name=card]').val(),
                        'secret': $('#signinForm [name=secret]').val()
                    }, function(data) {
                        if (data.error) {
                            wbapp.toast('Error', data.msg, {
                                bgcolor: 'danger'
                            });
                        } else {
                            document.location.href = '/control';
                        }
                    })
                }
            }
        })
    </script>
</div>
<div wb-if="'{{_sess.user.role}}'=='student'" class="container ht-100v scroll-y">
    <div class="row">
        <div class="col">
            <div class="mb-4 card bg-dark tx-white wd-250">
                <div class="card-body">
                    <wb-data wb="table=users&item={{_sess.user.id}}">
                        {{first_name}} {{last_name}}
                        <form id="Profile">
                            <wb-module wb="module=filepicker&mode=single" name="avatar" wb-path="/uploads/users">
                        </form>
                    </wb-data>
                </div>

            </div>


        </div>
        <div class="col">
            <form id="repMemberVisits" wb-off>
                <h4 class="tx-white">Attendance history</h4>
                <input type="month" name="month" value='{{date("Y-m")}}' class="form-control" on-change="changeMonth">
                <ul class="mt-3 list-inline">
                    {{#each list}}
                        <li class="mb-2 list-inline-item btn btn-xs btn-primary">{{day}}</li>
                    {{/each}}
                </ul>
            </form>

            <script wb-app>
                var ready = false;
                var cabinetVisits = new Ractive({
                    el: '#repMemberVisits',
                    template: $('#repMemberVisits').html(),
                    data: {
                        list: []
                    },
                    on: {
                        init() {
                            wbapp.post('/cms/ajax/form/visits/member_visits/{{_sess.user.id}}', {}, function(
                                data) {
                                cabinetVisits.set('list', data)
                            });
                        },
                        changeMonth(ev) {
                            wbapp.post('/cms/ajax/form/visits/member_visits/{{_sess.user.id}}', {
                                month: $(ev.node).val()
                            }, function(data) {
                                cabinetVisits.set('list', data)
                            });
                        }
                    }
                })

                setTimeout(() => {
                    $(document).delegate('.filepicker [name=avatar]', 'change', function() {
                        wbapp.save($("#Profile"), {
                            "table": "users",
                            "item": "{{_sess.user.id}}",
                            "form": "#Profile",
                            "method": "ajax",
                            "silent": true
                        });
                    });

                }, 2000);
                ready = true;
                wbapp.init()
            </script>
            <div class="divider-text tx-white">Current homework</div>
            <ul class="list-group">
                <wb-foreach wb="table=homeworks&sort=date:d&limit=10" wb-filter="{'active':'on','$in': ['{{_sess.user.id}}','$students'] }">
                    <li class="bg-gray-200 cursor-pointer list-group-item" data-ajax="{'url':'/form/homeworks/show/{{id}}','html':'modal'}">{{date}} {{subject}}</li>
                </wb-foreach>
            </ul>
        </div>
    </div>

    <div class="mt-5 mb-5">
        <form id="homeworkUpload">
            <wb-data wb="table=users&item={{_sess.user.id}}">
                <div class="form-group">
                    <div class="divider-text tx-white">Upload you homework files</div>
                    <wb-module name="hw_files" wb="{
                                'module':'filepicker',
                                'mode':'multi',
                                'path':'/uploads/homeworks/students/{{card}}',
                                'button':'Files',
                                'ext': 'mp4,avi,mp3,jpg,gif,png,svg,pdf,txt,doc,docx,xls,xlsx,ppt,pptx',
                                'original': false,
                                'width': '100',
                                'height': '100'
                                }">
                    </wb-module>
                </div>
                <div class="form-group">
                    <div class="divider-text tx-white">Describe you homework</div>
                    <wb-module wb="module=jodit" name="hw_comment">

                    </wb-module>
                </div>
            </wb-data>
        </form>
        <script wb-app>
            let $upform = $('#homeworkUpload')
            $upform.find(':input').on('change', function() {
                let data = $upform.serializeJson()
                let uid = wbapp._session.user.id;
                if (uid > ' ') {
                    delete data['upload_ext']
                    wbapp.post(`/api/v2/update/users/${uid}`, data, function(res) {

                    })
                }
            })
        </script>
    </div>

</div>


<modal>

</modal>
<wb-snippet name="wbapp" />

</html>