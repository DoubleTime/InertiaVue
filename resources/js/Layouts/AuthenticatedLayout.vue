<script setup>
import { ref, onBeforeMount, onMounted, computed } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import { Link, usePage } from '@inertiajs/vue3';
import FlashAlert from '@/Components/FlashAlert.vue';

//Load Menu from config('menus.items')
const menus = computed(() => usePage().props.menus);
//If submenu is active, set the parent active as well
const isParentMenuActive = computed(() => {
    return targetTitle => {
        const titles = findActiveMenus(route().current());
        return titles != null ? titles.includes(targetTitle) : false;
    };
});

//Return all active menu titles
function findActiveMenus(route, submenu = null, parent = null, grandParent = null) {
    const menu = submenu ?? menus.value;
    for (const item of menu) {
        if (item.route === route) {
            if (grandParent) {
                return [grandParent.title, parent.title];
            } else if (parent) {
                return [parent.title];
            } else {
                return [item.title];
            }
        }
        if (item.submenus) {
            const foundRoute = findActiveMenus(route, item.submenus, item, parent);
            if (foundRoute) {
                return foundRoute;
            }
        }
    }
    return null;
}

onBeforeMount(() => {
    //Load CSS Auth Body
    document.body.className = 'auth';
    //Auth Page no need container class, remove it
    document.querySelector('#app').classList.remove('container');
})

onMounted(() => {
    //Responsive Layout Open Menu
    document.querySelector('#navbarSideCollapse').addEventListener('click', () => {
        document.querySelector('.offcanvas-collapse').classList.toggle('open')
    });

    //Multi level menu dropdown
    let $bs = bootstrap;
    const CLASS_NAME = 'has-child-dropdown-show';
    $bs.Dropdown.prototype.toggle = function (_orginal) {
        return function () {
            document.querySelectorAll('.' + CLASS_NAME).forEach(function (e) {
                e.classList.remove(CLASS_NAME);
            });
            let dd = this._element.closest('.dropdown').parentNode.closest('.dropdown');
            for (; dd && dd !== document; dd = dd.parentNode.closest('.dropdown')) {
                dd.classList.add(CLASS_NAME);
            }
            return _orginal.call(this);
        }
    }($bs.Dropdown.prototype.toggle);

    document.querySelectorAll('.dropdown').forEach(function (dd) {
        dd.addEventListener('hide.bs.dropdown', function (e) {
            if (this.classList.contains(CLASS_NAME)) {
                this.classList.remove(CLASS_NAME);
                e.preventDefault();
            }
            e.stopPropagation(); // do not need pop in multi level mode
        });
    });
})

</script>

<template>
    <nav class="navbar navbar-expand-lg fixed-top bg-dark" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <ApplicationLogo class="app-logo" width="50" height="50" /> Brand
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" id="navbarSideCollapse"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <template v-for="menu in menus">
                        <li v-if="menu.submenus?.length > 0" class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" :class="{ active: isParentMenuActive(menu.title) }" href="#"
                                data-bs-toggle="dropdown" aria-expanded="false">{{ menu.title }}</a>
                            <ul class="dropdown-menu">
                                <template v-for="submenu in menu.submenus" :key="submenu.title">
                                    <li v-if="submenu.submenus?.length > 0" class="dropdown dropend">
                                        <a class="dropdown-item dropdown-toggle"
                                            :class="{ active: isParentMenuActive(submenu.title) }" href="#"
                                            id="dropdown-layouts" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            {{ submenu.title }}
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdown-layouts">
                                            <template v-for="submenu2 in submenu.submenus">
                                                <NavLink :href="route(submenu2.route)"
                                                    :active="route().current(submenu2.route)" :isSubmenu="true">{{
                                                        submenu2.title }}
                                                </NavLink>
                                            </template>
                                        </div>
                                    </li>
                                    <li v-else-if="submenu.route" class="nav-item">
                                        <NavLink :href="route(submenu.route)" :active="route().current(submenu.route)"
                                            :isSubmenu="true">{{ submenu.title }}
                                        </NavLink>
                                    </li>
                                </template>
                            </ul>
                        </li>
                        <li v-else-if="menu.route" class="nav-item">
                            <NavLink :href="route(menu.route)" :active="route().current(menu.route)">{{ menu.title }}
                            </NavLink>
                        </li>
                    </template>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" :class="{ active: route().current('profile.edit') }" href="#"
                            id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img :src="'https://api.dicebear.com/6.x/bottts-neutral/svg?seed=' + $page.props.auth.user.name"
                                alt="User Avatar" width="40" height="40" class="rounded-circle me-2"> {{
                                    $page.props.auth.user.name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <Link :href="route('profile.edit')" class="dropdown-item"
                                    :class="{ active: route().current('profile.edit') }">
                                Profile
                                </Link>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <Link :href="route('logout')" method="post" as="button" class="dropdown-item">
                                Log Out
                                </Link>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Extra Menu Access 
        <div class="nav-scroller bg-body shadow-sm">
            <nav class="nav" aria-label="Secondary navigation">
                <a class="nav-link" href="#">
                    Friends
                    <span class="badge text-bg-light rounded-pill align-text-bottom">27</span>
                </a>
            </nav>
        </div>
    -->

    <main class="container">
        <h2 class="my-2 lh-sm" v-if="$slots.header">
            <slot name="header" />
        </h2>

        <FlashAlert v-if="$page.props.flash.message" @close="$page.props.flash.message = null">
            {{ $page.props.flash.message }}
        </FlashAlert>
        <slot />
    </main>
</template>

<style scoped>
.nav-scroller {
    position: relative;
    z-index: 2;
    height: 2.75rem;
    overflow-y: hidden;
}

.nav-scroller .nav {
    display: flex;
    flex-wrap: nowrap;
    padding-bottom: 1rem;
    margin-top: -1px;
    overflow-x: auto;
    text-align: center;
    white-space: nowrap;
    -webkit-overflow-scrolling: touch;
}

.app-logo {
    fill: currentColor;
}
</style>
