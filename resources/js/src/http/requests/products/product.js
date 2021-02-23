import {Resource} from '@request/index'

class Product extends Resource {
    constructor () {
        super()
        this.namespace = '/admin/products'
    }

}

export default new Product()
