<template>
    <div>
        <div class="vx-row mb-2">
            <div class="vx-col w-full">
                <!--  'code',
                        'from_date',
                        'to_date',
                        'times',
                        'percent',-->
                <ValidationProvider vid="code" name="code" v-slot="{ errors }">
                    <vs-input class="w-full" name="code" v-model="form.code" :label=" $t('Promocode')"
                              :danger="errors.length>0"
                              :danger-text="errors[0]"
                    />
                </ValidationProvider>
            </div>
        </div>
        <div class="vx-row mb-2">
            <div class="vx-col w-full">

                <ValidationProvider vid="times" name="times" v-slot="{ errors }">
                    <vs-input class="w-full" name="times" v-model="form.times" :label=" $t('Times')"
                              :danger="errors.length>0"
                              :danger-text="errors[0]"
                              type="number"
                    />
                </ValidationProvider>
            </div>
        </div>
        <div class="vx-row mb-2">
            <div class="vx-col w-full">

                <ValidationProvider vid="percent" name="percent" v-slot="{ errors }">
                    <vs-input class="w-full" name="percent" v-model="form.percent" :label=" $t('Percent')"
                              :danger="errors.length>0"
                              :danger-text="errors[0]"
                              type="number"
                    />
                </ValidationProvider>
            </div>
        </div>

        <div class="vx-row mb-2">
            <div class="vx-col w-1/2">

                <ValidationProvider vid="from_date" name="from_date" v-slot="{ errors }">
                     {{$t("From date")}}

                    <flat-pickr
                        v-model="form.from_date"
                        :config="config"
                        class="vs-inputx vs-input--input normal"
                        style="border: 1px solid rgba(0, 0, 0, 0.2);"
                        placeholder="Select date"
                        name="from_date">
                    </flat-pickr>
                    <div
                        class="con-text-validation span-text-validation-danger vs-input--text-validation-span v-enter-to"
                        style="height: 19px;"><span class="span-text-validation">
                    {{ errors[0] }}
                    </span>
                    </div>
                </ValidationProvider>
            </div>
            <div class="vx-col w-1/2">

                <ValidationProvider vid="to_date" name="to_date" v-slot="{ errors }">
                   {{$t("To date")}}
                    <flat-pickr
                        v-model="form.to_date"
                        :config="config"
                        class="vs-inputx vs-input--input normal"
                        style="border: 1px solid rgba(0, 0, 0, 0.2);"
                        placeholder="Select date"
                        name="to_date">
                    </flat-pickr>
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

import {ValidationProvider} from 'vee-validate'
import flatPickr from 'vue-flatpickr-component'
import 'flatpickr/dist/flatpickr.css'
import {Arabic} from 'flatpickr/dist/l10n/ar'

export default {
    props: {
        form: {
            require: true,
            type: Object
        }
    },

    data () {
        return {
            config: {
                wrap: true, // set wrap to true only when using 'input-group'
                altFormat: 'Y-m-d',
                altInput: true,
                dateFormat: 'Y-m-d',
                locale: Arabic // locale for this instance only
            }
        }
    },
    components: {
        ValidationProvider,
        flatPickr
    }

}


</script>
