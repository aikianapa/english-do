export default ()=> {
    return {
        checked: false,
        value: '',
        init() {
            var id = wbapp.newId('', 'twsw')
            var $sw = document.querySelector('[x-init*="twswitch"]:not([id])')
            if (!$sw) return
            $sw.setAttribute('id', id)
            $sw.inp = $sw.querySelector('input[x-ref]')
            this.inp = $sw.inp
            this.value = $sw.inp.value
            this.checked = this.value == 'on' ? true : false
            $sw.querySelectorAll('span[aria-hidden]')[0].classList.remove('opacity-100,ease-in,duration-200')
            $sw.querySelectorAll('span[aria-hidden]')[1].classList.remove('opacity-0,ease-out,duration-100')
            $sw.inp.watch = setInterval(()=>{
                if (!document.getElementById(id)) {
                    clearInterval($sw.inp.watch); 
                } else {
                    if (this.value !== $sw.inp.value) {
                        this.value = $sw.inp.value
                        this.checked = this.value == 'on' ? true : false
                    }
                }
            },100)
        },
        toggle() {
            this.checked = !this.checked
            this.value = this.checked ? 'on' : ''
            this.inp.value = this.value
            $(this.inp).data('value', this.value)
            $(this.inp).trigger('change')
        }
    }
}