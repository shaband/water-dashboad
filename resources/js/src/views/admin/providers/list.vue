<template>
    <vx-card :title="$t('providers')">
        <template #actions>
            <div class="">
                <vs-button v-if="$can('Create Provider')" :to="{name:'admin.providers.create'}" icon="add"></vs-button>
            </div>

        </template>
        <vs-table
            :sst="true"
            hover-flat
            striped
            v-model="selected"
            :data="providers"
        >
            <template slot="thead">
                <vs-th sort-key="#">#</vs-th>
                <vs-th sort-key="name_ar">{{ $t('Name In Arabic') }}</vs-th>
                <vs-th sort-key="name_en">{{ $t('Name In English') }}</vs-th>
                <vs-th>{{ $t('Action') }}</vs-th>
            </template>

            <template slot-scope="{data}" class="mb-1">
                <vs-tr :data="tr" :key="tr.id" v-for="(tr, indextr,i) in data" :ref="`item-${tr.id}`">

                    <vs-td :data="indextr + 1" class="border-l-2">
                        {{ indextr + 1 }}
                    </vs-td>
                    <vs-td :data="data[indextr].name" class="border-l-2">
                        {{ tr.name_ar }}
                    </vs-td>
                    <vs-td :data="data[indextr].name" class="border-l-2">
                        {{ tr.name_en }}
                    </vs-td>

                    <vs-td :data="tr.id">
                        <div class="flex">
                            <vs-button v-if="$can('Edit Provider')" :to="{ name: 'admin.providers.edit', params:{id:tr.id} }" flat icon="edit"
                                       class="mx-1">
                            </vs-button>
                            <vs-button v-if="$can('Delete Provider')" color="danger" type="filled" icon="delete" @click="openDeleteConfirm(tr)">
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
import provider from '@request/providers/provider'

export default {
    mounted () {
        this.getProviders(this.meta.current_page)
    },
    data: () => ({
        selected: {},
        providers: [],
        meta: {
            last_page: 1,
            current_page: 1
        },
        DeletePopupActive: false
    }),
    methods: {
        getProviders (page = 1) {
            provider.all(page).then(({data: {data, links, meta}}) => {
                this.providers = data
                this.meta = meta
            })
        },
        async deleteItem () {
            provider.delete(this.selected.id).then((data) => {
                let deleted_index = this.providers.findIndex(provider => provider.id === this.selected.id)
                this.providers.splice(deleted_index, 1)
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
    },
    watch: {
        'meta.current_page': function (val, old) {
            if (val !== old) {
                this.getProviders(val)
            }
        }
    }
}
</script>
