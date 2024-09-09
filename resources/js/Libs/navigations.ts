import {
    HomeIcon,
    CubeTransparentIcon,
    CpuChipIcon,
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

const endpoint = {
    name: 'Endpoint',
    href: route('endpoint.index'),
    icon: CpuChipIcon,
    current: route().current('endpoint.*'),
}

const fdt = {
    name: 'FAT',
    href: route('fdt.index'),
    icon: CpuChipIcon,
    current: route().current('fdt.*'),
}

const jb = {
    name: 'Join Box',
    href: route('jb.index'),
    icon: CpuChipIcon,
    current: route().current('jb.*'),
}

export const navigations = [
    dashboard,
    cluster,
    endpoint,
    fdt,
    jb,
]
