<template>
    <div class="h-screen flex w-full bg-img vx-row no-gutter items-center justify-center" id="page-login">
        <div class="vx-col sm:w-1/2 md:w-1/2 lg:w-3/4 xl:w-3/5 sm:m-0 m-4">
            <vx-card>
                <div slot="no-body" class="full-page-bg-color">

                    <div class="vx-row no-gutter justify-center items-center">

                        <div class="vx-col hidden lg:block lg:w-1/2">
                            <img src="@assets/images/pages/login.png" alt="login" class="mx-auto">
                        </div>

                        <div class="vx-col sm:w-full md:w-full lg:w-1/2 d-theme-dark-bg">
                            <div class="p-8 login-tabs-container">

                                <div class="vx-card__title mb-4">
                                    <h4 class="mb-4">{{ $t('Reset Password') }}</h4>

                                </div>
                                <ValidationObserver ref="form" v-slot="{ passes }">
                                    <form @submit.prevent="passes(resetPassword)">
                                        <input type="hidden" v-model="credentials.token"/>
                                        <div>
                                            <ValidationProvider vid="email" name="email" v-slot="{ errors }">
                                                <vs-input icon-no-border icon="icon icon-user"
                                                          icon-pack="feather"
                                                          :label-placeholder="$t('Email')"
                                                          :danger="errors.length>0"
                                                          :danger-text="errors[0]"
                                                          v-model="credentials.email"
                                                          class="w-full"
                                                />

                                            </ValidationProvider>


                                            <ValidationProvider vid="password" name="password" v-slot="{ errors }">

                                                <vs-input type="password" icon-no-border
                                                          icon="icon icon-lock"
                                                          icon-pack="feather" :label-placeholder="$t('Password')"
                                                          v-model="credentials.password"
                                                          :danger="errors.length>0"
                                                          :danger-text="errors[0]"
                                                          class="w-full mt-6"/>

                                            </ValidationProvider>


                                            <ValidationProvider vid="password_confiramtion" name="password_confirmation"
                                                                v-slot="{ errors }">

                                                <vs-input type="password" icon-no-border
                                                          icon="icon icon-lock"
                                                          icon-pack="feather"
                                                          :label-placeholder="$t('Password Confirmation')"
                                                          v-model="credentials.password_confirmation"
                                                          :danger="errors.length>0"
                                                          :danger-text="errors[0]"
                                                          class="w-full mt-6"/>

                                            </ValidationProvider>
                                            <vs-button button="submit" class="float-right my-5 ">
                                                {{ $t('Reset Password') }}
                                            </vs-button>


                                        </div>
                                    </form>
                                </ValidationObserver>
                            </div>
                        </div>
                    </div>
                </div>
            </vx-card>
        </div>
    </div>
</template>

<script>
import {ValidationObserver, ValidationProvider} from 'vee-validate'
import auth from '@request/auth/index'

export default {

    components: {
        ValidationObserver,
        ValidationProvider
    },

    created () {

        let urlParams = new URLSearchParams(window.location.search)

        this.credentials['token'] = urlParams.get('token')
        this.credentials['email'] = urlParams.get('email')
    },
    data () {
        return {
            credentials: {}
        }
    },
    methods: {
        resetPassword () {
            auth.resetPassword(this.credentials).then(() => {
                this.$vs.notify({
                    title: this.$t("Password Reset Successfully ."),
                    color: 'success'
                });
                this.$router.push({name: 'admin.login'})
            })

        }
    }
}

</script>
