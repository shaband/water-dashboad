<template>
    <vx-card :title="$t('Edit User')">
        <ValidationObserver ref="form" v-slot="{ passes }">

            <form @submit.prevent="passes(update)">

                <user-form ref="from" :form="form"/>
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
import user from '@request/users/user'
import {ValidationObserver} from 'vee-validate'

export default {
    components: {
        'user-form': form,
        ValidationObserver
    },
    mounted () {
        user.show(this.$route.params.id).then(({data}) => {
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
            user.update(this.$route.params.id,this.form).then(({data}) => {
                this.$vs.notify({
                    title: this.$t('Saved Successfully')
                })
                this.$router.push({
                    name: 'admin.users.index'
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
