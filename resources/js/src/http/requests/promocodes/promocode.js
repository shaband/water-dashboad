import {Resource} from '@request/index'

class Promocode extends Resource {
    constructor () {
        super()
        this.namespace = '/admin/promocodes'
    }

}

export default new Promocode()
