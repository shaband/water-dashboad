import {Resource} from '@request/index'
import axios from '@/http/axios'

class Setting extends Resource {
    constructor () {
        super()
        this.namespace = '/admin/settings'
    }



}

export default new Setting()
