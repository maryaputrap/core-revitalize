<script setup xmlns="http://www.w3.org/1999/html">
import {computed, ref} from 'vue'
import {
    Dialog,
    DialogPanel,
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue'
import {ChevronDownIcon, ChevronRightIcon} from '@heroicons/vue/20/solid'
import {navigations} from "@/Libs/navigations";

import {
    Bars3Icon,
    XMarkIcon,
} from '@heroicons/vue/24/outline'
import {router, usePage} from "@inertiajs/vue3";

const sidebarOpen = ref(false)

const page = usePage()

const user = computed(() => page.props.auth.user)

const allowedNavigation = computed(() => navigations)

// const allowedNavigation = computed(() => {
//     const authRoles = auth.value.roles
//     return navigations.filter(nav =>
//         authRoles.some(authRole => nav.roles.includes(authRole))
//     )
// })
</script>

<template>
    <!--
      This example requires updating your template:

      ```
      <html class="h-full bg-white">
      <body class="h-full">
      ```
    -->
    <div>
        <TransitionRoot as="template" :show="sidebarOpen">
            <Dialog as="div" class="relative z-50 lg:hidden" @close="sidebarOpen = false">
                <TransitionChild as="template" enter="transition-opacity ease-linear duration-300"
                                 enter-from="opacity-0" enter-to="opacity-100"
                                 leave="transition-opacity ease-linear duration-300" leave-from="opacity-100"
                                 leave-to="opacity-0">
                    <div class="fixed inset-0 bg-gray-900/80"/>
                </TransitionChild>

                <div class="fixed inset-0 flex">
                    <TransitionChild as="template" enter="transition ease-in-out duration-300 transform"
                                     enter-from="-translate-x-full" enter-to="translate-x-0"
                                     leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0"
                                     leave-to="-translate-x-full">
                        <DialogPanel class="relative mr-16 flex w-full max-w-xs flex-1">
                            <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0"
                                             enter-to="opacity-100" leave="ease-in-out duration-300"
                                             leave-from="opacity-100" leave-to="opacity-0">
                                <div class="absolute top-0 left-full flex w-16 justify-center pt-5">
                                    <button type="button" class="-m-2.5 p-2.5" @click="sidebarOpen = false">
                                        <span class="sr-only">Close sidebar</span>
                                        <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true"/>
                                    </button>
                                </div>
                            </TransitionChild>
                            <!-- Sidebar component, swap this element with another sidebar if you like -->
                            <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-secondary-dark px-6 pb-4">
                                <div class="flex h-16 shrink-0 items-center">
                                    <div class="flex h-16 shrink-0 items-center">
                                        <div class="h-8 w-8"></div>
                                    </div>
                                </div>
                                <nav class="flex flex-1 flex-col">
                                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                                        <li>
                                            <ul role="list" class="-mx-2 space-y-1">
                                                <li v-for="item in allowedNavigation" :key="item.name">
                                                    <a v-if="!item.children" :href="item.href" :class="[item.current ? 'bg-secondary' : 'hover:bg-secondary', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold text-white']">
                                                        <component :is="item.icon" class="h-6 w-6 shrink-0 text-white" aria-hidden="true" />
                                                        {{ item.name }}
                                                    </a>
                                                    <Disclosure as="div" v-else v-slot="{ open }">
                                                        <DisclosureButton :class="[item.current ? 'bg-secondary' : 'hover:bg-secondary', 'flex items-center w-full text-left rounded-md p-2 gap-x-3 text-sm leading-6 font-semibold text-white']">
                                                            <component :is="item.icon" class="h-6 w-6 shrink-0 text-white" aria-hidden="true" />
                                                            {{ item.name }}
                                                            <ChevronRightIcon :class="[(open || item.rootCurrent) ? 'rotate-90' : '', 'ml-auto h-5 w-5 shrink-0 text-white']" aria-hidden="true" />
                                                        </DisclosureButton>
                                                        <div v-show="open || item.rootCurrent">
                                                            <DisclosurePanel as="ul" class="mt-1 px-2" static>
                                                                <li v-for="subItem in item.children" :key="subItem.name">
                                                                    <!-- 44px -->
                                                                    <DisclosureButton as="a" :href="subItem.href" :class="[subItem.current ? 'bg-secondary' : 'hover:bg-secondary', 'block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-white']">{{ subItem.name }}</DisclosureButton>
                                                                </li>
                                                            </DisclosurePanel>
                                                        </div>
                                                    </Disclosure>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </Dialog>
        </TransitionRoot>

        <!-- Static sidebar for desktop -->
        <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
            <!-- Sidebar component, swap this element with another sidebar if you like -->
            <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-secondary-dark px-6 pb-4">
                <div class="flex h-16 shrink-0 items-center">
                    <div class="flex h-16 shrink-0 items-center">
                        <div class="font-medium text-white">Core Revitalize</div>
                    </div>
                </div>
                <nav class="flex flex-1 flex-col">
                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                        <li>
                            <ul role="list" class="-mx-2 space-y-1">
                                <li v-for="item in allowedNavigation" :key="item.name">
                                    <a v-if="!item.children" :href="item.href" :class="[item.current ? 'bg-secondary' : 'hover:bg-secondary', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold text-white']">
                                        <component :is="item.icon" class="h-6 w-6 shrink-0 text-white" aria-hidden="true" />
                                        {{ item.name }}
                                    </a>
                                    <Disclosure as="div" v-else v-slot="{ open }">
                                        <DisclosureButton :class="[item.current ? 'bg-secondary' : 'hover:bg-secondary', 'flex items-center w-full text-left rounded-md p-2 gap-x-3 text-sm leading-6 font-semibold text-white']">
                                            <component :is="item.icon" class="h-6 w-6 shrink-0 text-white" aria-hidden="true" />
                                            {{ item.name }}
                                            <ChevronRightIcon :class="[(open || item.rootCurrent) ? 'rotate-90' : '', 'ml-auto h-5 w-5 shrink-0 text-white']" aria-hidden="true" />
                                        </DisclosureButton>
                                        <div v-show="open || item.rootCurrent">
                                            <DisclosurePanel as="ul" class="mt-1 px-2" static>
                                                <li v-for="subItem in item.children" :key="subItem.name">
                                                    <!-- 44px -->
                                                    <DisclosureButton as="a" :href="subItem.href" :class="[subItem.current ? 'bg-secondary' : 'hover:bg-secondary', 'block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-white']">{{ subItem.name }}</DisclosureButton>
                                                </li>
                                            </DisclosurePanel>
                                        </div>
                                    </Disclosure>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="lg:pl-72">
            <div
                class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
                <button type="button" class="text-gray-700 -m-2.5 p-2.5 lg:hidden" @click="sidebarOpen = true">
                    <span class="sr-only">Open sidebar</span>
                    <Bars3Icon class="h-6 w-6" aria-hidden="true"/>
                </button>

                <!-- Separator -->
                <div class="h-6 w-px bg-gray-900/10 lg:hidden" aria-hidden="true"/>

                <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
                    <form class="relative flex flex-1" action="#" method="GET">

                    </form>
                    <div class="flex items-center gap-x-4 lg:gap-x-6">
                        <!-- Profile dropdown -->
                        <Menu as="div" class="relative">
                            <MenuButton class="flex items-center -m-1.5 p-1.5">
                                <span class="sr-only">Open user menu</span>

                                <span class="hidden lg:flex lg:items-center">
                                <span class="ml-4 text-sm font-semibold leading-6 text-gray-900" aria-hidden="true">{{ user.name }}</span>
                                  <ChevronDownIcon class="ml-2 h-5 w-5 text-gray-400" aria-hidden="true"/>
                                </span>
                            </MenuButton>
                            <transition enter-active-class="transition duration-100 ease-out"
                                        enter-from-class="scale-95 transform opacity-0"
                                        enter-to-class="scale-100 transform opacity-100"
                                        leave-active-class="transition duration-75 ease-in"
                                        leave-from-class="scale-100 transform opacity-100"
                                        leave-to-class="scale-95 transform opacity-0">
                                <MenuItems
                                    class="absolute right-0 z-10 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 mt-2.5 focus:outline-none">
<!--                                    <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">-->
<!--                                        <a :href="item.href"-->
<!--                                           :class="[active ? 'bg-gray-50' : '', 'block px-3 py-1 text-sm leading-6 text-gray-900']">-->
<!--                                            {{  item.name }}</a>-->
<!--                                    </MenuItem>-->
                                    <MenuItem v-slot="{ active }">
                                        <a
                                            href="#"
                                            :class="[active ? 'bg-gray-50' : '', 'block px-3 py-1 text-sm leading-6 text-gray-900']"
                                            @click.prevent="router.post(route('logout'))"
                                        >
                                            Sign out
                                        </a>
                                    </MenuItem>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>
                </div>
            </div>

            <main class="py-10 min-h-dvh bg-grayscale-surface">
                <div class="px-4 sm:px-6 lg:px-8 h-full">
                    <!-- Your content -->
                    <slot/>
                </div>
            </main>
        </div>
    </div>
</template>
