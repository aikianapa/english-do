<html class="h-full bg-gray-100">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="x-ua-compatible" content="IE=Edge">
    <script src="/engine/js/tailwind.min.js"></script>
    <script type="module" src="/engine/js/wbapp.mod.js?alpine"></script>
    <title></title>
    <wb-meta />
    <meta1 wb-if='!wbCheckAllow("admin")' http-equiv="refresh" _content="0;URL=/signin" />
</head>


<wb-meta />
</head>

<body class="h-screen overflow-hidden" wb-if='wbCheckAllow("admin")'>

    <div x-data="{$admin:{}}" x-init='$admin = await wbapp.xinit("/tpl/admin/admin.js"); $admin.init()'>
        <wb-include src="/tpl/admin/menu.php" />
        <div class="flex flex-col flex-1 lg:pl-64">
            <div class="sticky top-0 z-10 pt-1 pl-1 bg-gray-100 sm:pl-3 sm:pt-3 lg:hidden print:hidden">
                <button type="button" class="-ml-0.5 -mt-0.5 inline-flex h-12 w-12 items-center justify-center rounded-md text-gray-500 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" x-on:click="$admin.menuOpen">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
            <main class="flex-1">
                <div class="py-6">
                    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8" id="header">

                    </div>
                    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8" id="workspace">
                        <!-- Your content -->
                    </div>
                </div>
            </main>
        </div>
    </div>


</body>

</html>