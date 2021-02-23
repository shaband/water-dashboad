import axios from '@/http/axios/index'
import {Resource} from '@request/index'

class User extends Resource {
    constructor () {
        super()
        this.namespace = '/admin/users'
    }
    async toggleBlock (id) {

        return  axios.patch(`${this.namespace}/${id}/block`)
    }

}

export default new User()
