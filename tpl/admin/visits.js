"use strict"
import wbapp from "/engine/js/wbapp.mod.js"
var visits = function () {
    return {
        showDatepicker: false,
        showMonthpicker: false,
        datepickerValue: '',
        monthes: ['', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        days: ['MO', 'TU', 'WE', 'TH', 'FR', 'SA', 'SU'],
        month: new Date().getMonth(),
        year: new Date().getFullYear(),
        day: new Date().getFullYear(),
        value: '',
        mon: null,
        day: '',
        divider: '.',
        no_of_days: [''],
        blankdays: [],
        id: '',
        init() {
            var id = wbapp.newId('', 'twd')
            var $el = document.querySelector('[x-init*="visits.js"]:not([id])')
            if (!$el) return
            $el.setAttribute('id', id)
            let date = $el.querySelector('input[x-ref]').value
            let today = date > '' ? new Date(date) : new Date();
            this.$el = $el
            this.id = id
            this.value = date
            this.day = today.getDate();
            this.month = today.getMonth();
            this.year = today.getFullYear();
            this.list = this.getStudents();
            let dvr = this.divider
            this.month++
            this.value = ('0000' + this.year).slice(-4) + "-" + ('0' + this.month).slice(-2) + "-" + ('0' + this.day).slice(-2);
            this.datepickerValue = ('0' + this.day).slice(-2) + dvr + ('0' + this.month).slice(-2) + dvr + ('0000' + this.year).slice(-4)
            this.getNoOfDays()
        },

        isToday(date) {
            const today = new Date();
            const d = new Date(this.year, this.month - 1, date);

            return today.toDateString() === d.toDateString() ? true : false;
        },
        getDateValue(date) {
            let dvr = this.divider
            this.day = date
            this.value = ('0000' + this.year).slice(-4) + "-" + ('0' + this.month).slice(-2) + "-" + ('0' + date).slice(-2);
            this.datepickerValue = ('0' + date).slice(-2) + dvr + ('0' + this.month).slice(-2) + dvr + ('0000' + this.year).slice(-4)
            this.showDatepicker = false;
            $(this.$el).data('value', this.value)
            $(this.$el).trigger('change')
            this.checkVisits()
        },
        setMonth(month) {
            this.month = month
            this.showMonthpicker = false
            this.showDatepicker = true
            this.getNoOfDays()
        },
        nextMonth() {
            this.month++
            if (this.month > 12) {
                this.month = 1
                this.year++
            }
            this.getNoOfDays()
            this.getDateValue(this.day)
            this.checkVisits()
        },
        prevMonth() {
            this.month--
            if (this.month < 1) {
                this.month = 12
                this.year--
            }
            this.getNoOfDays()
            this.getDateValue(this.day)
            this.checkVisits()
        },

        getNoOfDays() {
            let daysInMonth = new Date(this.year, this.month -1, 0).getDate();
            // find where to start calendar day of week
            let first = new Date(this.year, this.month-1, 0)
            let dayOfWeek = first.getDay()
            let blankdaysArray = [];
            for (var i = 1; i <= dayOfWeek; i++) {
                blankdaysArray.push(i);
            }
            let daysArray = [];
            for (var i = 1; i <= daysInMonth; i++) {
                daysArray.push(i);
            }
            this.blankdays = blankdaysArray;
            this.no_of_days = daysArray;
        },
        async getStudents() {
            let src = "/api/v2/list/users?role=student&active=on&@sort=last_name&@return=id,first_name,last_name"
            wbapp.json(src).then((data)=>{
                $.each(data, function (i, item) {
                    item.checked = false
                })
                this.list = data
                this.checkVisits()
            });
        },
        checkVisits() {
            let src = `/api/v2/list/visits?date=${this.value}&@return=uid&@group=uid`
            $(this.$el).find(`input[data-id]`).removeAttr('checked')
            $.get(src).then((data)=>{
                data = Object.keys(data)
                $.each(this.list, function (i, item) {
                    item.checked = data.indexOf(item.id) > -1 ? true : false
                })

            })
        },
        toggle(uid) {
            var action
            $.each(this.list, function (i, item) {
                if (item.id == uid) {
                    action = item.checked ? 'check' : 'uncheck'
                }
            })
            $.post("/form/visits/"+action,{date:this.value, uid: uid});
        }

    }
}

export default visits