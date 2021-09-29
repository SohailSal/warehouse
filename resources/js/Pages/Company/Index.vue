<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Company</h2>
    </template>
    <div
      v-if="$page.props.flash.success"
      class="bg-green-600 text-white text-center"
    >
      {{ $page.props.flash.success }}
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
      <!-- <jet-button v-if="can['create']" @click="create" class="mt-4 ml-8" -->
      <jet-button @click="create" class="mt-4 ml-2">Create</jet-button>
      <input
        type="search"
        v-if="companies[0]"
        v-model="params.search"
        aria-label="Search"
        placeholder="Search..."
        class="pr-2 pb-2 w-full lg:w-1/4 ml-6 rounded-md placeholder-indigo-300"
      />
      <!-- class="pr-2 ml-2 pb-2 w-full lg:w-1/4 rounded-md" -->

      <!-- <multiselect
        style="display: inline-block"
        class="rounded-md w-full border border-black"
        placeholder="Select Company."
        v-model="co_id"
        track-by="id"
        label="name"
        :options="options"
        @update:model-value="coch"
      >
      </multiselect> -->
      <select
        v-model="co_id"
        v-if="companies[0]"
        class="pr-2 ml-2 pb-2 w-full lg:w-1/4 rounded-md float-right mt-2"
        label="company"
        placeholder="Select Company"
        @change="coch"
      >
        <option v-for="type in companies" :key="type.id" :value="type.id">
          {{ type.name }}
        </option>
      </select>
      <div class="">
        <table class="w-full shadow-lg border mt-4 ml-2 rounded-xl">
          <thead>
            <tr class="bg-indigo-100">
              <th class="py-2 px-4 border">
                <span @click="sort('name')">
                  Name
                  <!-- Email Descending  Starts-->
                  <svg
                    version="1.1"
                    v-if="params.field == 'name' && params.direction == 'desc'"
                    id="Capa_1"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    x="0px"
                    y="0px"
                    width="20px"
                    height="20px"
                    class="inline ml-4"
                    viewBox="0 0 97.761 97.762"
                    style="enable-background: new 0 0 97.761 97.762"
                    xml:space="preserve"
                  >
                    <g>
                      <g>
                        <path
                          d="M42.761,65.596H34.75V2c0-1.105-0.896-2-2-2H16.62c-1.104,0-2,0.895-2,2v63.596H6.609c-0.77,0-1.472,0.443-1.804,1.137
			c-0.333,0.695-0.237,1.519,0.246,2.117l18.076,26.955c0.38,0.473,0.953,0.746,1.558,0.746s1.178-0.273,1.558-0.746L44.319,68.85
			c0.482-0.6,0.578-1.422,0.246-2.117C44.233,66.039,43.531,65.596,42.761,65.596z"
                        />
                        <path
                          d="M93.04,95.098L79.71,57.324c-0.282-0.799-1.038-1.334-1.887-1.334h-3.86c-0.107,0-0.213,0.008-0.318,0.024
			c-0.104-0.018-0.21-0.024-0.318-0.024h-3.76c-0.849,0-1.604,0.535-1.887,1.336L54.403,95.1c-0.215,0.611-0.12,1.289,0.255,1.818
			s0.983,0.844,1.633,0.844h5.773c0.88,0,1.657-0.574,1.913-1.416l2.536-8.324h14.419l2.536,8.324
			c0.256,0.842,1.033,1.416,1.913,1.416h5.771c0.649,0,1.258-0.314,1.633-0.844C93.16,96.387,93.255,95.709,93.04,95.098z
			 M68.905,80.066c2.398-7.77,4.021-13.166,4.82-16.041l4.928,16.041H68.905z"
                        />
                        <path
                          d="M87.297,34.053H69.479L88.407,6.848c0.233-0.336,0.358-0.734,0.358-1.143V2.289c0-1.104-0.896-2-2-2H60.694
			c-1.104,0-2,0.896-2,2v3.844c0,1.105,0.896,2,2,2h16.782L58.522,35.309c-0.233,0.336-0.358,0.734-0.358,1.146v3.441
			c0,1.105,0.896,2,2,2h27.135c1.104,0,2-0.895,2-2v-3.842C89.297,34.947,88.402,34.053,87.297,34.053z"
                        />
                      </g>
                    </g>
                  </svg>
                  <!-- Email Descending Ends-->

                  <!-- <svg
                  version="1.1"
                  id="Capa_1"
                  class="inline w-10 h-4"
                  xmlns="http://www.w3.org/2000/svg"
                  xmlns:xlink="http://www.w3.org/1999/xlink"
                  x="0px"
                  y="0px"
                  viewBox="0 0 301.219 301.219"
                  style="enable-background: new 0 0 301.219 301.219"
                  xml:space="preserve"
                >
                  <g>
                    <path
                      d="M159.365,23.736v-10c0-5.523-4.477-10-10-10H10c-5.523,0-10,4.477-10,10v10c0,5.523,4.477,10,10,10h139.365
		C154.888,33.736,159.365,29.259,159.365,23.736z"
                    />
                    <path
                      d="M130.586,66.736H10c-5.523,0-10,4.477-10,10v10c0,5.523,4.477,10,10,10h120.586c5.523,0,10-4.477,10-10v-10
		C140.586,71.213,136.109,66.736,130.586,66.736z"
                    />
                    <path
                      d="M111.805,129.736H10c-5.523,0-10,4.477-10,10v10c0,5.523,4.477,10,10,10h101.805c5.523,0,10-4.477,10-10v-10
		C121.805,134.213,117.328,129.736,111.805,129.736z"
                    />
                    <path
                      d="M93.025,199.736H10c-5.523,0-10,4.477-10,10v10c0,5.523,4.477,10,10,10h83.025c5.522,0,10-4.477,10-10v-10
		C103.025,204.213,98.548,199.736,93.025,199.736z"
                    />
                    <path
                      d="M74.244,262.736H10c-5.523,0-10,4.477-10,10v10c0,5.523,4.477,10,10,10h64.244c5.522,0,10-4.477,10-10v-10
		C84.244,267.213,79.767,262.736,74.244,262.736z"
                    />
                    <path
                      d="M298.29,216.877l-7.071-7.071c-1.875-1.875-4.419-2.929-7.071-2.929c-2.652,0-5.196,1.054-7.072,2.929l-34.393,34.393
		V18.736c0-5.523-4.477-10-10-10h-10c-5.523,0-10,4.477-10,10v225.462l-34.393-34.393c-1.876-1.875-4.419-2.929-7.071-2.929
		c-2.652,0-5.196,1.054-7.071,2.929l-7.072,7.071c-3.904,3.905-3.904,10.237,0,14.142l63.536,63.536
		c1.953,1.953,4.512,2.929,7.071,2.929c2.559,0,5.119-0.976,7.071-2.929l63.536-63.536
		C302.195,227.113,302.195,220.781,298.29,216.877z"
                    />
                  </g>
                </svg> -->
                  <!-- Email Ascending  Starts-->
                  <svg
                    v-if="params.field === 'name' && params.direction === 'asc'"
                    version="1.1"
                    id="Capa_1"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    x="0px"
                    y="0px"
                    class="inline ml-4"
                    width="20px"
                    height="20px"
                    viewBox="0 0 97.68 97.68"
                    style="enable-background: new 0 0 97.68 97.68"
                    xml:space="preserve"
                  >
                    <g>
                      <g>
                        <path
                          d="M42.72,65.596h-8.011V2c0-1.105-0.896-2-2-2h-16.13c-1.104,0-2,0.895-2,2v63.596H6.568c-0.77,0-1.472,0.443-1.804,1.137
			C4.432,67.428,4.528,68.25,5.01,68.85l18.076,26.955c0.38,0.473,0.953,0.746,1.558,0.746s1.178-0.273,1.558-0.746L44.278,68.85
			c0.482-0.6,0.578-1.422,0.246-2.117C44.192,66.039,43.49,65.596,42.72,65.596z"
                        />
                        <path
                          d="M92.998,39.315L79.668,1.541c-0.282-0.799-1.038-1.334-1.886-1.334h-3.861c-0.106,0-0.213,0.008-0.317,0.025
			c-0.104-0.018-0.21-0.025-0.318-0.025h-3.76c-0.85,0-1.605,0.535-1.888,1.336L54.362,39.317c-0.215,0.611-0.12,1.289,0.255,1.818
			c0.375,0.529,0.982,0.844,1.632,0.844h5.774c0.88,0,1.656-0.574,1.913-1.416l2.535-8.324H80.89l2.536,8.324
			c0.256,0.842,1.033,1.416,1.913,1.416h5.771c0.648,0,1.258-0.314,1.633-0.844C93.119,40.604,93.213,39.926,92.998,39.315z
			 M68.864,24.283c2.397-7.77,4.02-13.166,4.82-16.041l4.928,16.041H68.864z"
                        />
                        <path
                          d="M87.255,89.838H69.438l18.928-27.205c0.232-0.336,0.357-0.734,0.357-1.143v-3.416c0-1.104-0.896-2-2-2h-26.07
			c-1.104,0-2,0.896-2,2v3.844c0,1.105,0.896,2,2,2h16.782L58.481,91.094c-0.234,0.336-0.359,0.734-0.359,1.145v3.441
			c0,1.105,0.896,2,2,2h27.135c1.104,0,2-0.895,2-2v-3.842C89.255,90.732,88.361,89.838,87.255,89.838z"
                        />
                      </g>
                    </g>
                  </svg>
                  <!-- Email Ascending Ends-->
                </span>
              </th>
              <th class="py-2 px-4 border">Address</th>
              <th class="py-2 px-4 border">
                <span @click="sort('email')" class="mr-6"
                  >Email
                  <!-- Email Descending  -->
                  <svg
                    version="1.1"
                    v-if="params.field == 'email' && params.direction == 'desc'"
                    id="Capa_1"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    x="0px"
                    y="0px"
                    width="20px"
                    height="20px"
                    class="inline ml-4"
                    viewBox="0 0 97.761 97.762"
                    style="enable-background: new 0 0 97.761 97.762"
                    xml:space="preserve"
                  >
                    <g>
                      <g>
                        <path
                          d="M42.761,65.596H34.75V2c0-1.105-0.896-2-2-2H16.62c-1.104,0-2,0.895-2,2v63.596H6.609c-0.77,0-1.472,0.443-1.804,1.137
			c-0.333,0.695-0.237,1.519,0.246,2.117l18.076,26.955c0.38,0.473,0.953,0.746,1.558,0.746s1.178-0.273,1.558-0.746L44.319,68.85
			c0.482-0.6,0.578-1.422,0.246-2.117C44.233,66.039,43.531,65.596,42.761,65.596z"
                        />
                        <path
                          d="M93.04,95.098L79.71,57.324c-0.282-0.799-1.038-1.334-1.887-1.334h-3.86c-0.107,0-0.213,0.008-0.318,0.024
			c-0.104-0.018-0.21-0.024-0.318-0.024h-3.76c-0.849,0-1.604,0.535-1.887,1.336L54.403,95.1c-0.215,0.611-0.12,1.289,0.255,1.818
			s0.983,0.844,1.633,0.844h5.773c0.88,0,1.657-0.574,1.913-1.416l2.536-8.324h14.419l2.536,8.324
			c0.256,0.842,1.033,1.416,1.913,1.416h5.771c0.649,0,1.258-0.314,1.633-0.844C93.16,96.387,93.255,95.709,93.04,95.098z
			 M68.905,80.066c2.398-7.77,4.021-13.166,4.82-16.041l4.928,16.041H68.905z"
                        />
                        <path
                          d="M87.297,34.053H69.479L88.407,6.848c0.233-0.336,0.358-0.734,0.358-1.143V2.289c0-1.104-0.896-2-2-2H60.694
			c-1.104,0-2,0.896-2,2v3.844c0,1.105,0.896,2,2,2h16.782L58.522,35.309c-0.233,0.336-0.358,0.734-0.358,1.146v3.441
			c0,1.105,0.896,2,2,2h27.135c1.104,0,2-0.895,2-2v-3.842C89.297,34.947,88.402,34.053,87.297,34.053z"
                        />
                      </g>
                    </g>
                  </svg>
                  <!-- Email Ascending  Starts-->
                  <svg
                    v-if="
                      params.field === 'email' && params.direction === 'asc'
                    "
                    version="1.1"
                    id="Capa_1"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    x="0px"
                    y="0px"
                    class="inline ml-4"
                    width="20px"
                    height="20px"
                    viewBox="0 0 97.68 97.68"
                    style="enable-background: new 0 0 97.68 97.68"
                    xml:space="preserve"
                  >
                    <g>
                      <g>
                        <path
                          d="M42.72,65.596h-8.011V2c0-1.105-0.896-2-2-2h-16.13c-1.104,0-2,0.895-2,2v63.596H6.568c-0.77,0-1.472,0.443-1.804,1.137
			C4.432,67.428,4.528,68.25,5.01,68.85l18.076,26.955c0.38,0.473,0.953,0.746,1.558,0.746s1.178-0.273,1.558-0.746L44.278,68.85
			c0.482-0.6,0.578-1.422,0.246-2.117C44.192,66.039,43.49,65.596,42.72,65.596z"
                        />
                        <path
                          d="M92.998,39.315L79.668,1.541c-0.282-0.799-1.038-1.334-1.886-1.334h-3.861c-0.106,0-0.213,0.008-0.317,0.025
			c-0.104-0.018-0.21-0.025-0.318-0.025h-3.76c-0.85,0-1.605,0.535-1.888,1.336L54.362,39.317c-0.215,0.611-0.12,1.289,0.255,1.818
			c0.375,0.529,0.982,0.844,1.632,0.844h5.774c0.88,0,1.656-0.574,1.913-1.416l2.535-8.324H80.89l2.536,8.324
			c0.256,0.842,1.033,1.416,1.913,1.416h5.771c0.648,0,1.258-0.314,1.633-0.844C93.119,40.604,93.213,39.926,92.998,39.315z
			 M68.864,24.283c2.397-7.77,4.02-13.166,4.82-16.041l4.928,16.041H68.864z"
                        />
                        <path
                          d="M87.255,89.838H69.438l18.928-27.205c0.232-0.336,0.357-0.734,0.357-1.143v-3.416c0-1.104-0.896-2-2-2h-26.07
			c-1.104,0-2,0.896-2,2v3.844c0,1.105,0.896,2,2,2h16.782L58.481,91.094c-0.234,0.336-0.359,0.734-0.359,1.145v3.441
			c0,1.105,0.896,2,2,2h27.135c1.104,0,2-0.895,2-2v-3.842C89.255,90.732,88.361,89.838,87.255,89.838z"
                        />
                      </g>
                    </g>
                  </svg>
                  <!-- Email Ascending  Ends-->
                </span>
              </th>
              <th class="py-2 px-4 border">Website</th>
              <th class="py-2 px-4 border">Phone</th>
              <!-- <th v-if="can['edit'] || can['delete']" class="py-2 px-4 border"> -->
              <th class="py-2 px-4 border">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in balances.data" :key="item.id">
              <td class="py-1 px-4 border">{{ item.name }}</td>
              <td class="py-1 px-4 border">{{ item.address }}</td>
              <td class="py-1 px-4 border">{{ item.email }}</td>
              <td class="py-1 px-4 border">{{ item.web }}</td>
              <td class="py-1 px-4 border">{{ item.phone }}</td>
              <!-- <td class="py-1 px-4 border" v-if="can['edit'] || can['delete']"> -->
              <td class="py-1 px-4 border text-center">
                <button
                  class="border bg-indigo-300 rounded-xl px-4 py-1 m-1"
                  @click="edit(item.id)"
                >
                  <!-- v-if="can['edit']" -->
                  <!-- v-if="can.edit" -->
                  <span>Edit</span>
                </button>
                <button
                  class="border bg-red-500 rounded-xl px-4 py-1 m-1"
                  @click="destroy(item.id)"
                  v-if="!item.years[0]"
                >
                  <!-- v-if="!item.years[0] && can['delete']" -->
                  <span>Delete</span>
                </button>
              </td>
            </tr>
            <tr v-if="balances.data.length === 0">
              <td class="border-t px-6 py-4" colspan="4">No Record found.</td>
            </tr>
          </tbody>
        </table>
        <paginator class="mt-6" :balances="balances" />
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import JetButton from "@/Jetstream/Button";
import Paginator from "@/Layouts/Paginator";
import { pickBy } from "lodash";
import { throttle } from "lodash";
// import Multiselect from "@suadelabs/vue3-multiselect";

export default {
  components: {
    AppLayout,
    JetButton,
    Paginator,
    throttle,
    pickBy,
    // Multiselect,
  },

  //   props: ["data"],
  props: {
    balances: Object,
    filters: Object,
    can: Object,
    companies: Array,
    //FOR MULTI-SELECT
    cochange: Object,
  },

  data() {
    return {
      co_id: this.$page.props.co_id,
      // co_id: this.cochange,
      // options: this.companies,

      params: {
        search: this.filters.search,
        field: this.filters.field,
        direction: this.filters.direction,
      },
    };
  },

  methods: {
    create() {
      this.$inertia.get(route("companies.create"));
    },

    edit(id) {
      this.$inertia.get(route("companies.edit", id));
    },

    destroy(id) {
      this.$inertia.delete(route("companies.destroy", id));
    },

    coch() {
      this.$inertia.get(route("companies.coch", this.co_id));
    },

    sort(field) {
      this.params.field = field;
      this.params.direction = this.params.direction === "asc" ? "desc" : "asc";
    },
  },
  watch: {
    params: {
      //   handler() {
      //     // let params = this.params;
      //     // Object.keys(params).forEach((key) => {
      //     //   if (params[key] == "") {
      //     //     delete params[key];
      //     //   }
      //     // });

      //     this.$inertia.get(this.route("companies"), params, {
      //       replace: true,
      //       preserveState: true,
      //     });
      //   },
      //   deep: true,
      // },
      handler: throttle(function () {
        let params = pickBy(this.params);
        this.$inertia.get(this.route("companies"), params, {
          replace: true,
          preserveState: true,
        });
      }, 150),
      deep: true,
    },
  },
};
</script>
