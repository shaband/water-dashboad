<template>
    <vx-card :title="$t('promocodes')">
        <template #actions>
            <div class="">
                <vs-button v-if="$can('Create Promocode')" :to="{name:'admin.promocodes.create'}"
                           icon="add"></vs-button>
            </div>

        </template>
        <vs-table
            :sst="true"
            hover-flat
            striped
            v-model="selected"
            :data="promocodes"
        >
            <template slot="thead">
                <vs-th sort-key="#">#</vs-th>
                <vs-th sort-key="#">{{ $t('code') }}</vs-th>
                <vs-th sort-key="name_ar">{{ $t('times') }}</vs-th>
                <vs-th sort-key="name_en">{{ $t('percent') }}</vs-th>
                <vs-th sort-key="name_en">{{ $t('from') }}</vs-th>
                <vs-th sort-key="name_en">{{ $t('to') }}</vs-th>
                <vs-th>{{ $t('Action') }}</vs-th>
            </template>

            <template slot-scope="{data}" class="mb-1">
                <vs-tr :data="tr" :key="tr.id" v-for="(tr, indextr,i) in data" :ref="`item-${tr.id}`">
                    <vs-td :data="indextr">
                    </vs-td>
                    <vs-td :data="tr.code" class="border-2">
                        {{ tr.code }}
                    </vs-td>
                    <vs-td :data="tr.times" class="border-2">
                        {{ tr.times }}
                    </vs-td>
                    <vs-td :data="tr.percent" class="border-2">
                        {{ tr.percent }}
                    </vs-td>
                    <vs-td :data="tr.from_date" class="border-2">
                        {{ tr.from_date }}
                    </vs-td>
                    <vs-td :data="tr.to_date" class="border-2">
                        {{ tr.to_date }}
                    </vs-td>

                    <vs-td :data="tr.id">
                        <div class="flex">
                            <vs-button v-if="$can('Edit Promocode')"
                                       :to="{ name: 'admin.promocodes.edit', params:{id:tr.id} }" flat icon="edit"
                                       class="mx-1">
                            </vs-button>
                            <vs-button v-if="$can('Delete Promocode')" color="danger" type="filled" icon="delete"
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
import promocode from '@request/promocodes/promocode'

export default {
    mounted () {
        this.getPromocodes(this.meta.current_page)
    },
    data: () => ({
        selected: {},
        promocodes: [],
        meta: {
            last_page: 1,
            current_page: 1
        },
        DeletePopupActive: false
    }),
    methods: {
        getPromocodes (page = 1) {
            promocode.all(page).then(({data: {data, links, meta}}) => {
                this.promocodes = data
                this.meta = meta
            })
        },
        async deleteItem () {
            promocode.delete(this.selected.id).then((data) => {
                let deleted_index = this.promocodes.findIndex(promocode => promocode.id === this.selected.id)
                this.promocodes.splice(deleted_index, 1)
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
                text: `${this.$t('Are You Sure You Want Delete')} ${this.selected.code}`,
                accept: this.deleteItem
            })
        }
    },
    watch: {
        'meta.current_page': function (val, old) {
            if (val !== old) {
                this.getPromocodes(val)
            }
        }
    }
}
</script>
