<html>
<div class="modal fade effect-scale show removable" id="modalHomeWorksEdit" data-backdrop="static" tabindex="-1"
    role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header row">
                <div class="col-5">
                    <h5>Домашнее задание</h5>
                </div>
                <div class="col-7">
                    <h5 class='header'></h5>
                </div>
                <i class="fa fa-close r-20 position-absolute cursor-pointer" data-dismiss="modal"
                    aria-label="Close"></i>
            </div>
            <div class="modal-body pd-20">
                <form class="row" method="post" id="{{_form}}EditForm">
                    <div class="col-lg-8">
                        <div class="form-group row">
                            <label class="form-control-label col-sm-3">{{_lang.date}}</label>
                            <div class="col-sm-9">
                            <input type="datepicker" wb-module="datetimepicker" name="date" class="form-control"
                                placeholder="{{_lang.date}}" required>
                                
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="form-control-label col-sm-3">{{_lang.subject}}</label>
                            <div class="col-sm-9">
                            <input type="text" name="subject" class="form-control" placeholder="{{_lang.subject}}" >
                                
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label">Задание</label>
                            <wb-module wb="module=jodit" name="text" />
                        </div>

                        <div class="form-group">
                            <div class="divider-text">Документы (pdf,doc,xls,txt)</div>
                            <wb-module name="docs" wb="{
                                'module':'filepicker',
                                'mode':'multi',
                                'original': true,
                                'button':'Документы',
                                'path':'/uploads/homeworks/docs/',
                                'ext': 'pdf,txt,doc,docx,xls,xlsx,ppt,pptx'
                                }" />
                        </div>


                        <div class="form-group">
                            <div class="divider-text">Изображения (jpg,gif,png,svg)</div>
                            <wb-module name="images" wb="{
                                'module':'filepicker',
                                'mode':'multi',
                                'path':'/uploads/homeworks/images/',
                                'button':'Изображения',
                                'ext': 'jpg,gif,png,svg',
                                'original': false
                                }" />
                        </div>
                        <div class="form-group">
                            <div class="divider-text">Аудиофайлы (mp3)</div>
                            <wb-module name="audio" wb="{
                                'module':'filepicker',
                                'mode':'multi',
                                'path':'/uploads/homeworks/audio/',
                                'button':'Аудиофайлы',
                                'ext': 'mp3',
                                'original': false
                                }" />
                        </div>

                    </div>
                    <div class="col-lg-4" id="students">
                        <div class="form-group">
                            <label>Отображать</label>
                            <wb-module wb="module=switch" name="active" />
                        </div>


                        <h5>Студенты</h5>
                        <ul class="list-group">
                            <wb-foreach wb="table=users" wb-filter="role=student&active=on">
                                <li class="list-group-item">
                                    <label class="form-control-label m-0 w-100" for="user{{id}}">{{first_name}} {{last_name}}</label>
                                    <input type="checkbox" data-id="{{id}}" id="user{{id}}"  class="pos-absolute r-10 t-0 form-control wd-20">
                                </li>
                            </wb-foreach>
                        </ul>
                        <textarea class="d-none" type="json" name="students">{}</textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer pd-x-20 pd-b-20 pd-t-0 bd-t-0">
                <wb-include wb="{'form':'common_formsave.php'}" />
            </div>
        </div>
    </div>
</div>
<script wb-app >
    var mhwe_stud = {};
    var modalHomeWorksEdit = function() {
        let form = $('#modalHomeWorksEdit');
        let list = $(form).find('#students .list-group');
        let stud = $(form).find('[name=students]');
        $(stud).removeAttr('data-params');
        try {
            mhwe_stud = json_decode($(stud).text());
                        console.log($(stud).text());

        } catch (error) {
            mhwe_stud = [];
        }
        $(mhwe_stud).each(function(i,id){
            $(list).find('input[data-id="'+id+'"]').prop('checked',true);
        });
        $(list).delegate('input','change',function(){
            if (typeof mhwe_stud == 'object') mhwe_stud = Object.values(mhwe_stud);
            console.log(mhwe_stud);
            let id = $(this).data('id');
            if (in_array(id,mhwe_stud)) {
                let pos = array_search(id,mhwe_stud);
                array_splice(mhwe_stud,pos);
            } else {
                mhwe_stud.push(id);
            }
            console.log(mhwe_stud);
            let json = json_encode(mhwe_stud);
            $(stud).val(json);
        });
    }
    modalHomeWorksEdit();

</script>
<wb-lang>
    [ru]
    date = Дата
    subject = Тема
    appends = Вложения
    actions = Действия
</wb-lang>

</html>