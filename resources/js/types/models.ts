export interface Pagination<T> {
    current_page: number,
    data: T[],
    first_page_url: string | null,
    from: number,
    last_page: number,
    last_page_url: string | null,
    links: {
        url: string | null,
        label: string,
        active: boolean,
    }[],
    next_page_url: string | null,
    path: string | null,
    per_page: number,
    prev_page_url: string | null,
    to: number,
    total: number,
}

export interface OptionReference {
    id?: string
    hash?: string
    code: string
    content: string
}

export interface Cluster {
    id?: string
    hash?: string
    name: string
    address: string
    latitude: number
    longitude: number
    deleted_at?: string|null
}

export interface Container {
    id?: string
    hash?: string
    cluster_id: string
    code: string
    name: string
    latitude: number
    longitude: number
    cluster?: Cluster
}

export interface Endpoint {
    id?: string
    hash: string
    type_id: string
    cluster_id: string
    container_id: string
    code: string
    name: string
    port_total: string
    deleted_at?: string
    cluster?: Cluster
    container?: Container
    type?: OptionReference
    ports?: Port[]
}

export interface Port {
    id?: string
    hash?: string
    endpoint_id: string
    name: string
    is_connected: boolean
    splitter: string
    endpoint?: Endpoint
    to_ports: Port[]
    additional_data?: {
        position: string
    }
}
