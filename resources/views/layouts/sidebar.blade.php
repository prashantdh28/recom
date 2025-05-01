<div class="sidebar dark [&.dark]:bg-coal-600 bg-light border-e border-e-gray-200 dark:border-e-coal-100 fixed top-0 bottom-0 z-20 hidden lg:flex flex-col items-stretch shrink-0"
    data-drawer="true" data-drawer-class="drawer drawer-start top-0 bottom-0" data-drawer-enable="true|lg:false"
    id="sidebar">
    <div class="sidebar-header hidden lg:flex items-center relative justify-between px-3 lg:px-6 shrink-0"
        id="sidebar_header">
        <a href="{{ route('dashboard') }}">
            {{-- <img class="default-logo min-h-[22px] max-w-none" src="assets/media/app/default-logo-dark.svg" /> --}}
            <x-application-logo />
            {{-- <img class="small-logo min-h-[22px] max-w-none" src="assets/media/app/mini-logo.svg" /> --}}
        </a>
        <div data-toggle="body" data-toggle-class="sidebar-collapse" id="sidebar_toggle">
            <div class="hidden [html.dark_&]:block">
                <button
                    class="btn btn-icon btn-icon-md size-[30px] rounded-lg border border-gray-300 bg-light text-gray-500 hover:text-gray-700 toggle absolute start-full top-2/4 -translate-x-2/4 -translate-y-2/4 rtl:translate-x-2/4">
                    <i
                        class="ki-filled ki-black-left-line toggle-active:rotate-180 transition-all duration-300 rtl:translate rtl:rotate-180 rtl:toggle-active:rotate-0">
                    </i>
                </button>
            </div>
            <div class="[html.dark_&]:hidden light">
                <button
                    class="btn btn-icon btn-icon-md size-[30px] rounded-lg border border-gray-200 bg-light text-gray-500 hover:text-gray-700 toggle absolute start-full top-2/4 -translate-x-2/4 -translate-y-2/4 rtl:translate-x-2/4">
                    <i
                        class="ki-filled ki-black-left-line toggle-active:rotate-180 transition-all duration-300 rtl:translate rtl:rotate-180 rtl:toggle-active:rotate-0">
                    </i>
                </button>
            </div>
        </div>
    </div>
    <div class="sidebar-content flex grow shrink-0 py-5 pe-2" id="sidebar_content">
        <div class="scrollable-y-hover grow shrink-0 flex ps-2 lg:ps-5 pe-1 lg:pe-3" data-scrollable="true"
            data-scrollable-dependencies="#sidebar_header" data-scrollable-height="auto" data-scrollable-offset="0px"
            data-scrollable-wrappers="#sidebar_content" id="sidebar_scrollable">
            <!-- Sidebar Menu -->
            <div class="menu flex flex-col grow gap-0.5" data-menu="true" data-menu-accordion-expand-all="false"
                id="sidebar_menu">

                <div class="menu-item here show" data-menu-item-toggle="accordion" data-menu-item-trigger="click">
                    <div class="menu-link flex items-center grow cursor-pointer border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px]"
                        tabindex="0">
                        <span class="menu-icon items-start text-white w-[20px]">
                            <i class="ki-filled ki-element-11 text-lg">
                            </i>
                        </span>
                        <span
                            class="menu-title text-sm font-medium text-white menu-item-active:text-primary menu-link-hover:!text-primary">
                            Transparency Management
                        </span>
                        <span class="menu-arrow text-white w-[20px] shrink-0 justify-end ms-1 me-[-10px]">
                            <i class="ki-filled ki-plus text-2xs menu-item-show:hidden">
                            </i>
                            <i class="ki-filled ki-minus text-2xs hidden menu-item-show:inline-flex">
                            </i>
                        </span>
                    </div>
                    <div
                        class="menu-accordion gap-0.5 ps-[10px] relative before:absolute before:start-[20px] before:top-0 before:bottom-0 before:border-s before:border-gray-200">
                        <div class="menu-item {{ request()->routeIs('account-config.*') ? 'active' : '' }}">
                            <a class="menu-link border border-transparent items-center grow menu-item-active:bg-secondary-active dark:menu-item-active:bg-coal-300 dark:menu-item-active:border-gray-100 menu-item-active:rounded-lg hover:bg-secondary-active dark:hover:bg-coal-300 dark:hover:border-gray-100 hover:rounded-lg gap-[14px] ps-[10px] pe-[10px] py-[8px]"
                                href="{{ route('account-config.index') }}" tabindex="0">
                                <span class="menu-bullet flex w-[6px] -start-[3px] rtl:start-0 relative before:absolute before:top-0 before:size-[6px] before:rounded-full rtl:before:translate-x-1/2 before:-translate-y-1/2 menu-item-active:before:bg-primary menu-item-hover:before:bg-primary">
                                </span>
                                <span class="menu-title text-2sm font-normal text-white menu-item-active:text-primary menu-item-active:font-semibold menu-link-hover:!text-primary">
                                    Account Config
                                </span>
                            </a>
                        </div>
                        <div class="menu-item {{ request()->routeIs('product-file.*') ? 'active' : '' }}">
                            <a class="menu-link border border-transparent items-center grow menu-item-active:bg-secondary-active dark:menu-item-active:bg-coal-300 dark:menu-item-active:border-gray-100 menu-item-active:rounded-lg hover:bg-secondary-active dark:hover:bg-coal-300 dark:hover:border-gray-100 hover:rounded-lg gap-[14px] ps-[10px] pe-[10px] py-[8px]"
                                href="{{ route('product-file.index') }}" tabindex="0">
                                <span class="menu-bullet flex w-[6px] -start-[3px] rtl:start-0 relative before:absolute before:top-0 before:size-[6px] before:rounded-full rtl:before:translate-x-1/2 before:-translate-y-1/2 menu-item-active:before:bg-primary menu-item-hover:before:bg-primary">
                                </span>
                                <span class="menu-title text-2sm font-normal text-white menu-item-active:text-primary menu-item-active:font-semibold menu-link-hover:!text-primary">
                                    Uploaded Product File
                                </span>
                            </a>
                        </div>

                        <div class="menu-item {{ request()->routeIs('product-list.*') ? 'active' : '' }}">
                            <a class="menu-link border border-transparent items-center grow menu-item-active:bg-secondary-active dark:menu-item-active:bg-coal-300 dark:menu-item-active:border-gray-100 menu-item-active:rounded-lg hover:bg-secondary-active dark:hover:bg-coal-300 dark:hover:border-gray-100 hover:rounded-lg gap-[14px] ps-[10px] pe-[10px] py-[8px]"
                                href="{{ route('product-list.index') }}" tabindex="0">
                                <span class="menu-bullet flex w-[6px] -start-[3px] rtl:start-0 relative before:absolute before:top-0 before:size-[6px] before:rounded-full rtl:before:translate-x-1/2 before:-translate-y-1/2 menu-item-active:before:bg-primary menu-item-hover:before:bg-primary">
                                </span>
                                <span class="menu-title text-2sm font-normal text-white menu-item-active:text-primary menu-item-active:font-semibold menu-link-hover:!text-primary">
                                    Product List
                                </span>
                            </a>
                        </div>

                        <div class="menu-item {{ request()->routeIs('transparency-code.index') ? 'active' : '' }}">
                            <a class="menu-link border border-transparent items-center grow menu-item-active:bg-secondary-active dark:menu-item-active:bg-coal-300 dark:menu-item-active:border-gray-100 menu-item-active:rounded-lg hover:bg-secondary-active dark:hover:bg-coal-300 dark:hover:border-gray-100 hover:rounded-lg gap-[14px] ps-[10px] pe-[10px] py-[8px]"
                                href="{{ route('transparency-code.index') }}" tabindex="0">
                                <span class="menu-bullet flex w-[6px] -start-[3px] rtl:start-0 relative before:absolute before:top-0 before:size-[6px] before:rounded-full rtl:before:translate-x-1/2 before:-translate-y-1/2 menu-item-active:before:bg-primary menu-item-hover:before:bg-primary">
                                </span>
                                <span class="menu-title text-2sm font-normal text-white menu-item-active:text-primary menu-item-active:font-semibold menu-link-hover:!text-primary">
                                    GTIN Code History
                                </span>
                            </a>
                        </div>

                    </div>
                </div>

                {{-- <div class="menu-item">
                    <div class="menu-label border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px]"
                        href="javascript:void(0)" tabindex="0">
                        <span class="menu-icon items-start text-gray-500 dark:text-gray-400 w-[20px]">
                            <i class="ki-filled ki-users text-lg">
                            </i>
                        </span>
                        <span class="menu-title text-sm font-medium text-gray-800">
                            Transparency Management
                        </span>
                    </div>
                </div> --}}

            </div>
            <!-- End of Sidebar Menu -->
        </div>
    </div>
</div>
