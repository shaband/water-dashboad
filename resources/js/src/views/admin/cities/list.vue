<template>
    <vx-card :title="$t('cities')">
        <template #actions>
            <div class="">
                <vs-button v-if="$can('Create City')" :to="{name:'admin.cities.create'}" icon="add"></vs-button>
            </div>

        </template>
        <vs-table
            :sst="true"
            hover-flat
            striped
            v-model="selected"
            :data="cities"
        >
            <template slot="thead">
                <vs-th sort-key="#">#</vs-th>
                <vs-th sort-key="name_ar">{{ $t('Name In Arabic') }}</vs-th>
                <vs-th sort-key="name_en">{{ $t('Name In English') }}</vs-th>
                <vs-th>{{ $t('Action') }}</vs-th>
            </template>

            <template slot-scope="{data}" class="mb-1">
                <vs-tr :data="tr" :key="tr.id" v-for="(tr, indextr,i) in data" :ref="`item-${tr.id}`">
                    <vs-td :data="indextr">
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
                            <vs-button v-if="$can('Edit City')" :to="{ name: 'admin.cities.edit', params:{id:tr.id} }" flat icon="edit"
                                       class="mx-1">
                            </vs-button>
                            <vs-button v-if="$can('Delete City')" color="danger" type="filled" icon="delete" @click="openDeleteConfirm(tr)">
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
import city from '@request/cities/city'

export default {
    mounted () {
        this.getCities(this.meta.current_page)
    },
    data: () => ({
        selected: {},
        cities: [],
        meta: {
            last_page: 1,
            current_page: 1
        },
        DeletePopupActive: false
    }),
    methods: {
        getCities (page = 1) {
            city.all(page).then(({data: {data, links, meta}}) => {
                this.cities = data
                this.meta = meta
            })
        },
        async deleteItem () {
            city.delete(this.selected.id).then((data) => {
                let deleted_index = this.cities.findIndex(city => city.id === this.selected.id)
                this.cities.splice(deleted_index, 1)
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
                this.getCities(val)
            }
        }
    }
}
</script>
