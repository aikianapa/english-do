<html lang="en">

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

<meta name="viewport" content="width=device-width; initial-scale=1.0; user-scalable=no" />


<section id="modBarcodeContainer">
  <div class="container">
    <div class="row">
      <div id="interactive" class="viewport col-12"></div>
      <div id="result" class="col-12">
        <template>
          {{#if error == true}}
            <p class="alert alert-warning mg-t-100 shadow">{{msg}}</p>
          {{else}}
            {{#member}}
              <div class="card mg-t-100 shadow">
                <div class="card-body">
                  <div class="card-text">
                    <div class="avatar avatar-xxl float-right"><img src="/thumbc/100x100/src{{avatar.0.img}}" class="rounded-circle" alt=""></div>
                    {{#if ~/visit.status == true}}
                      <div class="pos-absolute b-10 r-10"><img src="/module/myicons/certificate-checkmark.svg?size=70&amp;stroke=10b759"></div>
                    {{/if}}
                    <div class="row">
                      <div class="col">
                        <h4 class="pb-3">{{first_name}} {{last_name}}</h4>
                        <div class="form-group">
                          <input type="hidden" name="uid" value='{{id}}'>
                          <input type="date" class="form-control mb-2" name="date" value='{{date}}' on-change="get">
                          <a href="javascript:void(0)" on-click="check" class="mr-5">
                            <img src="/module/myicons/checkmark-done-check.4.svg?size=50&amp;stroke=10b759">
                          </a>
                          <a href="javascript:void(0)" on-click="uncheck">
                            <img src="/module/myicons/delete-button.svg?size=50&amp;stroke=dc3545">
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            {{/member}}
          {{/if}}
        </template>
      </div>
                <div class="col-12 col-md-4 col-xl-3">
                  <button type="button" onclick="result.fire('scan')" class="mt-5 btn btn-primary btn-block">
                    Сканнер
                  </button>
                  <button type="button" onclick="members.fire('getlist')" class="mt-2 btn btn-secondary btn-block">
                    Поиск по списку
                  </button>
                </div>
    </div>
  </div>
</section>

<div class="off-canvas off-canvas-overlay" id="membersList">
  <div class="off-canvas-header">
    <a href="javascript:void(0)" onclick="$('#membersList').removeClass('show')" class="close pos-absolute r-20">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
        <line x1="18" y1="6" x2="6" y2="18"></line>
        <line x1="6" y1="6" x2="18" y2="18"></line>
      </svg></a>
  </div>
  <div class="off-canvas-body scroll-y">
    <template>
      <ul class="list-group pd-b-100">
        {{#each members}}
          <li class="list-group-item cursor-pointer" on-click="memberSet" data-card="{{card}}">
            <div>{{last_name}} {{first_name}}</div>
            <div class="badge badge-light">{{card}}</div>
          </li>
        {{/each}}
      </ul>
    </template>
  </div>
</div>

<script wb-app>
  wbapp.loadScripts([
    "js/adapter.js",
    "js/quagga.min.js",
    "js/live_w_locator.js"
  ], "modBarcodeStart");

  var result = Ractive({
    el: '#result',
    template: $('#result template').html(),
    data: {},
    on: {
      scan(ev) {
        $("#result").hide()
        $("#interactive").show()
        $("#modBarcodeContainer").barcode();
      },
      check(ev) {
        let post = {
          date: $("#result .card input[name=date").val(),
          uid: $("#result .card input[name=uid").val()
        }
        wbapp.post("/form/visits/check", post, function(data) {
          if (data.error == false) {
            result.set("visit.status", true)
          }
        })
      },
      uncheck(ev) {
        let post = {
          date: $("#result .card input[name=date").val(),
          uid: $("#result .card input[name=uid").val()
        }
        wbapp.post("/form/visits/uncheck", post, function(data) {
          if (data.error == false) {
            result.set("visit.status", false)
          }
        })
      },
      get(ev) {
        let post = {
          date: $("#result .card input[name=date").val(),
          uid: $("#result .card input[name=uid").val()
        }
        wbapp.post("/form/visits/get", post, function(data) {
          result.set("visit", data)
        })
      }
    }
  })

  var members = Ractive({
    el: '#membersList .off-canvas-body',
    template: $('#membersList template').html(),
    data: {},
    on: {
      getlist() {
        $("#membersList").addClass('show');
        wbapp.get("/api/v2/list/users?active=on&role=student&@return=id,active,role,first_name,last_name,card&@sort=last_name", function(data) {
          members.set("members", data)
        })
      },
      memberSet(ev) {
        $('#membersList').removeClass('show')
        let card = $(ev.node).data("card")
        wbapp.get("/form/visits/scan?card=" + card, {}, function(data) {
          $(document).trigger('mod.barcode.scan', data)
        });
      }
    }
  })

  $(document).one("modBarcodeStart", function() {
    $("#modBarcodeContainer").barcode();
    $("#result").hide()
  })
  $(document).on("mod.barcode.scan", function(ev, data) {
    if (data.error == false) {
      let today = new Date();
      let dd = String(today.getDate()).padStart(2, '0');
      let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
      let yyyy = today.getFullYear();
      data.member.date = yyyy + "-" + mm + "-" + dd
    }
    $("#interactive").hide()
    $("#result").show()
    result.set(data)
    result.fire('get')
  })
  wbapp.loadStyles([
    "css/styles.less"
  ]);

</script>

</html>