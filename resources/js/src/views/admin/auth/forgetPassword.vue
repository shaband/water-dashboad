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
                                    <h4 class="mb-4">{{ $t('Forget Password') }}</h4>
                                    <p v-if="forget_response==null">{{
                                            $t('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.')
                                        }}</p>
                                </div>
                                <ValidationObserver ref="form" v-slot="{ passes }" v-if="forget_response==null">
                                    <form @submit.prevent="passes(forgetPassword)">
                                        <div>
                                            <ValidationProvider vid="email" name="email" v-slot="{ errors }">
                                                <vs-input icon-no-border icon="icon icon-user"
                                                          icon-pack="feather"
                                                          :label-placeholder="$t('Email')"
                                                          :danger="errors.length>0"
                                                          :danger-text="errors[0]"
                                                          v-model="email"
                                                          class="w-full"/>

                                            </ValidationProvider>

                                            <vs-button button="submit" class="float-right my-5 ">
                                                {{ $t('Email Password Reset Link') }}
                                            </vs-button>


                                        </div>
                                    </form>
                                </ValidationObserver>
                          <div v-else>
                              <p>
                                  {{forget_response}}
                              </p>
                          </div>
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

    name: 'foreget-password',
    components: {
        ValidationObserver,
        ValidationProvider
    },

    data () {
        return {
            email: null,
            forget_response: null

        }
    },
    methods: {
        forgetPassword () {
            auth.forgetPassword(this.email).then(({data}) => {
                this.forget_response = data.status
            })

        }
    }
}

</script>
