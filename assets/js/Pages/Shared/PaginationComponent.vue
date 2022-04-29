<template>
<!-- ##### NOT IN USE -->
  <div>
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item" v-for="(link, key) in links" :key="key"  :class="{ 'active': link.active }">
          <div v-if="link.url == null" class="page-item" :class="{ 'ms-auto': link.label === 'Next' }">{{links.label}}</div>
          <Link class="page-link" :href="link.url" :class="{ 'active': link.active, 'ml-auto': link.label === 'Next' }"  >{{ link.label }}</Link>
        </li>

        <li class="page-item ms-auto" style="width:10rem;">
          <div class="ms-auto d-flex flex-row">
          <span class="d-flex align-items-center" style="width:5rem;"> Per Page: </span>
          <select class="form-control w-50 ms-auto" name="perpage" id="perpage" v-model="perpage">
            <option value="2" >2</option>
            <option value="5" selected>5</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="100">100</option>
          </select>
        </div>
        </li>
      </ul>
    </nav>
  </div>
</template>
<script>
import { Link } from '@inertiajs/inertia-vue'
export default {
  name: 'PaginationComponent',
  components: {
    Link,
  },
  data() {
    return {
      perpage: 5,
    }
  },
  props: {
    links: Array,
  },
  methods:{
  
  }
}
</script>
