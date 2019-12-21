<template>
  <div>
    <Navbar />
    <nuxt />
  </div>
</template>

<script>
import Navbar from '@/components/Navbar'
import Vue from 'vue'

import BootstrapVue from 'bootstrap-vue'

Vue.use(BootstrapVue)
export default {
  components: {
    Navbar
  }
}
</script>
