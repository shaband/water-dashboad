import axios from '@/http/axios'
class Home {
    constructor () {

        this.namespace = '/admin'
    }

    async index () {

        return axios.get(`${this.namespace}/home`)

    }
}

export default new Home()
