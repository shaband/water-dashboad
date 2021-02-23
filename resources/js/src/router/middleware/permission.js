import ability from '@/services/ability'
import get from 'lodash/get'

export const RedirectBackIfNotHavePermission = function (to, from, next) {
    let permission = get(to, 'meta.permission', null)
    if (permission !== null && !ability.can(permission)) {
        next({
            path: '/NotAuthorized'
        })
    }
    next()

}

