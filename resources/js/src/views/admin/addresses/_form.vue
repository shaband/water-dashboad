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

                <ValidationProvider vid="address" name="address" v-slot="{ errors }">
                    <vs-input class="w-full" name="address" v-model="form.address" :label=" $t('Address')"
                              :danger="errors.length>0"
                              :danger-text="errors[0]"
                    />
                </ValidationProvider>
            </div>
        </div>

        <google-map :form="form" @markerDragged="positionChanged" :center="center" :markers="markers"/>
    </div>


</template>
<script>

import {ValidationProvider} from 'vee-validate'
import googleMap from '@component/gmap/gmap'
import get from 'lodash/get'

export default {

    props: {
        form: {
            require: true,
            type: Object
        }
    },

    components: {
        ValidationProvider,
        googleMap
    },

    computed: {
        center () {
            return {

                lat: get(this.form, 'lat', 30.974528),
                lng: get(this.form, 'lng', 31.191797)
            }
        },
        markers () {
            return [{
                position: {
                    lat: get(this.form, 'lat', 30.974528),
                    lng: get(this.form, 'lng', 31.191797)

                }
            }]
        }
    },
    methods: {
        positionChanged (data) {
            let latLang = data.latLng

            this.$set(this.form, 'lat', latLang.lat())
            this.$set(this.form, 'lng', latLang.lng())
        }
    }
}


</script>
