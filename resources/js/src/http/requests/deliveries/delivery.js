import {Resource} from '@request/index'
import axios from '@/http/axios'

class Delivery extends Resource {
    constructor () {
        super()
        this.namespace = '/admin/deliveries'
    }

    async toggleBlock (id) {

        return axios.patch(`${this.namespace}/${id}/block`)
    }

}

export default new Delivery()
