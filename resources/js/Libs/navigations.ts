import {
    HomeIcon,
    CubeTransparentIcon
} from "@heroicons/vue/24/outline";

const dashboard = {
    name: 'Dashboard',
    href: route('dashboard'),
    icon: HomeIcon,
    current: route().current('dashboard'),
}

const cluster = {
    name: 'Cluster',
    href: route('cluster.index'),
    icon: CubeTransparentIcon,
    current: route().current('cluster.*'),
}

export const navigations = [
    dashboard,
    cluster,
]
