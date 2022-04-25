<template>
  <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <Link class="navbar-brand" href="/">
        App
      </Link>
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
          <Link
            class="nav-item"
            tag="li"
            href="/dashboard"
            active-class="active"
          >
            <a class="nav-link">Home</a>
          </Link>
          <Link class="nav-item" tag="li" href="/about" active-class="active">
            <a class="nav-link">About</a>
          </Link>
          <Link
            class="nav-item"
            tag="li"
            v-if="$page.props.auth.user == null"
            href="/api/login"
            active-class="active"
          >
            <a class="nav-link">Login</a>
          </Link>
          <li class="nav-item" v-if="$page.props.auth.user != null">
            <Link
              class="nav-link"
              :href="this.route('app.logout')"
            >
              Logout
            </Link>
          </li>
        </ul>
      </div>
    </nav>
    <slot />
  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'

export default {
  name: 'App',
  components: {
    Link,
  },
  methods: {
    
  },
}
</script>
