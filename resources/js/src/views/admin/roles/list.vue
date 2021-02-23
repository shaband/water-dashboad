<template>
    <vx-card :title="$t('roles')">
        <template #actions>
            <div class="">
                <vs-button v-if="$can('Create Roles')" :to="{name:'admin.roles.create'}" icon="add"></vs-button>
            </div>

        </template>
        <vs-table
            :sst="true"
            hover-flat
            striped
            v-model="selected"
            :data="roles"
        >
            <template slot="thead">
                <vs-th sort-key="#">#</vs-th>
                <vs-th sort-key="username">{{ $t('Name') }}</vs-th>
                <vs-th>{{ $t('Action') }}</vs-th>
            </template>

            <template slot-scope="{data}" class="mb-1">
                <vs-tr :data="tr" :key="tr.id" v-for="(tr, indextr,i) in data" :ref="`item-${tr.id}`">
                    <vs-td :data="indextr">
                        {{ indextr + 1 }}
                    </vs-td>
                    <vs-td :data="data[indextr].name" class="border-l-2">
                        {{ tr.label_ar }}
                    </vs-td>
                    <vs-td :data="tr.id">
                        <div class="flex">
                            <vs-button v-if="$can('Edit Roles')" :to="{ name: 'admin.roles.edit', params:{id:tr.id} }" flat icon="edit"
                                       class="mx-1">
                            </vs-button>
                            <vs-button v-if="$can('Delete Roles')" color="danger" type="filled" icon="delete" @click="openDeleteConfirm(tr)">
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
import role from '@request/roles/role'

export default {
    mounted () {

        this.getRoles(this.meta.current_page)
    },
    data: () => ({
        selected: {},
        roles: [],
        meta: {
            last_page: 1,
            current_page: 1
        },
        DeletePopupActive: false
    }),
    methods: {
        getRoles (page = 1) {
            role.all(page).then(({data: {data, links, meta}}) => {
                this.roles = data
                this.meta = meta
            })
        },
        async deleteItem () {
            role.delete(this.selected.id).then((data) => {
                let deleted_index = this.roles.findIndex(role => role.id === this.selected.id)
                this.roles.splice(deleted_index, 1)
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
                text: `${this.$t('Are You Sure You Want Delete')} ${this.selected.label_ar}`,
                accept: this.deleteItem
            })
        }
    },
    watch: {
        'meta.current_page': function (val, old) {
            if (val !== old) {
                this.getRoles(val)
            }
        }
    }
}
</script>
