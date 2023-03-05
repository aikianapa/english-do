<div class="grid w-full grid-cols-1 gap-4 sm:grid-cols-2 gap" x-data="{team:{data:{}}}" x-init='team = await wbapp.xinit("/forms/users/team.js"); team.init()'>
    <ul role="list" class="relative h-[calc(100vh-50px)] overflow-auto divide-y divide-gray-200">
        <li class="grid grid-cols-3 gap-1">
            <button x-on:click="team.form = false; team.active = true" type="button" class="inline-flex justify-center w-full px-3 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Active</button>
            <button x-on:click="team.form = false; team.active = false" type="button" class="inline-flex justify-center w-full px-3 py-2 text-sm font-semibold text-white bg-gray-700 rounded-md ring-1 ring-inset ring-gray-300 hover:bg-gray-500 ">Archive</button>
            <button x-on:click="team.add()" type="button" class="inline-flex justify-center w-full px-3 py-2 text-sm font-semibold text-white rounded-md bg-lime-700 ring-1 ring-inset ring-gray-300 hover:bg-lime-500 ">Add</button>
        </li>
        <template x-for="(item, index) in team.list">
            <li class="flex items-center py-4 cursor-pointer select-none" x-on:click="team.edit(index)" :class="(item.active == 'on' && team.active ||  item.active == '' && !team.active)? '' : 'hidden'">
                <img class="w-10 h-10 rounded-full" x-bind:src="item.avatar" alt="">
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900" x-text="item.last_name + ' ' + item.first_name"></p>
                    <!--p x-show="item.active == 'on' || item.active == true" class="text-sm text-gray-500">
                        active
                    </p-->
                </div>
            </li>
        </template>
    </ul>

    <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-show="team.form">
        <div x-show="team.form"  class="fixed inset-0 bg-gray-500 bg-opacity-75 sm:hidden"></div>

        <div class="fixed inset-x-0 top-0 z-10 overflow-y-auto sm:relative">
            <div class="flex items-end justify-center min-h-full p-4 sm:items-center sm:p-0">
                <div x-show="team.form" class="relative w-full max-w-sm px-4 pt-5 pb-4 my-8 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl sm:p-6" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
                    <div>
                        <div class="mt-3 sm:mt-5">
                            <form wb-module="twform" id="formTeam">
                                <input x-bind:value="team.data.id" type="hidden" name="id">
                                <input name="role" type="hidden" value="student"/>
                                <label class="w-full">First Name</label>
                                <input x-bind:value="team.data.first_name" name="first_name">
                                <label class="w-full">Last Name</label>
                                <input x-bind:value="team.data.last_name" name="last_name">
                                <label class="w-full">Phone</label>
                                <input x-bind:value="team.data.phone" type="phone" name="phone" autocomplete="off">
                                <label>Active</label>
                                <input name="active" wb-module="twswitch" x-bind:value="team.data.active">
                                <!--button x-on:click="team.data.active = !team.data.active;" type="button" class="relative inline-flex flex-shrink-0 h-6 mr-2 transition-colors duration-200 ease-in-out border-2 border-transparent rounded-full cursor-pointer twswitch w-11 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" role="switch" :class="team.data.active ? 'bg-indigo-600' : 'bg-gray-200'">
                                    <span class="sr-only "> <input type="hidden" name="active" x-bind:value="team.data.active ? 'on' : ''" /></span>
                                    <span :class="team.data.active ? 'translate-x-5' : 'translate-x-0'" class="relative inline-block w-5 h-5 transition duration-200 ease-in-out transform translate-x-0 bg-white rounded-full shadow pointer-events-none ring-0">
                                        <span :class="team.data.active ? 'opacity-0 ease-out duration-100' : 'opacity-100 ease-in duration-200'" class="absolute inset-0 flex items-center justify-center w-full h-full transition-opacity" aria-hidden="true">
                                            <svg class="w-3 h-3 text-gray-400" fill="none" viewBox="0 0 12 12">
                                                <path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                        <span :class="team.data.active ? 'opacity-100 ease-in duration-200':'opacity-0 ease-out duration-100'" class="absolute inset-0 flex items-center justify-center w-full h-full transition-opacity" aria-hidden="true">
                                            <svg class="w-3 h-3 text-indigo-600" fill="currentColor" viewBox="0 0 12 12">
                                                <path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z" />
                                            </svg>
                                        </span>
                                    </span>
                                </button-->

                                <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                                    <button x-on:click="team.save()" type="button" class="inline-flex justify-center w-full px-3 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 sm:col-start-2">Save</button>
                                    <button x-on:click="team.cancel()" type="button" class="inline-flex justify-center w-full px-3 py-2 mt-3 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>