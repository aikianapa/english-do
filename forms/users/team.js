"use strict"
import wbapp from "/engine/js/wbapp.mod.js"

var team = function () {
    return {
        form: false,
        active: true,
        data: {},
        index: null,
        list: [],
        init() {
            let src = "/api/v2/list/users?isgroup=&@sort=last_name&@return=group,first_name,last_name,email,phone,active,avatar,id"
            $.get(src).then((data)=>{
                this.list = data
                this.list.forEach((item) => {
                    let avatar = '/thumb/80x80/src'
                        try {
                            avatar += item.avatar[0].img
                        } catch (error) {
                            avatar += ''
                        }
                        item.avatar = avatar
                })
            })
        },
        cancel() {
            this.data = {}
            this.index = null
            this.form = false
        },
        edit(idx) {
            this.index = idx
            this.data = this.list[idx]
            //this.data.active = this.data.active == 'on' || this.data.active ? true : false
            this.form = true
        },
        add() {
            this.data = {}
            this.data.id = wbapp.newId()
            this.form = true
        },
        save() {
            let data = wbapp.formData('#formTeam')
            $.post('/api/v2/update/users/'+data.id,data).then((res) => {
                this.list[this.index] = data
            })
        }
    }
}
export default team