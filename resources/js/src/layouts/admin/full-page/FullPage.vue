<template>
  <div class="layout--full-page">
    <router-view></router-view>
  </div>
</template>
<script>
export default {

    mounted () {
        this.$store.dispatch('auth/getToken')
    }
}

</script>
