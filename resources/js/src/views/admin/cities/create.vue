<template>
    <vx-card :title="$t('create City')">
        <ValidationObserver ref="form" v-slot="{ passes }">

            <form @submit.prevent="passes(store)">

                <city-form ref="from" :form="form"/>
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
import city from '@request/cities/city'
import {ValidationObserver} from 'vee-validate'

export default {
    components: {
        'city-form': form,
        ValidationObserver
    },

    data () {
        return {
            form: {

            }
        }
    },

    methods: {
        async store () {
            city.store(this.form).then(({data}) => {
                this.$vs.notify({
                    title: this.$t('Saved Successfully')
                    // color: 'danger'
                })
                this.$router.push({
                    name: 'admin.cities.index'
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
