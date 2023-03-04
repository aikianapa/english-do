<button wb-off type="button" class="relative inline-flex flex-shrink-0 h-6 transition-colors duration-200 ease-in-out border-2 border-transparent rounded-full cursor-pointer twswitch w-11 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" role="switch" x-data="{sw:{}}" x-init="sw = await wbapp.xinit('/module/twswitch/twswitch.js'); sw.init();" x-on:click="sw.toggle()" :class="sw.checked ? 'bg-indigo-600' : 'bg-gray-200'">
    <input type="hidden" x-ref="switch" />
    <span class="sr-only ">Use setting</span>
    <span :class="sw.checked ? 'translate-x-5' : 'translate-x-0'" class="relative inline-block w-5 h-5 transition duration-200 ease-in-out transform translate-x-0 bg-white rounded-full shadow pointer-events-none ring-0">
        <span :class="sw.checked ? 'opacity-0 ease-out duration-100' : 'opacity-100 ease-in duration-200'" class="absolute inset-0 flex items-center justify-center w-full h-full transition-opacity" aria-hidden="true">
            <svg class="w-3 h-3 text-gray-400" fill="none" viewBox="0 0 12 12">
                <path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </span>
        <span :class="sw.checked ? 'opacity-100 ease-in duration-200':'opacity-0 ease-out duration-100'" class="absolute inset-0 flex items-center justify-center w-full h-full transition-opacity" aria-hidden="true">
            <svg class="w-3 h-3 text-indigo-600" fill="currentColor" viewBox="0 0 12 12">
                <path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z" />
            </svg>
        </span>
    </span>
</button>