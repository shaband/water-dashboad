import {Resource} from '@request/index'
import axios from '@/http/axios'

class Chat extends Resource {
    constructor () {
        super()
        this.namespace = '/admin/chats'
    }


    async show (model, id, data = {}) {
        return axios.get(`${this.namespace}/${model}/${id}`, {
            params: data
        })
    }


}

export default new Chat()
