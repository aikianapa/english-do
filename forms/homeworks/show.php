<div id="showHomework" class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
<wb-data wb="table=homeworks&item={{_route.item}}">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">{{subject}}</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{text}}


                <div wb-if="'{{count({{docs}})}}'>'0' && '{{docs.0.img}}'>''">
                    <div class="divider-text">Documents</div>
                        <div class="d-inline-flex">
                        <wb-foreach wb-from="docs">
                        <a class="card wd-100 m-2 d-inline-block" href="{{img}}" target="_blank">
                            <img data-src="/thumb/70x70/src/{{img}}" class="img-fluid m-2" />
                            <div class="card-body p-2">
                                <div class="cart-text">{{array_pop({{explode("/",{{img}})}})}}</div>
                            </div>
                        </a>
                        </wb-foreach>
                        </div>
                </div>
                <div wb-if="'{{count({{images}})}}'>'0' && '{{images && '{{docs.0.img}}'>''.0.img}}'>''">
                    <div class="divider-text">Images</div>
                        <div class="d-inline-flex gallery">
                        <wb-foreach wb-from="images">
                        <a data-fslightbox="images" class="d-inline-block m-2" href="{{img}}">
                            <img data-src="/thumbc/100x100/src/{{img}}" class="img-fluid" alt="{{alt}}" title="{{title}}"/>
                        </a>
                        </wb-foreach>
                        </div>
                </div>
                <div wb-if="'{{count({{audio}})}}'>'0' && '{{audio.0.img}}'>''">
                    <div class="divider-text">Audio</div>
                        <div class="d-inline-flex gallery">
                            <ul class="list-group">
                        <wb-foreach wb-from="audio">


<li class="list-group-item d-flex align-items-center">
<audio controls>
  <source src="{{img}}" type="audio/mpeg">
Your browser does not support the audio element.
</audio>
  <div>
    <h6 class="tx-13 tx-inverse tx-semibold mg-l-10 mg-b-0">{{title}}</h6>
    <span class="d-block tx-11 text-muted mg-l-10">{{alt}}</span>
  </div>
</li>
                        </wb-foreach>
                        </ul>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-dismiss="modal" aria-label="Close">
                    Close
                </button>
            </div>
        </div>
    </div>
</wb-data>
<script src="/assets/js/fslightbox.js"></script>
</div>