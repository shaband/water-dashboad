import {Resource} from '@request/index'

class Address extends Resource {
    constructor () {
        super()
        this.namespace = '/admin/addresses'
    }

}

export default new Address()
