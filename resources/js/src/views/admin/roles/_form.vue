<template>
    <div>
        <div class="vx-row mb-2">
            <div class="vx-col w-full">

                <ValidationProvider vid="label_ar" name="label_ar" v-slot="{ errors }">
                    <vs-input class="w-full" v-model="form.label_ar" :label-placeholder=" $t('Name In Arabic')"
                              :danger="errors.length>0"
                              :danger-text="errors[0]"
                    />
                </ValidationProvider>
            </div>
        </div>
        <div class="vx-row mb-2">
            <div class="vx-col w-full">
                <ValidationProvider vid="label_en" name="label_en" v-slot="{ errors }">

                    <vs-input class="w-full" v-model="form.label_en" :label-placeholder=" $t('Name In English')"
                              :danger="errors.length>0"
                              :danger-text="errors[0]"/>
                </ValidationProvider>
            </div>
        </div>

        <div class="vx-row mb-2">
            <div class="vx-col w-full">
                <label class="vs-input--label"
                > {{ $t('permissions') }} </label>

                <ValidationProvider vid="permissions" name="permissions" v-slot="{ errors }">

                    <multiselect v-model="form.permissions" :options="permissionGroups" :multiple="true"
                                 group-values="permission" group-label="group" :group-select="true"
                                 :placeholder="$t('select Permission')" track-by="id" label="label_ar"><span
                        slot="noResult">{{ $t('Not Permission Found') }}</span>
                    </multiselect>

                    <div
                        class="con-text-validation span-text-validation-danger vs-input--text-validation-span v-enter-to"
                        style="height: 19px;"><span class="span-text-validation">
     {{ errors[0] }}
      </span></div>
                </ValidationProvider>

            </div>
        </div>
    </div>


</template>
<script>
import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.min.css'
import Permission from '@request/permissions/permission'
import {ValidationProvider} from 'vee-validate'

export default {

    props: {
        form: {
            require: true,
            type: Object
        }
    },
    components: {
        Multiselect,
        ValidationProvider
    },
    mounted () {
        this.getPermissions()
    },

    data () {
        return {
            permissionGroups: []
        }
    },


    methods: {
        async getPermissions () {
            Permission.admin().then(({data}) => {
                this.permissionGroups = data
            })
        }
    }
}


</script>
