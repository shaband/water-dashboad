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
                                    <h4 class="mb-4">{{ $t('Login') }}</h4>
                                    <p>{{ $t('Welcome back, please login to your account.') }}</p>
                                </div>
                                <ValidationObserver ref="form" v-slot="{ passes }">
                                    <form @submit.prevent="passes(Login)">
                                        <div>
                                            <ValidationProvider vid="email" name="email" v-slot="{ errors }">
                                                <vs-input icon-no-border icon="icon icon-user"
                                                          icon-pack="feather"
                                                          :label-placeholder="$t('Email')"
                                                          :danger="errors.length>0"
                                                          :danger-text="errors[0]"
                                                          v-model="credentials.email"
                                                          class="w-full"/>

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
                                            <div class="flex flex-wrap justify-between my-5">
                                                <vs-checkbox v-model="credentials.remember" class="mb-3">
                                                    {{ $t('Remember Me') }}
                                                </vs-checkbox>
                                                <router-link to="">{{ $t('Forgot Password?') }}</router-link>
                                            </div>
                                            <vs-button button="submit" class="float-right mb-5 ">{{ $t('Login') }}
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

export default {
    // mixins: [firebase],
    mounted () {
        this.$store.dispatch('auth/getToken')
    },
    components: {
        ValidationObserver,
        ValidationProvider
    },

    data () {
        return {
            credentials: {}
        }
    },
    methods: {
        Login () {
            this.$store.dispatch('auth/loginAttempt', this)

        }
    }
}

</script>
