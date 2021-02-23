<template>
    <GmapMap
        :center="center"
        :zoom="7"
        map-type-id="terrain"
        style="width: 100%; height: 400px"
    >
        <GmapMarker
            :key="index"
            v-for="(marker, index) in markers"
            :position="marker.position"
            :clickable="draggable"
            :draggable="clickable"
            @dragend="dragged"
        />
    </GmapMap>
</template>

<script>
export default {
    props: {
        draggable:true,
        clickable:true,
        center: {
            type: Object,
            required: false,
            default: {
                lat: 30.974528,
                lng: 31.191797
            }
        },
        markers: {
            type: Array,
            required: false,
            default: [{
                position: {
                    lat: 30.974528,
                    lng: 31.191797
                }
            }]
        }
    },

    methods: {
        dragged (data) {
            this.$emit('markerDragged', data)
        }
    }
}
</script>
