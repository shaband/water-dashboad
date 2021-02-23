<template>
    <vx-card :title="$t('roles')">
        <ValidationObserver ref="form" v-slot="{ passes }">

            <form @submit.prevent="passes(store)">

                <role-form ref="from" :form="form"/>
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
import role from '@request/roles/role'
import {ValidationObserver} from 'vee-validate'

export default {
    components: {
        'role-form': form,
        ValidationObserver
    },

    data () {
        return {
            form: {
                label_ar: null,
                label_en: null,
                permissions: [],
                guard_name: 'admin'
            }
        }
    },

    methods: {
        async store () {
            role.store(this.form).then(({data}) => {
                this.$vs.notify({
                    title: this.$t('Saved Successfully')
                    // color: 'danger'
                })
                this.$router.push({
                    name: 'admin.roles.index'
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
