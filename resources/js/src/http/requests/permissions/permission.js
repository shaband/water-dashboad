import axios from '@/http/axios/index'

class permission {
    constructor () {
        this.namespace = '/admin/permissions'
    }

    async all () {
        return axios.get(this.namespace)
    }

    async admin () {
        return axios.get(this.namespace, {
            params: {
                guard: 'admin'
            }
        })
    }

    async store (data) {

        return axios.post(this.namespace, data)
    }

    async update (id, data) {

        return axios.patch(this.namespace, data)
    }

    async delete (id) {

        return axios.delete(this.namespace, data)
    }
}

export default new permission()
