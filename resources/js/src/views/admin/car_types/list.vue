<template>
    <vx-card :title="$t('car types')">
        <template #actions>
            <div class="">
                <vs-button v-if="$can('Create Cartype')" :to="{name:'admin.car-types.create'}" icon="add"></vs-button>
            </div>

        </template>
        <vs-table
            :sst="true"
            hover-flat
            striped
            v-model="selected"
            :data="carTypes"
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
                            <vs-button v-if="$can('Edit Cartype')" :to="{ name: 'admin.car-types.edit', params:{id:tr.id} }" flat icon="edit"
                                       class="mx-1">
                            </vs-button>
                            <vs-button v-if="$can('Delete Cartype')" color="danger" type="filled" icon="delete" @click="openDeleteConfirm(tr)">
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
import carType from '@request/car_types/carType'

export default {

    mounted () {
        this.getCarTypes(this.meta.current_page)
    },
    data: () => ({
        selected: {},
        carTypes: [],
        meta: {
            last_page: 1,
            current_page: 1
        },
        DeletePopupActive: false
    }),
    methods: {
        getCarTypes (page = 1) {
            carType.all(page).then(({data: {data, links, meta}}) => {
                this.carTypes = data
                this.meta = meta
            })
        },
        async deleteItem () {
            carType.delete(this.selected.id).then((data) => {
                let deleted_index = this.carTypes.findIndex(cartype => cartype.id === this.selected.id)
                this.carTypes.splice(deleted_index, 1)
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
                this.getCarTypes(val)
            }
        }
    }
}
</script>
