import {Resource} from '@request/index'
import axios from '@/http/axios'

class Mark extends Resource {
    constructor () {
        super()
        this.namespace = '/admin/marks'
    }
    async toggleBlock (id) {

        return  axios.patch(`${this.namespace}/${id}/block`)
    }


}

export default new Mark()
