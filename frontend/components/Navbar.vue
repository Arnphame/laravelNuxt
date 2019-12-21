<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light mb-5">

    <nuxt-link to="/" class="navbar-brand">
      Frontend
    </nuxt-link>
    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#navbarNav"
      aria-controls="navbarNav"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon" />
    </button>
    <div id="navbarNav" class="collapse navbar-collapse">



      <ul class="navbar-nav">
        <li class="nav-item active">
          <nuxt-link to="/" class="nav-link">
            Home
          </nuxt-link>
        </li>
        <li class="nav-item">
          <nuxt-link to="/games" class="nav-link">
            Games
          </nuxt-link>
        </li>
      </ul>

      <template v-if="!authenticated">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <nuxt-link to="/login" class="nav-link">
              Login
            </nuxt-link>
          </li>
          <li class="nav-item">
            <nuxt-link to="/register" class="nav-link">
              Register
            </nuxt-link>
          </li>
        </ul>
      </template>

      <template v-if="authenticated">

        <ul class="navbar-nav">
          <li class="nav-item" v-if="user.role === 1">
            <nuxt-link to="/games/create" class="nav-link">
              Create
            </nuxt-link>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <div>
              <b-button v-b-modal.modal-1>{{ user.name }}</b-button>
              <b-modal id="modal-1" :title="user.name + ' information'" hide-footer>
                <p class="my-4">Email: {{ user.email }}</p>
                <p class="my-4">Role: {{ user.role }}</p>
                <p class="my-4">Games played: {{ user.games_played }}</p>
                <p class="my-4">Badge: {{ user.badge }}</p>
              </b-modal>
            </div>
          </li>
          <li class="nav-item">
            <a @click.prevent="logout" class="nav-link">Logout</a>
          </li>
        </ul>
      </template>
    </div>
  </nav>
</template>

<script>
export default {
  methods: {
    logout () {
      this.$auth.logout()
    }
  }
}
</script>
