<template>
    <vx-card :title="$t('addresses')">
        <template #actions>
            <div class="">
                <vs-button v-if="$can('Create Address')" :to="{name:'admin.addresses.create'}" icon="add"></vs-button>
            </div>

        </template>
        <vs-table
            :sst="true"
            hover-flat
            striped
            v-model="selected"
            :data="addresses"
        >
            <template slot="thead">
                <vs-th sort-key="#">#</vs-th>
                <vs-th sort-key="name_ar">{{ $t('Name In Arabic') }}</vs-th>
                <vs-th sort-key="name_en">{{ $t('Name In English') }}</vs-th>
                <vs-th sort-key="address">{{ $t('Address') }}</vs-th>
                <vs-th>{{ $t('Action') }}</vs-th>
            </template>

            <template slot-scope="{data}" class="mb-1">
                <vs-tr :data="tr" :key="tr.id" v-for="(tr, indextr,i) in data" :ref="`item-${tr.id}`">
                    <vs-td :data="indextr">
                    </vs-td>
                    <vs-td :data="tr.name_ar" class="border-l-2">
                        {{ tr.name_ar }}
                    </vs-td>
                    <vs-td :data="tr.name_en" class="border-l-2">
                        {{ tr.name_en }}
                    </vs-td>
                    <vs-td :data="tr.address" class="border-l-2">
                        {{ tr.address }}
                    </vs-td>
                    <vs-td :data="tr.id">
                        <div class="flex">
                            <vs-button v-if="$can('Edit Address')"
                                       :to="{ name: 'admin.addresses.edit', params:{id:tr.id} }" flat icon="edit"
                                       class="mx-1">
                            </vs-button>
                            <vs-button v-if="$can('Delete Address')" color="danger" type="filled" icon="delete"
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
import address from '@request/addresses/address'

export default {
    mounted () {
        this.getAddresses(this.meta.current_page)
    },
    data: () => ({
        selected: {},
        addresses: [],
        meta: {
            last_page: 1,
            current_page: 1
        },
        DeletePopupActive: false
    }),
    methods: {
        getAddresses (page = 1) {
            address.all(page).then(({data: {data, links, meta}}) => {
                this.addresses = data
                this.meta = meta
            })
        },
        async deleteItem () {
            address.delete(this.selected.id).then((data) => {
                let deleted_index = this.addresses.findIndex(address => address.id === this.selected.id)
                this.addresses.splice(deleted_index, 1)
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
                this.getAddresses(val)
            }
        }
    }
}
</script>
