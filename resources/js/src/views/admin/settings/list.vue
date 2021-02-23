<template>
    <vx-card :title="$t('settings')">
        <vs-table
            :sst="true"
            hover-flat
            striped
            v-model="selected"
            :data="settings"
        >
            <template slot="thead">
                <vs-th sort-key="#">#</vs-th>
                <vs-th sort-key="#">{{ $t('name') }}</vs-th>
                <vs-th sort-key="name_ar">{{ $t('value') }}</vs-th>
                <vs-th>{{ $t('Action') }}</vs-th>
            </template>

            <template slot-scope="{data}" class="mb-1">
                <vs-tr :data="tr" :key="tr.id" v-for="(tr, indextr,i) in data" :ref="`item-${tr.id}`">
                    <vs-td :data="indextr">
                    </vs-td>
                    <vs-td :data="data[indextr].slug" class="border-l-2">
                        {{ tr.slug }}
                    </vs-td>
                    <vs-td :data="data[indextr].value" class="border-l-2">
                        {{ tr.value }}
                    </vs-td>

                    <vs-td :data="tr.id">
                        <div class="flex">

                            <vs-button  :to="{ name: 'admin.settings.edit', params:{id:tr.id} }" flat icon="edit" v-if="$can('Edit Settings')"
                                       class="mx-1">
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
import setting from '@request/settings/setting'

export default {
    mounted () {
        this.getSettings(this.meta.current_page)
    },
    data: () => ({
        selected: {},
        settings: [],
        meta: {
            last_page: 1,
            current_page: 1
        },
        DeletePopupActive: false
    }),
    methods: {
        getSettings (page = 1) {
            setting.all(page).then(({data: {data, links, meta}}) => {
                this.settings = data
                this.meta = meta
            })
        },

    },
    watch: {
        'meta.current_page': function (val, old) {
            if (val !== old) {
                this.getSettings(val)
            }
        }
    }
}
</script>
