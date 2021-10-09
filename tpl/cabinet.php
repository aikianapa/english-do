<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/engine/modules/yonger/tpl/assets/css/dashforge.css" />
    <link rel="stylesheet" href="/engine/modules/yonger/tpl/assets/css/yonger.less" />
    <link rel="stylesheet" href="/tpl/css/cabinet.less" />
    <script wb-app src="/engine/modules/yonger/tpl/assets/js/dashforge.js"></script>
    <script wb-app src="/engine/modules/yonger/tpl/assets/js/yonger.js"></script>
</head>
<body>
<div wb-if="'{{_sess.user.role}}'!=='student'" class="ht-100v pd-t-100">
    <div class="row m-5">
        <div class="col-sm-4 offset-sm-4 bg-dark tx-white p-3 rounded-20 shadow">
            <h5 class="tx-center tx-white tx-20">English Do</h5>
            <div class="form-group">
                <label>Card number</label>
                <input  wb-mask="9990000000999" class="form-control" type="text" name="card">
            </div>
            <div class="form-group">
                <label>Secret key</label>
                <input class="form-control" type="password" name="secret">
            </div>
            <button type="button" class="btn btn-primary btn-block rounded-20">Sign in</button>
        </div>
    </div>
</div>
<div wb-if="'{{_sess.user.role}}'=='student'" class="ht-100v container">
    <div class="card bg-dark tx-white wd-250 mb-4">
        <div class="card-body">
        <wb-data wb="table=users&item={{_sess.user.id}}">
        {{first_name}} {{last_name}}
        <form id="Profile">
        <wb-module wb="module=filepicker&mode=single" name="avatar" wb-path="/uploads/users" >
        </form>
    </wb-data>
    </div>

    </div>
    
    
    <ul class="list-group">
        <wb-foreach wb="table=homeworks" wb-filter="{'active':'on','$in': ['{{_sess.user.id}}','$students'] }">
            <li class="list-group-item bg-gray-200 cursor-pointer" data-ajax="{'url':'/form/homeworks/show/{{id}}','html':'modal'}">{{date}} {{subject}}</li>
        </wb-foreach>
    </ul>
</div>
<modal>

</modal>
    <script wb-app remove>
        var ready = false;
        $('.btn-primary').on('click',function(){
            wbapp.post('/form/users/student_login',{
                'card':$('[name=card]').val(),
                'secret':$('[name=secret]').val()
            },function(data){
                if (data.error) {
                    wbapp.toast('Error',data.msg,{bgcolor:'danger'});
                } else {
                    document.location.href = '/control';
                }
            })
        });
        setTimeout(() => {
        $(document).delegate('.filepicker [name=avatar]','change',function(){
            wbapp.save($("#Profile"),{"table":"users","item":"{{_sess.user.id}}","form":"#Profile","method":"ajax","silent":true});
        });
            
        }, 2000);
        ready = true;
    </script>
</body>
</html>