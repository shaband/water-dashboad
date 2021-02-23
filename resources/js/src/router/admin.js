import multiguard from 'vue-router-multiguard'
import {redirectIfGuest, redirectIfAdmin} from '@/router/middleware/admin/auth'
import {RedirectBackIfNotHavePermission} from '@/router/middleware/permission'
import store from '@/store/store'
import i18n from '@/i18n/i18n'

function generateResource (name, permission, path = null) {

    let file_path = path || name

    return [
        {
            path: name,
            name: `admin.${name}.index`,
            component: () => import(/* webpackChunkName: "[request]" */ `@views/admin/${file_path}/list`),
            meta: {
                permission: `View ${permission}`,
           //      pageTitle:i18n.t(name)

            }
        },
        {
            path: `${name}/create`,
            name: `admin.${name}.create`,
            component: () => import(/* webpackChunkName: "[request]" */ `@views/admin/${file_path}/create`),
            meta: {
                permission: `Create ${permission}`
            }
        },
        {
            path: `${name}/:id/edit`,
            name: `admin.${name}.edit`,
            component: () => import(/* webpackChunkName: "[request]" */ `@views/admin/${name}/edit`),
            meta: {
                permission: `Edit ${permission}`
            }
        }

    ]
}


export default [

    {
        path: '/admin',
        component: () => import('@/layouts/admin/full-page/FullPage.vue'),
        children: [
            {
                path: 'login',
                name: 'admin.login',
                component: () => import('@/views/admin/auth/Login'),
                beforeEnter: multiguard([redirectIfAdmin])

            },
            {
                path: 'forgot-password',
                name: 'password.forgot',
                component: () => import('@/views/admin/auth/forgetPassword'),
                beforeEnter: multiguard([redirectIfAdmin])

            },{
                path: 'reset-password',
                name: 'password.reset',
                component: () => import('@/views/admin/auth/resetPassword'),
                beforeEnter: multiguard([redirectIfAdmin])

            },
        ]
    },

    {
        // =============================================================================
        // ADMIN LAYOUT ROUTES
        // =============================================================================
        path: '/admin',
        component: () => import('@/layouts/admin/Main.vue'),
        children: [
            {
                path: 'home',
                name: 'admin.home',
                component: () => import('@views/admin/Home.vue'),
                meta: {
                    //permission: 'View Roles',
                //    pageTitle:i18n.t('Home')

                }
            },
            ...generateResource('roles', 'Roles'),
            ...generateResource('admins', 'Admin'),
            {
                path: 'admins/:id/profile',
                name: 'admin.admins.profile',
                component: () => import(/* webpackChunkName: "[request]" */ '@views/admin/admins/edit'),
                beforeEnter: (to, from, next) => {


                    if (parseFloat(to.params.id) !== store.getters['auth/getAdminInfo']['id']) {
                        next({
                            path: '/NotAuthorized'
                        })
                    }
                    next()
                }

            },
            ...generateResource('cities', 'City'),
            ...generateResource('car-types', 'Cartype','car_types'),
            ...generateResource('categories', 'Category'),
            ...generateResource('marks', 'Mark'),
            ...generateResource('addresses', 'Address'),
            ...generateResource('promocodes', 'Promocode'),
            ...generateResource('products', 'Product'),
            ...generateResource('deliveries', 'Delivery'),
            ...generateResource('agents', 'Agent'),
            ...generateResource('users', 'User'),
            ...generateResource('providers', 'Provider'),
            {
                path: 'settings',
                name: 'admin.settings.index',
                component: () => import( /* webpackChunkName: "[request]" */ '@views/admin/settings/list'),
                meta: {
                    permission: 'Show Settings',
                //    pageTitle:i18n.t('Settings')
                }
            },
            {
                path: 'settings/:id/edit',
                name: 'admin.settings.edit',
                component: () => import(/* webpackChunkName: "[request]" */ '@views/admin/settings/edit'),
                meta: {
                    permission: 'Edit Settings',
               //     pageTitle:i18n.t('Edit Settings')
                }
            },

            {
                path: 'chat',
                name: 'admin.chat.index',
                component: () => import(/* webpackChunkName: "[request]" */ '@views/admin/chats/Chat'),
                meta: {
            //        pageTitle:i18n.t('Chat')
                }
            },
            {
/*'new', 'delivery_approval', 'delivering', 'finished', 'canceled'*/
                path: 'invoices/:status(new|delivery_approval|delivering|finished|canceled)',
                name: 'admin.invoice.index',
                component: () => import(/* webpackChunkName: "[request]" */ '@views/admin/invoices/list'),
                meta: {
                    permission:'View Order',
          //          pageTitle:i18n.t('Invoices')
                }
            },
            {
                path: 'invoices/:id(\\d+)',
                name: 'admin.invoice.show',
                component: () => import(/* webpackChunkName: "[request]" */ '@views/admin/invoices/show'),
                meta: {
             //       pageTitle:i18n.t('invoices')
                }
            }

        ],
        beforeEnter: multiguard([redirectIfGuest, RedirectBackIfNotHavePermission])

    }
]
