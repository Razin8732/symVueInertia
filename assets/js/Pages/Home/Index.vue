<template>
  <div>
    <div class="row">
      <div class="col-md-11 m-auto mt-3">
        <h6>Welcome {{ $page.props.user.email }}</h6>
      </div>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'

export default {
  name: 'Index',
  metaInfo: { title: 'Dashboard' },
  components: {
    Link,
  },
}
</script>
