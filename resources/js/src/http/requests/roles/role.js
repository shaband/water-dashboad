import axios from '@/http/axios/index'
import {Resource} from '@request/index'

class Role extends Resource {
    constructor () {
        super()
        this.namespace = '/admin/roles'
    }

}

export default new Role()
