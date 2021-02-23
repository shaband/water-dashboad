<template>
    <div>
        <div class="vx-row mb-2">
            <div class="vx-col w-full">

                <ValidationProvider vid="name_en" name="name_en" v-slot="{ errors }">
                    <vs-input class="w-full" name="name_en" v-model="form.name_en" :label=" $t('Name In English')"
                              :danger="errors.length>0"
                              :danger-text="errors[0]"
                    />
                </ValidationProvider>
            </div>
        </div>
        <div class="vx-row mb-2">
            <div class="vx-col w-full">

                <ValidationProvider vid="name_ar" name="name_ar" v-slot="{ errors }">
                    <vs-input class="w-full" name="name_ar" v-model="form.name_ar" :label=" $t('Name In Arabic')"
                              :danger="errors.length>0"
                              :danger-text="errors[0]"
                    />
                </ValidationProvider>
            </div>
        </div>
        <div class="vx-row mb-2">
            <div class="vx-col w-full">
                <file-uploader :form="form" :text="$t('Upload Image')"/>
            </div>
        </div>


    </div>


</template>
<script>

import 'vue-multiselect/dist/vue-multiselect.min.css'
import {ValidationProvider} from 'vee-validate'
import role from '@request/roles/role'
import vSelect from 'vue-select'
import FileUploader from '@component/curd/uploader'

export default {
    props: {
        form: {
            require: true,
            type: Object
        }
    },

    components: {
        FileUploader,
        ValidationProvider
    }

}


</script>
