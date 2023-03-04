<div class="md:grid md:grid-cols-2 md:divide-x md:divide-gray-200" x-data="{$:{monthes:[],month:null}}" x-init='$ = await wbapp.xinit("/tpl/admin/visits.js"); $.init()'>
    <div class="md:pr-14">
        <div class="flex items-center">
            <input type="hidden" x-ref="date" x-bind:value="$.value">
            <button type="button" class="-my-1.5 flex flex-none items-center justify-center p-1.5 text-gray-400 hover:text-gray-500" x-on:click="$.prevMonth()">
                <span class="sr-only ">Previous month</span>
                <svg class="w-5 h-5 " viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                </svg>
            </button>

            <h2 class="flex-auto text-sm font-semibold text-center text-gray-900"><span x-text="$.monthes[$.month]" class="text-lg font-bold text-gray-800"></span> <span x-text="$.year" class="ml-1 text-lg font-normal text-gray-600"></span></h2>
            <button type="button" class="-my-1.5 -mr-1.5 ml-2 flex flex-none items-center justify-center p-1.5 text-gray-400 hover:text-gray-500" x-on:click="$.nextMonth()">
                <span class="sr-only ">Next month</span>
                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
        <div class="grid grid-cols-7 mt-10 text-xs leading-6 text-center text-gray-500">
            <template x-for="day in $.days">
                <div x-text="day"></div>
            </template>
        </div>
        <div class="grid grid-cols-7 mt-2 text-sm text-center">
            <template x-for="blankday in $.blankdays">
                <div class="py-2">
                    <div class="p-1 text-sm border border-transparent"></div>
                </div>
            </template>
            <template x-for="day in $.no_of_days">
                <div class="flex justify-center py-2">
                    <div x-on:click="$.getDateValue(day)" x-text="day" class="w-8 h-8 leading-8 text-center rounded-full cursor-pointer" :class="{'bg-blue-500 text-white': $.day !== day && $.isToday(day) == true, 'text-gray-700 hover:bg-blue-200': $.day !== day && $.isToday(day) == false, 'bg-indigo-600 text-white': $.day == day }"></div>
                </div>
            </template>
        </div>
    </div>
    <section class="mt-12 md:mt-0 md:pl-14">
        <h2 class="text-base font-semibold leading-6 text-gray-900">Visits for <span x-text="$.day + ' ' + $.monthes[$.month] + ' ' + $.year" class="text-lg font-normal text-gray-600 ">"</span></h2>
        <ol class="mt-4 space-y-1 text-sm leading-6 text-gray-500">
            <template x-for="(item, index) in $.list">
                <li class="flex items-center px-4 py-2 space-x-4 group rounded-xl focus-within:bg-gray-100 hover:bg-gray-100">
                    <div class="flex items-center select-none">
                        <button x-on:click="item.checked = !item.checked; $.toggle(item.id)" type="button" class="relative inline-flex flex-shrink-0 h-6 mr-2 transition-colors duration-200 ease-in-out border-2 border-transparent rounded-full cursor-pointer twswitch w-11 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" role="switch" :class="item.checked ? 'bg-indigo-600' : 'bg-gray-200'">
                            <span class="sr-only ">Use setting</span>
                            <span :class="item.checked ? 'translate-x-5' : 'translate-x-0'" class="relative inline-block w-5 h-5 transition duration-200 ease-in-out transform translate-x-0 bg-white rounded-full shadow pointer-events-none ring-0">
                                <span :class="item.checked ? 'opacity-0 ease-out duration-100' : 'opacity-100 ease-in duration-200'" class="absolute inset-0 flex items-center justify-center w-full h-full transition-opacity" aria-hidden="true">
                                    <svg class="w-3 h-3 text-gray-400" fill="none" viewBox="0 0 12 12">
                                        <path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span :class="item.checked ? 'opacity-100 ease-in duration-200':'opacity-0 ease-out duration-100'" class="absolute inset-0 flex items-center justify-center w-full h-full transition-opacity" aria-hidden="true">
                                    <svg class="w-3 h-3 text-indigo-600" fill="currentColor" viewBox="0 0 12 12">
                                        <path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z" />
                                    </svg>
                                </span>
                            </span>
                        </button>
                        <label x-bind:for="'list-'+index" class="text-gray-900" x-text="item.last_name + ' ' + item.first_name"></label>
                    </div>
                </li>
            </template>
            <!-- More meetings... -->
        </ol>
    </section>
</div>