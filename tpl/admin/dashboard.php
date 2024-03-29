<div x-data="{$:{visits:[],monthes:[],month:null}}" x-init='$ = await wbapp.xinit("/tpl/admin/dashboard.js"); $.init()'>

    <div class="md:pr-14">
        <div class="flex items-center py-3 print:hidden">
            <input type="hidden" x-ref="date" x-bind:value="$.value">
            <button type="button" class="-my-1.5 flex flex-none items-center justify-center p-1.5 text-white " x-on:click="$.prevMonth()">
                <span class="sr-only ">Previous month</span>
                <svg class="bg-gray-500 rounded-full w-7 h-7 " viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                </svg>
            </button>
            <h2 class="flex-auto text-sm font-semibold text-center text-gray-900"><span x-text="$.monthes[$.month]" class="text-lg font-bold text-gray-800"></span> <span x-text="$.year" class="ml-1 text-lg font-normal text-gray-600"></span></h2>

            <button type="button" class="-my-1.5 -mr-1.5 ml-2 flex flex-none items-center justify-center p-1.5 text-white " x-on:click="$.nextMonth()">
                <span class="sr-only ">Next month</span>
                <svg class="bg-gray-500 rounded-full w-7 h-7" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <template x-if="!$.uid">
            <div class="w-full overflow-x-auto print:hidden">
                <table class="min-w-full divide-y divide-gray-300 border-y" id="List">
                    <thead>
                        <tr>
                            <th scope="col" class="p-1 text-sm font-semibold text-left text-gray-900 border-x">Student</th>
                            <template x-for="day in $.no_of_days">
                                <th x-text="('0'+day).slice(-2)" scope="col" class="p-1 text-sm font-semibold text-center text-gray-900 border-r"></th>
                            </template>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <template x-for="(item, index) in $.list">
                            <tr class="odd:bg-teal-50 even:bg-blue-50">
                                <td class="p-1 text-sm font-medium text-gray-900 cursor-pointer border-x whitespace-nowrap">
                                    <button type="button" class="cursor-pointer" x-text="item.last_name + ' ' +item.first_name" x-on:click="$.userRep(item.id)"></button>
                                </td>
                                <template x-for="day in $.no_of_days">
                                    <td class="p-0 text-sm text-center text-indigo-600 border-r whitespace-nowrap">
                                        <svg class="w-6 h-6" x-show="$.getCheck(day, item.id)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="w-5 h-5">
                                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"></path>
                                        </svg>
                                    </td>
                                </template>
                            </tr>
                        </template>
                        <!-- More people... -->
                    </tbody>
                </table>
            </div>
        </template>

        <template x-if="$.uid">
            <div class="mt-5">
                <button class="px-3 py-2 text-sm text-white bg-green-600 rounded-md print:hidden" x-on:click="print()">Print</button>
                <button class="px-3 py-2 ml-3 text-sm text-white bg-gray-600 rounded-md print:hidden" x-on:click="$.uid=''">Back</button>
                <div class="md:pr-14 print:block">
                    <h3 class="text-center" x-text="$.uname +' ('+$.monthes[$.month] + ' ' + $.year+')'"></h3>
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
                                <div x-text="day" class="w-8 h-8 leading-8 text-center rounded-full cursor-pointer" :class="$.isVisit(day) == true ? 'bg-blue-500 print:border print:border-gray-700 text-white print:text-gray-900 print:font-bold' : 'text-gray-500'"></div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </template>

    </div>
</div>