<template>
    <vx-card>


        <table class="min-w-full divide-y shadow-md">
            <thead class="bg-grey-light">
            <tr class="px-6 py-3 text-left text-xs font-medium  uppercase tracking-wider">
                <th class=" text-center w-1/2 font-bold">{{
                    $t('Name')
                    }}
                </th>
                <th class="text-center w-1/2 font-bold">{{
                    $t('Value')
                    }}
                </th>
            </tr>
            </thead>
            <tbody>
            <tr class="">
                <td class="p-2 text-center ">
                    {{ $t('Code') }}
                </td>
                <td class="p-2 text-center ">
                    {{ invoice |get('code') }}
                </td>
            </tr>
            <tr class="">
                <td class="p-2 text-center ">
                    {{ $t('Client Name') }}
                </td>
                <td class="p-2 text-center ">
                    {{ invoice |get('user.name') }}
                </td>
            </tr>
            <tr class="">
                <td class="p-2 text-center ">
                    {{ $t('Client Phone') }}
                </td>
                <td class="p-2 text-center ">
                    {{ invoice |get('user.phone') }}
                </td>
            </tr>
            <tr class="">
                <td class="p-2 text-center ">
                    {{ $t('Agent name') }}
                </td>
                <td class="p-2 text-center ">
                    {{ invoice |get('agent.name') }}
                </td>
            </tr>
            <tr class="">
                <td class="p-2 text-center ">
                    {{ $t('Delivery name') }}
                </td>
                <td class="p-2 text-center ">
                    {{ invoice|get('delivery.name') }}
                </td>
            </tr>
            <tr class="">
                <td class="p-2 text-center ">
                    {{ $t('Description') }}
                </td>
                <td class="p-2 text-center ">
                    {{ invoice|get('notes') }}
                </td>
            </tr>
            <tr class="">
                <td class="p-2 text-center ">
                    {{ $t('Delivering Date') }}
                </td>
                <td class="p-2 text-center ">
                    {{ invoice|get('delivering_date') }}
                </td>
            </tr>
            <tr class="">
                <td class="p-2 text-center ">
                    {{ $t('Payment Method') }}
                </td>
                <td class="p-2 text-center ">
                    {{ invoice|get('delivering_time') }}
                </td>
            </tr>
            <tr class="">
                <td class="p-2 text-center ">
                    {{ $t('Payment Method') }}
                </td>
                <td class="p-2 text-center ">
                    {{ invoice|get('payment_type') }}
                </td>
            </tr>
            <tr class="">
                <td class="p-2 text-center ">
                    {{ $t('Is Charity ') }}
                </td>
                <td class="p-2 text-center ">
                    {{ isCharity }}
                </td>
            </tr>
            <tr class="">
                <td class="p-2 text-center ">
                    {{ $t('Agent Accepted At ') }}
                </td>
                <td class="p-2 text-center ">
                    {{ invoice|get('agent_accepted_at') }}
                </td>
            </tr>
            <tr class="">
                <td class="p-2 text-center ">
                    {{ $t('Delivery Accepted At ') }}
                </td>
                <td class="p-2 text-center ">
                    {{ invoice|get('delivery_accepted_at') }}
                </td>
            </tr>
            <tr v-if="invoice.promocode_id">
                <td class="p-2 text-center ">
                    {{ $t('promocode') }}
                </td>
                <td class="p-2 text-center ">
                    {{ invoice|get('promocode.name') }}
                </td>
            </tr>


            <tr class="">
                <td class="p-2 text-center ">
                    {{ $t('Order Price') }}
                </td>
                <td class="p-2 text-center ">
                    {{ invoice|get('price') }}
                </td>
            </tr>
            <tr class="">
                <td class="p-2 text-center ">
                    {{ $t('Delivery Price') }}
                </td>
                <td class="p-2 text-center ">
                    {{ invoice|get('delivery_price') }}
                </td>
            </tr>
            <tr class="">
                <td class="p-2 text-center ">
                    {{ $t('Tax') }}
                </td>
                <td class="p-2 text-center ">
                    {{ invoice|get('tax') }}
                </td>
            </tr>
            <tr class="">
                <td class="p-2 text-center ">
                    {{ $t('Discount') }}
                </td>
                <td class="p-2 text-center ">
                    {{ invoice|get('discount') }}
                </td>
            </tr>
            <tr class="">
                <td class="p-2 text-center ">
                    {{ $t('Total Price') }}
                </td>
                <td class="p-2 text-center border-l-2">
                    {{ total_price }}
                </td>
            </tr>
            </tbody>
        </table>
        <hr>
        <vs-divider> {{ $t('Product') }}</vs-divider>
        <vs-table
            :sst="true"
            hover-flat
            striped
            :data="invoice.products||[]"
        >
            <template slot="thead">
                <vs-th sort-key="#">#</vs-th>
                <vs-th sort-key="code">{{ $t('product') }}</vs-th>
                <vs-th sort-key="client_name">{{ $t('quantity') }}</vs-th>
                <vs-th sort-key="phone">{{ $t('unit price') }}</vs-th>
                <vs-th sort-key="delivery_name">{{ $t('total price') }}</vs-th>

            </template>

            <template slot-scope="{data}" class="mb-1">
                <vs-tr :data="tr" :key="tr.id" v-for="(tr, indextr,i) in data" :ref="`item-${tr.id}`">
                    <vs-td :data="indextr">
                        {{ indextr + 1 }}
                    </vs-td>
                    <vs-td :data="data[indextr].code" class="border-l-2">
                        {{ tr|get('product_name',null) }}
                    </vs-td>
                    <vs-td class="border-l-2">
                        {{ tr | get('quantity',null) }}
                    </vs-td>
                    <vs-td class="border-l-2">
                        {{ tr | get('unit_price',null) }}
                    </vs-td>
                    <vs-td class="border-l-2">
                        {{ tr | get('total_price',null) }}
                    </vs-td>
                </vs-tr>
            </template>
        </vs-table>


    </vx-card>
</template>

<script>
import invoice from '@request/invoices/invoice'
import get from 'lodash/get'

export default {
    mounted () {
        this.getInvoice()
    },
    data: () => ({
        invoice: {}
    }),
    methods: {
        getInvoice () {
            invoice.show(this.$route.params.id).then(({data}) => {
                this.invoice = data
            })
        }
    },
    computed: {
        isCharity () {
            if (!!get(this.invoice, 'is_charity', 0)) {
                return this.$t('Yes')
            }
            return this.$t('No')
        },
        total_price () {
            return parseFloat(get(this.invoice, 'price', 0)) + parseFloat(get(this.invoice, 'delivery_price', 0)) + parseFloat(get(this.invoice, 'tax', 0)) -
                parseFloat(get(this.invoice, 'discount', 0))
        }
    }

}
</script>
