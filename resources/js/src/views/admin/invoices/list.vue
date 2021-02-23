<template>
    <vx-card :title="$t('invoices')">
        <!--        <template #actions>-->
        <!--            <div class="">-->
        <!--                <vs-button v-if="$can('Create Invoice')" :to="{name:'admin.invoices.create'}" icon="add"></vs-button>-->
        <!--            </div>-->

        <!--        </template>-->
        <vs-table
            :sst="true"
            hover-flat
            striped
            v-model="selected"
            :data="invoices"
        >
            <template slot="thead">
                <vs-th sort-key="#">#</vs-th>
                <vs-th sort-key="code">{{ $t('code') }}</vs-th>
                <vs-th sort-key="client_name">{{ $t('Client Name') }}</vs-th>
                <vs-th sort-key="phone">{{ $t('Phone') }}</vs-th>
                <vs-th sort-key="delivery_name">{{ $t('Delivery Name') }}</vs-th>
                <vs-th sort-key="agent">{{ $t('Agent Name') }}</vs-th>
                <vs-th sort-key="notes">{{ $t('Notes') }}</vs-th>
                <vs-th sort-key="price">{{ $t('price') }}</vs-th>
                <vs-th >{{ $t('Action') }}</vs-th>
            </template>

            <template slot-scope="{data}" class="mb-1">
                <vs-tr :data="tr" :key="tr.id" v-for="(tr, indextr,i) in data" :ref="`item-${tr.id}`">
                    <vs-td :data="indextr">
                    </vs-td>
                    <vs-td :data="data[indextr].code" class="border-l-2">
                        {{ tr.code }}
                    </vs-td>
                    <vs-td :data="data[indextr].user.name" class="border-l-2">
                        {{ tr | get('user.name',null) }}
                    </vs-td>
                    <vs-td :data="data[indextr].user.phone" class="border-l-2">
                        {{ tr | get('client.phone',null) }}
                    </vs-td>
                    <vs-td :data="data[indextr].delivery.name" class="border-l-2">
                        {{ tr | get('delivery[name]',null) }}
                    </vs-td>
                    <vs-td :data="data[indextr].agent.name" class="border-l-2">
                        {{ tr | get('agent[name]',null) }}
                    </vs-td>
                    <vs-td :data="data[indextr].notes" class="border-l-2">
                        {{ tr.notes }}
                    </vs-td>
                    <vs-td :data="data[indextr].price" class="border-l-2">
                        {{ tr.price }}
                    </vs-td>

                    <vs-td :data="tr.id">
                        <div class="flex">
                            <vs-button
                                       :to="{ name: 'admin.invoices.show', params:{id:tr.id} }" flat icon="edit"
                                       class="mx-1">
                            </vs-button>
                            <vs-button v-if="$can('Delete Invoice')" color="danger" type="filled" icon="delete"
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
import invoice from '@request/invoices/invoice'

export default {
    mounted () {
        this.getInvoices(this.meta.current_page)
    },
    data: () => ({
        selected: {},
        invoices: [],
        meta: {
            last_page: 1,
            current_page: 1
        },
        DeletePopupActive: false
    }),
    methods: {
        getInvoices (page = 1) {
            invoice.all(page,{status:this.$route.params.status}).then(({
                data: {
                    data,
                    links,
                    meta
                }
            }) => {
                this.invoices = data
                this.meta = meta
            })
        },
        async deleteItem () {
            invoice.delete(this.selected.id).then((data) => {
                let deleted_index = this.invoices.findIndex(invoice => invoice.id === this.selected.id)
                this.invoices.splice(deleted_index, 1)
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
            invoice.toggleBlock(tr.id).then(({data}) => {
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
                this.getInvoices(val)
            }
        }
    }
}
</script>
