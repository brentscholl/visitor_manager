<x-guest-layout>
    <div class="max-w-screen-xl mx-auto px-5">

        <header class="flex flex-col lg:flex-row justify-between items-center my-5">

            <div class="flex w-full lg:w-auto items-center justify-between">
                <a href="/" class="text-lg flex items-center decoration-slate-600">
                    <span class="font-bold text-slate-800">Gatekeeper</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-0.5 ml-0.5 fill-slate-500"
                            style="margin-bottom:1px;" viewBox="0 0 512 512">
                        <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                        <path d="M336.6 156.5c1.3 1.1 2.7 2.2 3.9 3.3c9.3 8.2 23 10.5 33.4 3.6l67.6-45.1c11.4-7.6 14.2-23.2 5.1-33.4C430 66.6 410.9 50.6 389.7 37.6c-11.9-7.3-26.9-1.4-32.1 11.6l-30.5 76.2c-4.5 11.1 .2 23.6 9.5 31.2zM328 36.8c5.1-12.8-1.6-27.4-15-30.5C294.7 2.2 275.6 0 256 0s-38.7 2.2-57 6.4C185.5 9.4 178.8 24 184 36.8l30.3 75.8c4.5 11.3 16.8 17.2 29 16c4.2-.4 8.4-.6 12.7-.6s8.6 .2 12.7 .6c12.1 1.2 24.4-4.7 29-16L328 36.8zM65.5 85c-9.1 10.2-6.3 25.8 5.1 33.4l67.6 45.1c10.3 6.9 24.1 4.6 33.4-3.6c1.3-1.1 2.6-2.3 4-3.3c9.3-7.5 13.9-20.1 9.5-31.2L154.4 49.2c-5.2-12.9-20.3-18.8-32.1-11.6C101.1 50.6 82 66.6 65.5 85zm314 137.1c.9 3.3 1.7 6.6 2.3 10c2.5 13 13 23.9 26.2 23.9h80c13.3 0 24.1-10.8 22.9-24c-2.5-27.2-9.3-53.2-19.7-77.3c-5.5-12.9-21.4-16.6-33.1-8.9l-68.6 45.7c-9.8 6.5-13.2 19.2-10 30.5zM53.9 145.8c-11.6-7.8-27.6-4-33.1 8.9C10.4 178.8 3.6 204.8 1.1 232c-1.2 13.2 9.6 24 22.9 24h80c13.3 0 23.8-10.8 26.2-23.9c.6-3.4 1.4-6.7 2.3-10c3.1-11.4-.2-24-10-30.5L53.9 145.8zM104 288H24c-13.3 0-24 10.7-24 24v48c0 13.3 10.7 24 24 24h80c13.3 0 24-10.7 24-24V312c0-13.3-10.7-24-24-24zm304 0c-13.3 0-24 10.7-24 24v48c0 13.3 10.7 24 24 24h80c13.3 0 24-10.7 24-24V312c0-13.3-10.7-24-24-24H408zM24 416c-13.3 0-24 10.7-24 24v48c0 13.3 10.7 24 24 24h80c13.3 0 24-10.7 24-24V440c0-13.3-10.7-24-24-24H24zm384 0c-13.3 0-24 10.7-24 24v48c0 13.3 10.7 24 24 24h80c13.3 0 24-10.7 24-24V440c0-13.3-10.7-24-24-24H408zM272 192c0-8.8-7.2-16-16-16s-16 7.2-16 16V464c0 8.8 7.2 16 16 16s16-7.2 16-16V192zm-64 32c0-8.8-7.2-16-16-16s-16 7.2-16 16V464c0 8.8 7.2 16 16 16s16-7.2 16-16V224zm128 0c0-8.8-7.2-16-16-16s-16 7.2-16 16V464c0 8.8 7.2 16 16 16s16-7.2 16-16V224z"/>
                    </svg>
                </a>
                <div class="block lg:hidden">
                    <button id="vm-menu" aria-label="Toggle Menu">
                        <svg fill="currentColor" class="w-4 h-4 text-gray-800" width="24" height="24"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <title>Toggle Menu</title>
                            <path class="vm-close-icon vm-toggle hidden" fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M18.278 16.864a1 1 0 01-1.414 1.414l-4.829-4.828-4.828 4.828a1 1 0 01-1.414-1.414l4.828-4.829-4.828-4.828a1 1 0 011.414-1.414l4.829 4.828 4.828-4.828a1 1 0 111.414 1.414l-4.828 4.829 4.828 4.828z"></path>
                            <path class="vm-open-icon vm-toggle" fill-rule="evenodd"
                                    d="M4 5h16a1 1 0 010 2H4a1 1 0 110-2zm0 6h16a1 1 0 010 2H4a1 1 0 010-2zm0 6h16a1 1 0 010 2H4a1 1 0 010-2z"></path>
                        </svg>

                    </button>
                </div>
            </div>
            @if(auth()->user())
                <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Dashboard
                </a>
            @else
                @if (Route::has('login'))
                    <div>
                        <div class="flex items-center gap-4">
                            <a href="{{ route('login') }}" class="uppercase tracking-widest font-semibold text-xs">Log
                                in</a>
                            <a href="{{ route('register') }}"
                                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Buy
                                Now
                            </a>
                        </div>
                    </div>
                @endif
            @endif
        </header>

    </div>

    <div class="max-w-screen-xl mx-auto px-5">

        <main class="grid lg:grid-cols-2 place-items-center pt-16 pb-8 md:pt-12 md:pb-24">
            <div>
                <h1 class="text-5xl lg:text-6xl xl:text-7xl font-bold lg:tracking-tight xl:tracking-tighter">
                    Easy Guest Sign-In: Quick, Clear, and Paper-Free
                </h1>
                <p class="text-lg mt-4 text-slate-600 max-w-xl">
                    We make guest sign-ins easy for small businesses. Forget the paper sheets – set up your digital
                    sign-in quickly, use it anywhere, and it even recognizes your regular visitors. Simple and
                    convenient for you and your guests!</p>
                <div class="mt-6 flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('register') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Get Started
                    </a>
                    {{--                    <a href="https://github.com/surjithctly/astroship" rel="noopener" target="_blank"--}}
                    {{--                        class="rounded text-center transition focus-visible:ring-2 ring-offset-2 ring-gray-200 px-5 py-2.5 bg-white border-2 border-black hover:bg-gray-100 text-black flex gap-1 items-center justify-center">--}}
                    {{--                        <svg viewBox="0 0 24 24" class="text-black w-4 h-4" astro-icon="bx:bxl-github">--}}
                    {{--                            <path fill="currentColor" fill-rule="evenodd"--}}
                    {{--                                d="M12.026 2c-5.509 0-9.974 4.465-9.974 9.974 0 4.406 2.857 8.145 6.821 9.465.499.09.679-.217.679-.481 0-.237-.008-.865-.011-1.696-2.775.602-3.361-1.338-3.361-1.338-.452-1.152-1.107-1.459-1.107-1.459-.905-.619.069-.605.069-.605 1.002.07 1.527 1.028 1.527 1.028.89 1.524 2.336 1.084 2.902.829.091-.645.351-1.085.635-1.334-2.214-.251-4.542-1.107-4.542-4.93 0-1.087.389-1.979 1.024-2.675-.101-.253-.446-1.268.099-2.64 0 0 .837-.269 2.742 1.021a9.582 9.582 0 0 1 2.496-.336 9.554 9.554 0 0 1 2.496.336c1.906-1.291 2.742-1.021 2.742-1.021.545 1.372.203 2.387.099 2.64.64.696 1.024 1.587 1.024 2.675 0 3.833-2.33 4.675-4.552 4.922.355.308.675.916.675 1.846 0 1.334-.012 2.41-.012 2.737 0 .267.178.577.687.479C19.146 20.115 22 16.379 22 11.974 22 6.465 17.535 2 12.026 2z"--}}
                    {{--                                clip-rule="evenodd"></path>--}}
                    {{--                        </svg>--}}
                    {{--                        GitHub Repo--}}

                    {{--                    </a>--}}
                </div>
            </div>
            <div class="py-6 col-span-1 flex justify-end w-full">
                <div class="border-2 border-black rounded-lg p-10 flex flex-col justify-center items-center space-y-6">
                    <div class="flex flex-col justify-center items-center">
                        <h3 class="text-base font-bold text-gray-400">Only</h3>
                        <h2 class="text-5xl lg:text-6xl xl:text-7xl font-bold lg:tracking-tight xl:tracking-tighter">
                            $10<span class="text-base tracking-normal">/month</span></h2>
                    </div>
                    <ul class="flex flex-col space-y-4">
                        <li class="flex space-x-2">
                            <x-svg.check class="h-5 w-5 text-green-500"/>
                            <span>Unlimited sign ins</span>
                        </li>
                        <li class="flex space-x-2">
                            <x-svg.check class="h-5 w-5 text-green-500"/>
                            <span>Unlimited locations</span>
                        </li>
                        <li class="flex space-x-2">
                            <x-svg.check class="h-5 w-5 text-green-500"/>
                            <span>Unlimited guest list exporting</span>
                        </li>
                    </ul>
                </div>
            </div>
        </main>
        <div class="mt-16 md:mt-0">
            <h2 class="text-4xl lg:text-5xl font-bold lg:tracking-tight">
                Everything you need to keep track of your visitors
            </h2>
            <p class="text-lg mt-4 text-slate-600">
                {{ config('app.name') }} comes batteries included. No fussing with complicated integrations. Just sign
                up
                and start tracking your visits.
            </p>
        </div>

        <div class="grid sm:grid-cols-2 md:grid-cols-3 mt-16 gap-16">
            <div class="flex gap-4 items-start">
                <div class="mt-1 bg-black rounded-full  p-2 w-8 h-8 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="text-white">
                        <path
                                d="M6 3a3 3 0 00-3 3v2.25a3 3 0 003 3h2.25a3 3 0 003-3V6a3 3 0 00-3-3H6zM15.75 3a3 3 0 00-3 3v2.25a3 3 0 003 3H18a3 3 0 003-3V6a3 3 0 00-3-3h-2.25zM6 12.75a3 3 0 00-3 3V18a3 3 0 003 3h2.25a3 3 0 003-3v-2.25a3 3 0 00-3-3H6zM17.625 13.5a.75.75 0 00-1.5 0v2.625H13.5a.75.75 0 000 1.5h2.625v2.625a.75.75 0 001.5 0v-2.625h2.625a.75.75 0 000-1.5h-2.625V13.5z"/>
                    </svg>

                </div>
                <div>
                    <h3 class="font-semibold text-lg">Custom Sign-in Page Creator</h3>
                    <p class="text-slate-500 mt-2 leading-relaxed">Easily design your own sign-in pages with a
                        user-friendly
                        interface, no technical skills required.</p>
                </div>
            </div>
            <div class="flex gap-4 items-start">
                <div class="mt-1 bg-black rounded-full  p-2 w-8 h-8 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="text-white">
                        <path d="M10.5 18a.75.75 0 000 1.5h3a.75.75 0 000-1.5h-3z"/>
                        <path fill-rule="evenodd"
                                d="M7.125 1.5A3.375 3.375 0 003.75 4.875v14.25A3.375 3.375 0 007.125 22.5h9.75a3.375 3.375 0 003.375-3.375V4.875A3.375 3.375 0 0016.875 1.5h-9.75zM6 4.875c0-.621.504-1.125 1.125-1.125h9.75c.621 0 1.125.504 1.125 1.125v14.25c0 .621-.504 1.125-1.125 1.125h-9.75A1.125 1.125 0 016 19.125V4.875z"
                                clip-rule="evenodd"/>
                    </svg>

                </div>
                <div>
                    <h3 class="font-semibold text-lg">iPad Compatibility</h3>
                    <p class="text-slate-500 mt-2 leading-relaxed">Use an iPad as a digital kiosk for guests to sign in
                        upon
                        arrival, offering a modern and efficient experience.</p>
                </div>
            </div>
            <div class="flex gap-4 items-start">
                <div class="mt-1 bg-black rounded-full  p-2 w-8 h-8 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="text-white">
                        <path fill-rule="evenodd"
                                d="M3 4.875C3 3.839 3.84 3 4.875 3h4.5c1.036 0 1.875.84 1.875 1.875v4.5c0 1.036-.84 1.875-1.875 1.875h-4.5A1.875 1.875 0 013 9.375v-4.5zM4.875 4.5a.375.375 0 00-.375.375v4.5c0 .207.168.375.375.375h4.5a.375.375 0 00.375-.375v-4.5a.375.375 0 00-.375-.375h-4.5zm7.875.375c0-1.036.84-1.875 1.875-1.875h4.5C20.16 3 21 3.84 21 4.875v4.5c0 1.036-.84 1.875-1.875 1.875h-4.5a1.875 1.875 0 01-1.875-1.875v-4.5zm1.875-.375a.375.375 0 00-.375.375v4.5c0 .207.168.375.375.375h4.5a.375.375 0 00.375-.375v-4.5a.375.375 0 00-.375-.375h-4.5zM6 6.75A.75.75 0 016.75 6h.75a.75.75 0 01.75.75v.75a.75.75 0 01-.75.75h-.75A.75.75 0 016 7.5v-.75zm9.75 0A.75.75 0 0116.5 6h.75a.75.75 0 01.75.75v.75a.75.75 0 01-.75.75h-.75a.75.75 0 01-.75-.75v-.75zM3 14.625c0-1.036.84-1.875 1.875-1.875h4.5c1.036 0 1.875.84 1.875 1.875v4.5c0 1.035-.84 1.875-1.875 1.875h-4.5A1.875 1.875 0 013 19.125v-4.5zm1.875-.375a.375.375 0 00-.375.375v4.5c0 .207.168.375.375.375h4.5a.375.375 0 00.375-.375v-4.5a.375.375 0 00-.375-.375h-4.5zm7.875-.75a.75.75 0 01.75-.75h.75a.75.75 0 01.75.75v.75a.75.75 0 01-.75.75h-.75a.75.75 0 01-.75-.75v-.75zm6 0a.75.75 0 01.75-.75h.75a.75.75 0 01.75.75v.75a.75.75 0 01-.75.75h-.75a.75.75 0 01-.75-.75v-.75zM6 16.5a.75.75 0 01.75-.75h.75a.75.75 0 01.75.75v.75a.75.75 0 01-.75.75h-.75a.75.75 0 01-.75-.75v-.75zm9.75 0a.75.75 0 01.75-.75h.75a.75.75 0 01.75.75v.75a.75.75 0 01-.75.75h-.75a.75.75 0 01-.75-.75v-.75zm-3 3a.75.75 0 01.75-.75h.75a.75.75 0 01.75.75v.75a.75.75 0 01-.75.75h-.75a.75.75 0 01-.75-.75v-.75zm6 0a.75.75 0 01.75-.75h.75a.75.75 0 01.75.75v.75a.75.75 0 01-.75.75h-.75a.75.75 0 01-.75-.75v-.75z"
                                clip-rule="evenodd"/>
                    </svg>

                </div>
                <div>
                    <h3 class="font-semibold text-lg">QR Code Check-In</h3>
                    <p class="text-slate-500 mt-2 leading-relaxed">Provide a quick and contactless sign-in option for
                        guests
                        using QR codes, which they can scan and sign in using their smartphones. </p>
                </div>
            </div>
            <div class="flex gap-4 items-start">
                <div class="mt-1 bg-black rounded-full  p-2 w-8 h-8 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="text-white">
                        <path fill-rule="evenodd"
                                d="M1.5 5.625c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 18.375V5.625zM21 9.375A.375.375 0 0020.625 9h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zm0 3.75a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zm0 3.75a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zM10.875 18.75a.375.375 0 00.375-.375v-1.5a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5zM3.375 15h7.5a.375.375 0 00.375-.375v-1.5a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375zm0-3.75h7.5a.375.375 0 00.375-.375v-1.5A.375.375 0 0010.875 9h-7.5A.375.375 0 003 9.375v1.5c0 .207.168.375.375.375z"
                                clip-rule="evenodd"/>
                    </svg>

                </div>
                <div>
                    <h3 class="font-semibold text-lg">Daily Customer Logs</h3>
                    <p class="text-slate-500 mt-2 leading-relaxed">Access and export detailed lists of customer
                        check-ins
                        for any given day, helping you keep track of visitor flow and attendance.</p>
                </div>
            </div>
            <div class="flex gap-4 items-start">
                <div class="mt-1 bg-black rounded-full  p-2 w-8 h-8 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="text-white">
                        <path fill-rule="evenodd"
                                d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z"
                                clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-lg">Multi-Location Management</h3>
                    <p class="text-slate-500 mt-2 leading-relaxed">Set up different profiles for each of your business
                        locations, enabling unique sign-in experiences and management tailored to each site's specific
                        needs</p>
                </div>
            </div>
            <div class="flex gap-4 items-start">
                <div class="mt-1 bg-black rounded-full  p-2 w-8 h-8 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="text-white">
                        <path fill-rule="evenodd"
                                d="M4.5 3.75a3 3 0 00-3 3v10.5a3 3 0 003 3h15a3 3 0 003-3V6.75a3 3 0 00-3-3h-15zm4.125 3a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5zm-3.873 8.703a4.126 4.126 0 017.746 0 .75.75 0 01-.351.92 7.47 7.47 0 01-3.522.877 7.47 7.47 0 01-3.522-.877.75.75 0 01-.351-.92zM15 8.25a.75.75 0 000 1.5h3.75a.75.75 0 000-1.5H15zM14.25 12a.75.75 0 01.75-.75h3.75a.75.75 0 010 1.5H15a.75.75 0 01-.75-.75zm.75 2.25a.75.75 0 000 1.5h3.75a.75.75 0 000-1.5H15z"
                                clip-rule="evenodd"/>
                    </svg>

                </div>
                <div>
                    <h3 class="font-semibold text-lg">Returning Customer Recognition</h3>
                    <p class="text-slate-500 mt-2 leading-relaxed">Remembers returning customers, offering a quicker
                        sign-in process and a personalized welcome, enhancing their experience and your relationship
                        with
                        them.</p>
                </div>
            </div>
        </div>
        <div
                class="bg-black p-8 md:px-20 md:py-20 mt-20 mx-auto max-w-5xl rounded-lg flex flex-col items-center text-center">
            <h2 class="text-white text-4xl md:text-5xl tracking-tight">
                Say goodbye to paper sign-in sheets
            </h2>
            <p class="text-slate-400 mt-4 text-lg md:text-xl">
                Welcome your visitors with our friendly digital sign-in solution, making their experience smoother and
                your
                management hassle-free.
            </p>
            <div class="flex mt-5">
                <a href="{{ route('register') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Get
                    Started
                </a>
            </div>
        </div>

    </div>
    <footer class="my-20">
        <p class="text-center text-sm text-slate-500">
            Copyright © {{ now()->format('Y') }} {{ config('app.name') }}. All rights reserved.
        </p>
    </footer>
</x-guest-layout>
