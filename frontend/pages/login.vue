<template>
  <div class="container col-md-3 mt-5 flex-column d-flex">
    <h2>Login</h2>
    <br>
    <form @submit.prevent="submit">
      <div class="form-group">
        <label>Email address</label>
        <input v-model.trim="form.email" type="email" class="form-control" placeholder="Enter email" autofocus>
        <small v-if="errors.email" class="form-text text-danger">{{ errors.email[0] }}</small>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input v-model.trim="form.password" type="password" class="form-control" placeholder="Password">
        <small v-if="errors.password" class="form-text text-danger">{{ errors.password[0] }}</small>
      </div>
      <button type="submit" class="btn btn-primary">
        Login
      </button>
    </form>
    <br>
    <p>
      Don't have an account? <NuxtLink to="/register">
        Register
      </NuxtLink>
    </p>
  </div>
</template>

<script>
export default {
  middleware: ['guest'],
  data () {
    return {
      form: {
        email: '',
        password: ''
      }
    }
  },
  methods: {
    async submit () {
      try {
        await this.$auth.loginWith('local', {
          data: this.form
        })
        this.$router.push({
          path: this.$route.query.redirect || '/login'
        })
      } catch (e) { }
    }
  }
}
</script>
