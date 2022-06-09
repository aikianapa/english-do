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
            <p class="alert alert-warning">{{msg}}</p>
          {{else}}
          {{#member}}
              <div class="card mg-t-100">
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
              <button type="button" on-click='scan' class="mt-5 btn btn-primary">
                Сканнер
              </button>
            {{/member}}
          {{/if}}
        </template>
      </div>
    </div>
  </div>
  <!--a href="javascript:void(0)" class="btn btn-secondary" onclick="test(this)">3570000001705</a-->
</section>
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

  $(document).one("modBarcodeStart", function() {
    $("#modBarcodeContainer").barcode();
    $("#result").hide()
  })
  $(document).on("mod.barcode.scan", function(ev, data) {
    $("#interactive").hide()
    $("#result").show()
    let today = new Date();
    let dd = String(today.getDate()).padStart(2, '0');
    let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    let yyyy = today.getFullYear();
    data.member.date = yyyy + "-" + mm + "-" + dd
    result.set(data)
    result.fire('get')
  })
  wbapp.loadStyles([
    "css/styles.less"
  ]);
  var test = function(ev) {
    let code = $(ev).text()
    wbapp.get("/form/visits/scan?card=" + code, {}, function(data) {
      $(document).trigger('mod.barcode.scan', data)
    });
  }
</script>

</body>

</html>