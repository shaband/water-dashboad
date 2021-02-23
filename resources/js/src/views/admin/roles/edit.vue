<template>
    <vx-card :title="$t('Edit roles')">
        <ValidationObserver ref="form" v-slot="{ passes }">

            <form @submit.prevent="passes(update)">

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
    mounted () {
        this.getRole()
    },
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
        async getRole () {
            role.show(this.$route.params.id).then(({data}) => {
                this.form = data
            })
        },
        async update () {
            role.update(this.$route.params.id, this.form).then(({data}) => {
                this.$vs.notify({
                    title: this.$t('Updated Successfully')
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
