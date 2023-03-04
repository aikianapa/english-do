"use strict"
import wbapp from "/engine/js/wbapp.mod.js"

var admin = function () {
    return {
        init() {
            wbapp.html('/tpl/admin/dashboard.php','#workspace')
        },
        menuOpen() {
            document.getElementById('menuToggle').click()
        }
    }
}
export default admin