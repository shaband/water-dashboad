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

                <ValidationProvider vid="description_en" name="description_en" v-slot="{ errors }">
                    <vs-input class="w-full" name="description_en" v-model="form.description_en"
                              :label=" $t('Description In English')"
                              :danger="errors.length>0"
                              :danger-text="errors[0]"
                    />
                </ValidationProvider>
            </div>
        </div>
        <div class="vx-row mb-2">
            <div class="vx-col w-full">

                <ValidationProvider vid="description_ar" description="description_ar" v-slot="{ errors }">
                    <vs-input class="w-full" description="description_ar" v-model="form.description_ar"
                              :label=" $t('Description In Arabic')"
                              :danger="errors.length>0"
                              :danger-text="errors[0]"
                    />
                </ValidationProvider>
            </div>
        </div>


        <div class="vx-row mb-2">
            <div class="vx-col w-full">

                <ValidationProvider vid="category_id" name="category_id" v-slot="{ errors }">
                    <h6>{{ $t('Category') }}</h6>

                    <v-select label="name_ar" v-model="form.category_id" :options="categories" dir="rtl"
                              :reduce="category => category.id"/>
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
                <ValidationProvider vid="provider_id" name="provider_id" v-slot="{ errors }">
                    <h6>{{ $t('provider') }}</h6>

                    <v-select label="name_ar" v-model="form.provider_id" :options="providers" dir="rtl"
                              :reduce="provider => provider.id"/>
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

                <ValidationProvider vid="is_charity" name="is_charity" v-slot="{ errors }">
                    <h6>{{ $t('Is Charity') }}</h6>

                    <v-select v-model="form.is_charity"
                              :reduce="type => type.id"
                              :options="[
                        {
                            id:0,
                            label:$t('No')
                            }
                        ,{
                            id:1,
                            label:$t('Yes')
                            }
                            ]" dir="rtl"/>
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

                <ValidationProvider vid="mark_id" name="mark_id" v-slot="{ errors }">
                    <h6>{{ $t('Mark') }}</h6>

                    <v-select label="name_ar" v-model="form.mark_id" :options="marks" dir="rtl"
                              :reduce="mark => mark.id"/>
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
                <file-uploader :form="form" :text="$t('Upload Image')"/>
            </div>
        </div>

    </div>


</template>
<script>

import 'vue-multiselect/dist/vue-multiselect.min.css'
import {ValidationProvider} from 'vee-validate'
import category from '@request/categories/category'
import mark from '@request/marks/mark'
import vSelect from 'vue-select'
import FileUploader from '@component/curd/uploader'
import provider from '@request/providers/provider'

export default {
    async mounted () {
        this.getCategories()
        this.getMarks()
        this.getProvider()
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
            marks: [],
            categories: [],
            providers: []
        }
    },
    methods: {
        getCategories () {
            category.every().then(({data: {data}}) => {
                this.categories = data
            })
        },
        getMarks () {
            mark.every().then(({data: {data}}) => {
                this.marks = data
            })
        },
        getProvider () {
            provider.every().then(({data: {data}}) => {
                this.providers = data
            })
        }
    }
}


</script>
