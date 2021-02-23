import axios from '@/http/axios/index'

class FCMToken {
    async store (prefix, data) {

        return axios.post(`/${prefix}/fcm-tokens`, data)
    }

}

export default new FCMToken()
