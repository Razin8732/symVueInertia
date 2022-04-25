<template>
  <div>
    <div class="row">
      <div class="col-md-11 m-auto mt-3">
        <h6>Welcome {{ $page.props.auth.user.email }}</h6>
        <h3>Dashboard</h3>
        
      </div>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'

export default {
  name: 'Dashboard',
  metaInfo: { title: 'Dashboard' },
  components: {
    Link,
  },
}
</script>
