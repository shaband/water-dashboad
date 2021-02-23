<template>
    <vx-card :title="$t('categories')">
        <template #actions>
            <div class="">
                <vs-button v-if="$can('Create Category')" :to="{name:'admin.categories.create'}" icon="add"></vs-button>
            </div>

        </template>
        <vs-table
            :sst="true"
            hover-flat
            striped
            v-model="selected"
            :data="categories"
        >
            <template slot="thead">
                <vs-th sort-key="#">#</vs-th>
                <vs-th sort-key="#">{{ $t('image') }}</vs-th>
                <vs-th sort-key="name_ar">{{ $t('Name In Arabic') }}</vs-th>
                <vs-th sort-key="name_en">{{ $t('Name In English') }}</vs-th>
                <vs-th sort-key="name_en">{{ $t('Activation') }}</vs-th>
                <vs-th>{{ $t('Action') }}</vs-th>
            </template>

            <template slot-scope="{data}" class="mb-1">
                <vs-tr :data="tr" :key="tr.id" v-for="(tr, indextr,i) in data" :ref="`item-${tr.id}`">
                    <vs-td :data="indextr">
                    </vs-td>
                    <vs-td :data="indextr">
                        <img :src="tr.image" width="200" height="100"/>
                    </vs-td>
                    <vs-td :data="data[indextr].name_ar" class="border-l-2">
                        {{ tr.name_ar }}
                    </vs-td>
                    <vs-td :data="data[indextr].name_en" class="border-l-2">
                        {{ tr.name_en }}
                    </vs-td>
                    <vs-td :data="! !!tr.blocked_at" class="border-l-2">
                        <vs-switch @input="toggle_activation(tr)" :value="! !!tr.blocked_at"/>
                    </vs-td>

                    <vs-td :data="tr.id">
                        <div class="flex">
                            <vs-button v-if="$can('Edit Category')"
                                       :to="{ name: 'admin.categories.edit', params:{id:tr.id} }" flat icon="edit"
                                       class="mx-1">
                            </vs-button>
                            <vs-button v-if="$can('Delete Category')" color="danger" type="filled" icon="delete"
                                       @click="openDeleteConfirm(tr)">
                            </vs-button>
                        </div>
                    </vs-td>
                </vs-tr>
            </template>
        </vs-table>
        <vs-pagination :total="meta.last_page" v-model="meta.current_page"></vs-pagination>
    </vx-card>
</template>

<script>
import category from '@request/categories/category'

export default {
    mounted () {
        this.getCategories(this.meta.current_page)
    },
    data: () => ({
        selected: {},
        categories: [],
        meta: {
            last_page: 1,
            current_page: 1
        },
        DeletePopupActive: false
    }),


    methods: {
        getCategories (page = 1) {
            category.all(page).then(({data: {data, links, meta}}) => {
                this.categories = data
                this.meta = meta
            })
        },
        async deleteItem () {
            category.delete(this.selected.id).then((data) => {
                let deleted_index = this.categories.findIndex(category => category.id === this.selected.id)
                this.categories.splice(deleted_index, 1)
                this.$vs.notify({
                    title: this.$t('Deleted Successfully')

                })
            })
        },

        openDeleteConfirm (tr) {
            this.selected = tr
            this.$vs.dialog({
                type: 'confirm',
                color: 'danger',
                title: this.$t(`Confirm Delete`),
                text: `${this.$t('Are You Sure You Want Delete')} ${this.selected.name_ar}`,
                accept: this.deleteItem
            })
        },
        async toggle_activation (tr) {
            category.toggleBlock(tr.id).then(({data}) => {
                tr.blocked_at = data.blocked_at
                this.$vs.notify({
                    title: this.$t('Updated Successfully')
                    // color: 'danger'
                })
            }).catch(({response}) => {
                this.$vs.notify({
                    title: response.message,
                    color: 'danger'
                })
            })
        }
    },
    watch: {
        'meta.current_page': function (val, old) {
            if (val !== old) {
                this.getCategories(val)
            }
        }
    }
}
</script>
