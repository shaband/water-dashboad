<template>
    <div id="dashboard-analytics">
        <div class="vx-row">

            <template v-for="(obj,group,i) in statistics" >

                <div v-for="(value,label,l) in obj" :key="`${l}-i`" class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/3 xl:w-1/3 mb-base">
                    <statistics-card-line icon="UsersIcon" :statistic="value" :statisticTitle="$t(`${label} ${group}`)"
                                          type="area"></statistics-card-line>
                </div>


            </template>
<!--            &lt;!&ndash; CARD 2: SUBSCRIBERS GAINED &ndash;&gt;-->
<!--            <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/3 xl:w-1/3 mb-base">-->
<!--                <statistics-card-line icon="UsersIcon" statistic="92.6k" statisticTitle="Subscribers Gained"-->
<!--                                      type="area"></statistics-card-line>-->
<!--            </div>-->

<!--            &lt;!&ndash; CARD 3: ORDER RECIEVED &ndash;&gt;-->
<!--            <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/3 xl:w-1/3 mb-base">-->
<!--                <statistics-card-line icon="ShoppingBagIcon" statistic="97.5K" statisticTitle="Orders Received"-->
<!--                                      color="warning" type="area"></statistics-card-line>-->
<!--            </div>-->
        </div>


    </div>
</template>

<script>
import StatisticsCardLine from '@/components/statistics-cards/StatisticsCardLine.vue'
import Home from '@request/home/home'

export default {
    data () {
        return {
            subscribersGained: {},
            ordersRecevied: {},
            statistics: {
                users: {},
                agents: {},
                deliveries: {},
                invoices: {},
                products: {},
                offers: {}
            }
        }
    },
    components: {
        StatisticsCardLine
    },
    created () {
        Home.index().then(({data}) => {
            this.statistics = data
            //   this.deliveries = data
            //   this.meta = meta
        })


    }
}
</script>

<style lang="scss">
/*! rtl:begin:ignore */
#dashboard-analytics {
    .greet-user {
        position: relative;

        .decore-left {
            position: absolute;
            left: 0;
            top: 0;
        }

        .decore-right {
            position: absolute;
            right: 0;
            top: 0;
        }
    }

    @media(max-width: 576px) {
        .decore-left, .decore-right {
            width: 140px;
        }
    }
}

/*! rtl:end:ignore */
</style>
