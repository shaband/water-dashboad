<template>
    <div>

        <div class="vx-row mb-2">
            <div class="vx-col w-full">

                <ValidationProvider vid="name" name="name" v-slot="{ errors }">
                    <vs-input class="w-full" name="name" v-model="form.name" :label=" $t('Name')"
                              :danger="errors.length>0"
                              :danger-text="errors[0]"
                    />
                </ValidationProvider>
            </div>
        </div>
        <div class="vx-row mb-2">
            <div class="vx-col w-full">

                <ValidationProvider vid="email" name="email" v-slot="{ errors }">
                    <vs-input type="email" name="email" class="w-full" v-model="form.email"
                              :label=" $t('E-mail Address')"
                              :danger="errors.length>0"
                              :danger-text="errors[0]"
                    />
                </ValidationProvider>
            </div>
        </div>
        <div class="vx-row mb-2">
            <div class="vx-col w-full">

                <ValidationProvider vid="password" name="password" v-slot="{ errors }">
                    <vs-input type="password" name="password" class="w-full" v-model="form.password"
                              :label=" $t('Password')"
                              :danger="errors.length>0"
                              :danger-text="errors[0]"
                    />
                </ValidationProvider>
            </div>
        </div>
        <div class="vx-row mb-2">
            <div class="vx-col w-full">

                <ValidationProvider vid="password_confirmation" name="password_confirmation" v-slot="{ errors }">
                    <vs-input class="w-full" type="password" v-model="form.password_confirmation"
                              :label=" $t('Password Confirmation')"
                              :danger="errors.length>0"
                              :danger-text="errors[0]"
                              name="password_confirmation"
                    />
                </ValidationProvider>
            </div>
        </div>
        <div class="vx-row mb-2">
            <div class="vx-col w-full">

                <ValidationProvider vid="phone" name="phone" v-slot="{ errors }">
                    <vs-input class="w-full" name="phone" v-model="form.phone" :label=" $t('Phone Number')"
                              :danger="errors.length>0"
                              :danger-text="errors[0]"
                    />
                </ValidationProvider>
            </div>
        </div>
        <div class="vx-row mb-2">
            <div class="vx-col w-full">

                <ValidationProvider vid="role_id" name="role_id" v-slot="{ errors }">
                    <h6>{{ $t('Role') }}</h6>

                    <v-select label="label_ar" v-model="form.role_id" :options="roles" dir="rtl"
                              :reduce="role => role.id"/>
                    <div
                        class="con-text-validation span-text-validation-danger vs-input--text-validation-span v-enter-to"
                        style="height: 19px;"><span class="span-text-validation">
                    {{ errors[0] }}
                    </span>
                    </div>
                </ValidationProvider>
            </div>
        </div>
        <div class="vx-row mb-2">
            <div class="vx-col w-full">

                <ValidationProvider vid="image" name="image" v-slot="{ errors }">
                    <h6>{{ $t('Profile Picture') }}</h6>

                    <vs-upload automatic fileName="file" action="/file/uploader" @on-success="successUpload"
                               @on-error="errorUpload" @on-delete="DeleteUpload" :limit="1" :single-upload="true"
                               :text="$t('Profile Picture')"
                               :show-upload-button="false" ref="uploader"/>

                    <div
                        class="con-text-validation span-text-validation-danger vs-input--text-validation-span v-enter-to"
                        style="height: 19px;"><span class="span-text-validation">
                    {{ errors[0] }}
                    </span>
                    </div>
                </ValidationProvider>
            </div>
        </div>

    </div>


</template>
<script>

import 'vue-multiselect/dist/vue-multiselect.min.css'
import {ValidationProvider} from 'vee-validate'
import role from '@request/roles/role'
import vSelect from 'vue-select'
import axios from 'axios'

export default {
    mounted () {
        this.getRoles()
    },
    props: {
        form: {
            require: true,
            type: Object
        }
    },
    data () {
        return {
            roles: []
        }
    },
    components: {
        ValidationProvider,
        'v-select': vSelect
    },
    methods: {
        getRoles () {
            role.every().then(({data: {data}}) => {
                this.roles = data
            })
        },
        successUpload (data) {
            this.$set(this.form, 'image', JSON.parse(data.target.response).file)
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
            this.$delete(this.form, 'image')

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
