import i18n from '@/i18n/i18n'

export default [
    {
        url: '/admin/home',
        name: 'Home',
        slug: 'home',
        icon: 'HomeIcon',
        i18n: "home",
    }, {
        url: '/admin/roles',
        name: 'Roles',
        slug: 'roles',
        icon: 'AnchorIcon',
        role: 'View Roles',
        i18n: "roles",
    }, {
        url: '/admin/admins',
        name: 'Admins',
        slug: 'admins',
        icon: 'UsersIcon',
        role: 'View Admin',
        i18n: "admins",

    }, {
        url: '/admin/cities',
        name: 'Cities',
        slug: 'city',
        icon: 'MapPinIcon',
        role: 'View City',
        i18n: "cities",

    },
    {
        url: '/admin/categories',
        name: 'Categories',
        slug: 'category',
        icon: 'FilterIcon',
        role: 'View Category',
        i18n: "categories",
    },
    {
        url: '/admin/marks',
        name: 'marks',
        slug: 'mark',
        icon: 'GiftIcon',
        role: 'View Mark',
        i18n: "marks",
    },
    {
        url: '/admin/car-types',
        name: 'car types',
        slug: 'car types',
        icon: 'LifeBuoyIcon',
        //    iconPack:'material-icons',
        role: 'View Cartype',
        i18n: "car types",
    },
    {
        url: '/admin/promocodes',
        name: 'promocodes',
        slug: 'Promocode',
        icon: 'ShoppingBagIcon',
        //    iconPack:'material-icons',
        role: 'View Promocode',
        i18n: "promocodes",
    },
    {
        url: '/admin/addresses',
        name: 'addresses',
        slug: 'address',
        icon: 'FeatherIcon',
        role: 'View Address',
        i18n: "addresses",
    },
    {
        url: null,
        name: 'Invoices',
        icon: 'ShoppingBagIcon',
        i18n: 'invoices',
        /*new|delivery_approval|delivering|finished|canceled*/
        submenu: [
            {
                url: '/admin/invoices/new',
                name: 'New',
                slug: 'New',
                i18n: "new",
                role:"View Order",
            },
            {
                url: '/admin/invoices/delivering',
                name: 'Delivering',
                slug: 'Delivering',
                i18n: "delivering",
                role:"View Order",
            },
            {
                url: '/admin/invoices/canceled',
                name: 'Canceled',
                slug: 'Canceled ',
                i18n: "canceled",
                role:"View Order",
            },
            {
                url: '/admin/invoices/finished',
                name: 'Finished',
                slug: 'Finished ',
                i18n: "finished",
                role:"View Order",
            },
        ]
    },


    {
        url: '/admin/products',
        name: 'products',
        slug: 'product',
        icon: 'PackageIcon',
        role: 'View Product',
        i18n: "products",

    }, {
        url: '/admin/agents',
        name: 'agents',
        slug: 'agent',
        icon: 'RepeatIcon',
        role: 'View Agent',
        i18n: "agents",
    }, {
        url: '/admin/deliveries',
        name: 'deliveries',
        slug: 'delivery',
        icon: 'TruckIcon',
        role: 'View Delivery',
        i18n: "deliveries",

    }, {
        url: '/admin/users',
        name: 'users',
        slug: 'user',
        icon: 'UserIcon',
        role: 'View User',
        i18n: "users",
    }, {
        url: '/admin/providers',
        name: 'providers',
        slug: 'provider',
        icon: 'HashIcon',
        role: 'View Provider',
        i18n: "providers",
    }, {
        url: '/admin/settings',
        name: 'settings',
        slug: 'setting',
        icon: 'SettingsIcon',
        role: 'Show Settings',
        i18n: "settings",

    },
    {
        url: '/admin/chat',
        name: 'chat',
        slug: 'chat',
        icon: 'AtSignIcon',
        i18n: "chat",
        //   role: 'Show Settings'
    }


]

