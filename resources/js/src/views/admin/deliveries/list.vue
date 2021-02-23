<template>
    <vx-card :title="$t('deliveries')">
        <template #actions>
            <div class="">
                <vs-button v-if="$can('Create Delivery')" :to="{name:'admin.deliveries.create'}" icon="add"></vs-button>
            </div>

        </template>
        <vs-table
            :sst="true"
            hover-flat
            striped
            v-model="selected"
            :data="deliveries"
        >
            <template slot="thead">
                <vs-th sort-key="#">#</vs-th>
                <vs-th sort-key="#">{{ $t('image') }}</vs-th>
                <vs-th sort-key="name">{{ $t('Name') }}</vs-th>
                <vs-th sort-key="phone">{{ $t('Phone') }}</vs-th>
                <vs-th sort-key="email">{{ $t('Email') }}</vs-th>
                <vs-th sort-key="name_en">{{ $t('Activation') }}</vs-th>
                <vs-th>{{ $t('Action') }}</vs-th>
            </template>

            <template slot-scope="{data}" class="mb-1">
                <vs-tr :data="tr" :key="tr.id" v-for="(tr, indextr,i) in data" :ref="`item-${tr.id}`">

                    <vs-td :data="indextr">
                    {{indextr + 1}}
                    </vs-td>
                    <vs-td :data="indextr">
                        <img :src="tr.image" width="200" height="100"/>
                    </vs-td>
                    <vs-td :data="data[indextr].name" class="border-l-2">
                        {{ tr.name }}
                    </vs-td>
                    <vs-td :data="data[indextr].phone" class="border-l-2">
                        {{ tr.phone }}
                    </vs-td>
                    <vs-td :data="data[indextr].email" class="border-l-2">
                        {{ tr.email }}
                    </vs-td>


                    <vs-td :data="! !!tr.blocked_at" class="border-l-2">
                        <vs-switch @input="toggle_activation(tr)" :value="! !!tr.blocked_at"/>
                    </vs-td>
                    <vs-td :data="tr.id">
                        <div class="flex">
                            <vs-button v-if="$can('Edit Delivery')"
                                       :to="{ name: 'admin.deliveries.edit', params:{id:tr.id} }" flat icon="edit"
                                       class="mx-1">
                            </vs-button>
                            <vs-button v-if="$can('Delete Delivery')" color="danger" type="filled" icon="delete"
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
import delivery from '@request/deliveries/delivery'
import category from '@request/categories/category'

export default {
    mounted () {
        this.getDeliveries(this.meta.current_page)
    },
    data: () => ({
        selected: {},
        deliveries: [],
        meta: {
            last_page: 1,
            current_page: 1
        },
        DeletePopupActive: false
    }),
    methods: {
        getDeliveries (page = 1) {
            delivery.all(page).then(({data: {data, links, meta}}) => {
                this.deliveries = data
                this.meta = meta
            })
        },
        async deleteItem () {
            delivery.delete(this.selected.id).then((data) => {
                let deleted_index = this.deliveries.findIndex(delivery => delivery.id === this.selected.id)
                this.deliveries.splice(deleted_index, 1)
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
                this.getDeliveries(val)
            }
        }
    }
}
</script>
