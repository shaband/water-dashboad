import {Resource} from '@request/index'

class CarType extends Resource {
    constructor () {
        super()
        this.namespace = '/admin/car-types'
    }

}

export default new CarType()
