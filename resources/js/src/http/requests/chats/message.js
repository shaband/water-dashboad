import {Resource} from '@request'

class Message extends Resource {
    constructor () {
        super()
        this.namespace = '/admin/messages'
    }



}

export default new Message()
