<template>
    <vx-card :title="$t('products')">
        <template #actions>
            <div class="">
                <vs-button v-if="$can('Create Product')" :to="{name:'admin.products.create'}" icon="add"></vs-button>
            </div>

        </template>
        <vs-table
            :sst="true"
            hover-flat
            striped
            v-model="selected"
            :data="products"
        >
            <template slot="thead">
                <vs-th sort-key="#">#</vs-th>
                <vs-th sort-key="#">{{ $t('image') }}</vs-th>
                <vs-th sort-key="name_ar">{{ $t('Name In Arabic') }}</vs-th>
                <vs-th sort-key="name_en">{{ $t('Name In English') }}</vs-th>
                <vs-th sort-key="mark">{{ $t('Mark') }}</vs-th>
                <vs-th sort-key="category">{{ $t('Category') }}</vs-th>
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
                    <vs-td :data="data[indextr].mark.name_ar" class="border-l-2">
                        {{ tr.mark.name_ar }}
                    </vs-td>
                    <vs-td :data="data[indextr].category.name_ar" class="border-l-2">
                        {{ tr.category.name_ar }}
                    </vs-td>

                    <vs-td :data="tr.id">
                        <div class="flex">
                            <vs-button v-if="$can('Edit Product')"
                                       :to="{ name: 'admin.products.edit', params:{id:tr.id} }" flat icon="edit"
                                       class="mx-1">
                            </vs-button>
                            <vs-button v-if="$can('Delete Product')" color="danger" type="filled" icon="delete"
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
import product from '@request/products/product'

export default {
    mounted () {
        this.getProducts(this.meta.current_page)
    },
    data: () => ({
        selected: {},
        products: [],
        meta: {
            last_page: 1,
            current_page: 1
        },
        DeletePopupActive: false
    }),
    methods: {
        getProducts (page = 1) {
            product.all(page).then(({data: {data, links, meta}}) => {
                this.products = data
                this.meta = meta
            })
        },
        async deleteItem () {
            product.delete(this.selected.id).then((data) => {
                let deleted_index = this.products.findIndex(product => product.id === this.selected.id)
                this.products.splice(deleted_index, 1)
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
        }
    },
    watch: {
        'meta.current_page': function (val, old) {
            if (val !== old) {
                this.getProducts(val)
            }
        }
    }
}
</script>
