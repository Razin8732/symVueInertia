<template>
  <div>
    <table class="table">
      <thead>
        <th>#</th>
        <th>Name</th>
        <th>Email</th>
        <th>Address</th>
        <th>Action</th>
      </thead>
      <tbody>
        <tr v-for="customer in customers.data" :key="customer.id">
          <td>{{ customer.id }}</td>
          <td>{{ customer.name }}</td>
          <td>{{ customer.email }}</td>
          <td>
            {{ customer.address }}, {{ customer.city }},{{ customer.state }},{{
              customer.address
            }}
          </td>
          <td>
            <Link
              class="btn btn-primary text-white btn-sm"
              :href="'/customer/edit/' + customer.id"
            >
              <i class="fa fa-pencil"></i>
            </Link>
          </td>
        </tr>
        <tr v-if="customers.length == 0">
          <td colspan="5">No customers found.</td>
        </tr>
      </tbody>
    </table>
    <div>
      <nav aria-label="Page navigation example">
        <ul class="pagination">
          <li
            class="page-item"
            v-for="(link, key) in pages"
            :key="key"
            :class="{ active: link.active }"
          >
            <!-- <div
              v-if="link.url == null"
              class="page-item"
              :class="{ 'ms-auto': link.label === 'Next' }"
            >
              {{ customers.links.label }}
            </div> -->
            <Link
              class="page-link"
              :id="arrayLength"
              :href="link.url"
              :class="{ active: link.active, 'ml-auto': link.label === 'Next' }"
            >
              {{ link.label }}
            </Link>
          </li>

          <li class="page-item ms-auto" style="width: 10rem;">
            <div class="ms-auto d-flex flex-row">
              <span class="d-flex align-items-center" style="width: 5rem;">
                Per Page:
              </span>
              <select
                class="form-control w-50 ms-auto"
                name="perpage"
                id="perpage"
                v-model="perpage"
                @change="$emit('changePerPage', perpage)"
              >
                <option value="2">2</option>
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
    <!-- <PaginationComponent
      :links="customers.links"
      @changePerPage="changePerPage"
    ></PaginationComponent> -->
  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'
import PaginationComponent from '../Shared/PaginationComponent'
export default {
  name: 'CustomerTable',
  metaInfo: { title: 'Customer' },
  components: {
    Link,
    PaginationComponent,
  },
  props: {
    customers: Array | Object,
    currentpage: Number | String,
  },
  data() {
    return {
      perpage: 5,
      numShown: 5,
      current: parseInt(this.currentpage),
    }
  },
  computed: {
    arrayLength() {
      return this.customers.links.length - 2 // -2 because of the next and previous buttons
    },
    pages() {
      const numShown = Math.min(this.numShown, this.customers.links.length)
      var start = this.current
      var max = this.customers.links.length - 2
      var end = this.current + (numShown - 1)
      if (end > max) {
        start = start - 3
        var diff = end - max
        end = end - diff
      }
      // console.log(this.customers.links.length)
      let final2 = []
      let temp
      temp = {
        label: 'First',
        url: this.customers.links[1].url,
        active: this.customers.links[1].active,
      }
      final2.push(temp)
      temp = {
        label: this.customers.links[0].label,
        url: this.customers.links[0].url,
        active: this.customers.links[0].active,
      }
      final2.push(temp)
      if (this.current != 1) {
        temp = {
          label: this.customers.links[this.current - 1].label,
          url: this.customers.links[this.current - 1].url,
          active: this.customers.links[this.current - 1].active,
        }
        final2.push(temp)
      }
      for (let i = start; i <= end; i++) {
        temp = {
          active: this.customers.links[i].active,
          label: this.customers.links[i].label,
          url: this.customers.links[i].url,
        }
        final2.push(temp)
      }
      temp = {
        active: this.customers.links[this.customers.links.length - 1].active,
        label: this.customers.links[this.customers.links.length - 1].label,
        url: this.customers.links[this.customers.links.length - 1].url,
      }
      final2.push(temp)
      return final2
    },
  },

  methods: {
    // changePerPage() {
    //   console.log(this.perpage);
    // },
  },
}
</script>
