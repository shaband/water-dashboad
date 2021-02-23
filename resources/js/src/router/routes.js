import admin from './admin'

export default [
    ...admin,
    {


        path: '',
        component: () => import('@/layouts/full-page/FullPage.vue'),
        children: [
            {
                path: '/not-found',
                name: 'page-error-404',
                component: () => import('@/views/pages/Error404.vue')
            },
            {
                path: '/NotAuthorized',
                name: 'NotAuthorized',
                component: () => import('@/views/pages/NotAuthorized')
            }
        ]
    },
    // Redirect to 404 page, if no match found
    {
        path: '*',
        redirect: '/pages/error-404'
    }


]
