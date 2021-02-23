import './auth'

import axios from '@/http/axios/index'
import flatten from 'lodash/flatten'

export class Resource {
    constructor () {
        this.namespace = ''
    }

    async all (page = 1, params = {}) {
        return axios.get(this.namespace, {
            params: {
                page: page,
                ...params
            }
        })
    }

    async every (page = 1) {
        let all = []
        let response = await this.all(page)
        all.push(response.data.data)

        if (response.data.links.next != null) {
            let response = await this.every(page + 1)
            all.push(response.data.data)
        }
        response.data.data = flatten(all)
        return response

    }


    async show (id, data = {}) {
        return axios.get(`${this.namespace}/${id}`, {
            params: data
        })
    }

    async store (data) {

        return axios.post(this.namespace, data)
    }

    async update (id, data) {

        return axios.patch(`${this.namespace}/${id}`, data)
    }

    async delete (id) {

        return axios.delete(`${this.namespace}/${id}`)
    }
}

