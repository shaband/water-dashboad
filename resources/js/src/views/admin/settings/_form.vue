<template>
    <div>
        <div class="vx-row mb-2">
            <div class="vx-col w-full">

                <ValidationProvider vid="value" name="value" v-slot="{ errors }">
                    <template v-if="['text','number','email'].includes(form.type)">
                        <vs-input class="w-full" :type="form.type" name="value" v-model="form.value"
                                  :label="form.slug"
                                  :danger="errors.length>0"
                                  :danger-text="errors[0]"
                        />
                    </template>
                    <template v-else-if="form.type==='select'">
                        <h6>{{ form.slug }}</h6>

                        <v-select v-model="form.value" :options="form.options" dir="rtl"
                                  :reduce="option => option.value"/>
                        <div
                            class="con-text-validation span-text-validation-danger vs-input--text-validation-span v-enter-to"
                            style="height: 19px;"><span class="span-text-validation">
                    {{ errors[0] }}
                    </span>
                        </div>
                    </template>
                    <template v-else-if="form.type==='textarea'">
                        <vs-textarea :label="form.slug" v-model="form.value"
                        />

                        <div
                            class="con-text-validation span-text-validation-danger vs-input--text-validation-span v-enter-to"
                            style="height: 19px;"><span class="span-text-validation">
                    {{ errors[0] }}
                    </span>
                        </div>
                    </template>
                </ValidationProvider>
            </div>
        </div>

    </div>


</template>
<script>

import {ValidationProvider} from 'vee-validate'
import vSelect from 'vue-select'

export default {
    props: {
        form: {
            require: true,
            type: Object
        }
    },

    components: {
        'v-select': vSelect,
        ValidationProvider
    }

}


</script>
