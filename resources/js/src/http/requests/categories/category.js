import {Resource} from '@request/index'
import axios from '@/http/axios'

class Category extends Resource {
    constructor () {
        super()
        this.namespace = '/admin/categories'
    }

    async toggleBlock (id) {

        return  axios.patch(`${this.namespace}/${id}/block`)
    }


}

export default new Category()
