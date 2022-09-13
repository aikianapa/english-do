<html>
<wb-data wb="table=users&item={{_route.id}}">
    <div class="modal fade effect-scale show removable" id="modalHomeWorksView" data-backdrop="static" tabindex="-1" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header row">
                    <div class="col-5">
                        <h5>Homework</h5>
                    </div>
                    <div class="col-7">
                        <h5 class='header'></h5>
                    </div>
                    <i class="fa fa-close r-20 position-absolute cursor-pointer" data-dismiss="modal" aria-label="Close"></i>
                </div>
                <div class="modal-body pb-5">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="avatar avatar-md">
                                <img src="/thumbc/100x100/src{{avatar.0.img}}" class="rounded-circle" alt="" />
                            </div>
                        </div>
                        <div class="col-auto">
                            <h5>{{last_name}} {{first_name}}</h5>
                            Card: {{card}}
                        </div>
                    </div>
                    <div class="divider-text">Audio files</div>
                    <div class="row">
                        <wb-foreach wb="from=hw_files&tpl=false">
                            <wb-var ext='{{end({{explode(".",{{img}})}})}}' />
                            <div class="col-auto" wb-if='in_array({{_var.ext}},["mp3"])'>
                                <audio controls>
                                    <source src="{{img}}" type="audio/mpeg"> Your browser does not support the audio element.
                                </audio>
                            </div>
                        </wb-foreach>
                    </div>
                    <div class="divider-text">Video files</div>
                    <div class="row">
                        <wb-foreach wb="from=hw_files&tpl=false">
                            <wb-var ext='{{end({{explode(".",{{img}})}})}}' />
                            <div class="col-auto" wb-if='in_array({{_var.ext}},["mp4","avi"])'>
                                <video width="400" height="300" controls="controls" poster="/thumbc/400x300/src/uploads/homeworks/students/1230000000406/id6320e2a4img1435.mp4">
                                    <source src="{{img}}" type="video/mp4" wb-if="'{{_var.ext}}'=='mp4'">
                                    <source src="{{img}}" type="video/x-msvideo" wb-if="'{{_var.ext}}'=='avi'"> Тег video не поддерживается вашим браузером.
                                    <a href="video/x-msvideo" download>Скачайте видео</a>.
                                </video>
                            </div>
                        </wb-foreach>
                    </div>
                    <div class="divider-text">Images</div>
                    <div class="d-inline-flex gallery">
                        <wb-foreach wb="from=hw_files&tpl=false">
                            <wb-var ext='{{end({{explode(".",{{img}})}})}}' />
                            <div class="col-auto" wb-if='in_array({{_var.ext}},["jpg","jpeg","gif","png","svg"])'>
                                <a data-fslightbox="images" class="d-inline-block m-2" href="{{img}}">
                                    <img data-src="/thumbc/100x100/src/{{img}}" class="img-fluid" alt="{{alt}}" title="{{title}}" />
                                </a>
                            </div>
                        </wb-foreach>
                    </div>
                    <div class="divider-text">Documents</div>
                    <div class="d-inline-flex gallery">
                            <wb-foreach wb="from=hw_files&tpl=false">
                                <wb-var ext='{{end({{explode(".",{{img}})}})}}' />
                                <a class="card wd-100 m-2 d-inline-block" href="{{img}}" target="_blank" wb-if='in_array({{_var.ext}},["pdf","txt","doc","docx","xls","xlsx","ppt","pptx"])'>
                                    <img data-src="/thumb/70x70/src/{{img}}" class="img-fluid m-2" />
                                    <div class="card-body p-2">
                                        <div class="cart-text">{{title}}</div>
                                    </div>
                                </a>
                            </wb-foreach>
                    </div>

                    <div class="divider-text">Homework comments</div>
                    <div>{{hw_comment}}</div>
                </div>
                <div class="modal-footer pd-x-20 pd-b-20 pd-t-0 bd-t-0">
                    <wb-include wb="{'form':'common_formsave.php'}" />
                </div>
            </div>
        </div>
</wb-data>
 <script src="/assets/js/fslightbox.js"></script>
</html>