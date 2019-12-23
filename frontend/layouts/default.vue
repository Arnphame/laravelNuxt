<template>
  <div>
    <Navbar />
    <nuxt />
    <Footer />
  </div>
</template>

<script>
import Navbar from '@/components/Navbar'
import Footer from '@/components/Footer'
import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';


Vue.use(BootstrapVue)
Vue.component('VueCtkDateTimePicker', VueCtkDateTimePicker);
export default {
  components: {
    Navbar,
      Footer
  }
}
</script>
