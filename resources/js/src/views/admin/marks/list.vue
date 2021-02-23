<template>
    <vx-card :title="$t('marks')">
        <template #actions>
            <div class="">
                <vs-button v-if="$can('Create Mark')" :to="{name:'admin.marks.create'}" icon="add"></vs-button>
            </div>

        </template>
        <vs-table
            :sst="true"
            hover-flat
            striped
            v-model="selected"
            :data="marks"
        >
            <template slot="thead">
                <vs-th sort-key="#">#</vs-th>
                <vs-th sort-key="#">{{ $t('image') }}</vs-th>
                <vs-th sort-key="name_ar">{{ $t('Name In Arabic') }}</vs-th>
                <vs-th sort-key="name_en">{{ $t('Name In English') }}</vs-th>
                <vs-th sort-key="name_en">{{ $t('Activation') }}</vs-th>
                <vs-th>{{ $t('Action') }}</vs-th>
            </template>

            <template slot-scope="{data}" class="mb-1">
                <vs-tr :data="tr" :key="tr.id" v-for="(tr, indextr,i) in data" :ref="`item-${tr.id}`">
                    <vs-td :data="indextr">
                    </vs-td><vs-td :data="indextr">
                    <img :src="tr.image" width="200" height="100"/>
                    </vs-td>
                    <vs-td :data="data[indextr].name" class="border-l-2">
                        {{ tr.name_ar }}
                    </vs-td>
                    <vs-td :data="data[indextr].name" class="border-l-2">
                        {{ tr.name_en }}
                    </vs-td>

                    <vs-td :data="! !!tr.blocked_at" class="border-l-2">
                        <vs-switch @input="toggle_activation(tr)" :value="! !!tr.blocked_at"/>
                    </vs-td>
                    <vs-td :data="tr.id">
                        <div class="flex">
                            <vs-button v-if="$can('Edit Mark')" :to="{ name: 'admin.marks.edit', params:{id:tr.id} }" flat icon="edit"
                                       class="mx-1">
                            </vs-button>
                            <vs-button v-if="$can('Delete Mark')" color="danger" type="filled" icon="delete" @click="openDeleteConfirm(tr)">
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
import mark from '@request/marks/mark'

export default {
    mounted () {
        this.getMarks(this.meta.current_page)
    },
    data: () => ({
        selected: {},
        marks: [],
        meta: {
            last_page: 1,
            current_page: 1
        },
        DeletePopupActive: false
    }),
    methods: {
        getMarks (page = 1) {
            mark.all(page).then(({data: {data, links, meta}}) => {
                this.marks = data
                this.meta = meta
            })
        },
        async deleteItem () {
            mark.delete(this.selected.id).then((data) => {
                let deleted_index = this.marks.findIndex(mark => mark.id === this.selected.id)
                this.marks.splice(deleted_index, 1)
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
            mark.toggleBlock(tr.id).then(({data}) => {
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
                this.getMarks(val)
            }
        }
    }
}
</script>
