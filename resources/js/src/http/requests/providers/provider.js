import {Resource} from '@request/index'
import axios from '@/http/axios'

class Provider extends Resource {
    constructor () {
        super()
        this.namespace = '/admin/providers'
    }


}

export default new Provider()
