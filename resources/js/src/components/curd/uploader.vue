<template>

    <ValidationProvider :vid="input" :name="input" v-slot="{ errors }">
        <h6>{{ text }}</h6>

        <vs-upload automatic fileName="file" action="/file/uploader" @on-success="successUpload"
                   @on-error="errorUpload" @on-delete="DeleteUpload" :limit="1" :single-upload="true"
                   :text="text"
                   :show-upload-button="false" ref="uploader"/>

        <div
            class="con-text-validation span-text-validation-danger vs-input--text-validation-span v-enter-to"
            style="height: 19px;"><span class="span-text-validation">
                    {{ errors[0] }}
                    </span>
        </div>
    </ValidationProvider>

</template>
<script>

import axios from 'axios'
import {ValidationProvider} from 'vee-validate'

export default {
    name: 'file-uploader',
    components: {
        ValidationProvider
    },
    props: {
        text: {
            type: String,
            required: false,
            default: () => 'Upload File'
        },
        form: {
            type: Object,
            required: true
        },
        input: {
            type: String,
            required: false,
            default: 'image'
        }
    },
    methods: {
        successUpload (data) {
            this.$emit('successUpload', JSON.parse(data.target.response).file)
            this.$set(this.form, this.input, JSON.parse(data.target.response).file)
            this.$vs.notify({
                color: 'success',
                title: 'Upload Success'
            })
        },
        async DeleteUpload () {
            await axios.post('/file/remove',
                {file: this.form.image}
            )
            this.$vs.notify({
                color: 'success',
                title: 'File Removed '
            })
            this.$delete(this.form, this.input)
            this.$emit('successRemove', JSON.parse(data.target.response).file)

        },
        errorUpload () {

            this.$vs.notify({
                color: 'danger',
                title: 'Upload failed'
            })
        }
    }
}
</script>
