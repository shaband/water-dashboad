import {Resource} from '@request/index'

class City extends Resource {
    constructor () {
        super()
        this.namespace = '/admin/cities'
    }

}

export default new City()
