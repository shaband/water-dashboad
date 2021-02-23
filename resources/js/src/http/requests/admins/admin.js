import axios from '@/http/axios/index'
import {Resource} from '@request/index'

class Admin extends Resource {
    constructor () {
        super()
        this.namespace = '/admin/admins'
    }

}

export default new Admin()
