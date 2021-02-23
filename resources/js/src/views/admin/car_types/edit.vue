<template>
    <vx-card :title="$t('Edit Car Type')">
        <ValidationObserver ref="form" v-slot="{ passes }">

            <form @submit.prevent="passes(update)">

                <car-type-form ref="from" :form="form"/>
                <div class="vx-row">
                    <div class="vx-col w-full">
                        <vs-button button="submit" class="mr-3 mb-2">{{ $t('Save') }}</vs-button>

                    </div>
                </div>
            </form>
        </ValidationObserver>
    </vx-card>


</template>
<script>

import form from './_form'
import carType from '@request/car_types/carType'
import {ValidationObserver} from 'vee-validate'

export default {
    components: {
        'car-type-form': form,
        ValidationObserver
    },
    mounted () {
        carType.show(this.$route.params.id).then(({data}) => {
            this.form = data
        })
    },

    data () {
        return {
            form: {}
        }
    },

    methods: {
        async update () {
            carType.update(this.$route.params.id,this.form).then(({data}) => {
                this.$vs.notify({
                    title: this.$t('Saved Successfully')
                    // color: 'danger'
                })
                this.$router.push({
                    name: 'admin.car-types.index'
                })
            }).catch((response) => {

                    if (response.status === 422) {
                        this.$vs.notify({
                            title: response.data.message,
                            color: 'danger'
                        })
                        this.$refs.form.setErrors(response.data.errors)
                    }
                }
            )
        }

    }
}


</script>
