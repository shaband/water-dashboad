import {Resource} from '@request/index'
import axios from '@/http/axios'

class Agent extends Resource {
    constructor () {
        super()
        this.namespace = '/admin/agents'
    }
    async toggleBlock (id) {

        return  axios.patch(`${this.namespace}/${id}/block`)
    }


}

export default new Agent()
