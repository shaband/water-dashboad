<template>
    <div>
        <!--
         'name',
                'password',
                'email',
                'phone',
                'image',
                'car_number',
                'car_paper_image',
                'car_type_id',
                'city_id',
                'lat',
                'lng',
                'blocked_at',
                'status',
        -->
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

                <ValidationProvider vid="password_confirmation" name="password_confirmation"
                                    v-slot="{ errors }">
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

                <ValidationProvider vid="car_number" name="car_number" v-slot="{ errors }">
                    <vs-input class="w-full" name="car_number" v-model="form.car_number"
                              :label=" $t('Car Number')"
                              :danger="errors.length>0"
                              :danger-text="errors[0]"
                    />
                </ValidationProvider>
            </div>
        </div>

        <div class="vx-row mb-2">
            <div class="vx-col w-full">

                <ValidationProvider vid="car_type_id" name="car_type_id" v-slot="{ errors }">
                    <h6>{{ $t('Car Type') }}</h6>

                    <v-select v-model="form.car_type_id"
                              label="name_ar"
                              :reduce="carType => carType.id"
                              :options="carTypes" dir="rtl"/>
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

                <ValidationProvider vid="city_id" name="city_id" v-slot="{ errors }">
                    <h6>{{ $t('City') }}</h6>

                    <v-select label="name_ar" v-model="form.city_id" :options="cities" dir="rtl"
                              :reduce="city => city.id"/>
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

                <ValidationProvider vid="status" name="status" v-slot="{ errors }">
                    <h6>{{ $t('Status') }}</h6>
                    <v-select v-model="form.status"
                              :reduce="status => status.value"
                              :options="delivery_statuses" dir="rtl"/>
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
            <div class="vx-col w-1/2">
                <file-uploader :form="form" :text="$t('Upload Profile Picture')" input="image"/>
            </div>
            <div class="vx-col w-1/2">
                <file-uploader :form="form" :text="$t('Car Paper')" input="car_paper_image"/>
            </div>
        </div>
    </div>


</template>
<script>

import {ValidationProvider} from 'vee-validate'
import carType from '@request/car_types/carType'
import city from '@request/cities/city'
import vSelect from 'vue-select'
import FileUploader from '@component/curd/uploader'

export default {
    async mounted () {
        this.getCarTypes()
        this.getCities()
    },
    props: {
        form: {
            require: true,
            type: Object
        }
    },

    components: {
        FileUploader,
        ValidationProvider,
        'v-select': vSelect

    },

    data () {
        return {
            cities: [],
            carTypes: [],
            delivery_statuses: [
                {
                    value: 'pending',
                    label: this.$t('Pending')
                },
                {
                    value: 'accepted',
                    label: this.$t('Accepted')
                },
                {
                    value: 'refused',
                    label: this.$t('Refused')
                }
            ]
        }
    },
    methods: {
        getCities () {
            city.every().then(({data: {data}}) => {
                this.cities = data
            })
        },
        getCarTypes () {
            carType.every().then(({data: {data}}) => {
                this.carTypes = data
            })
        }
    }
}


</script>
