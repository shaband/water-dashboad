import {Resource} from '@request'

class Invoice extends Resource {
    constructor () {
        super()
        this.namespace = '/admin/invoices'
    }

}

export default new Invoice()
