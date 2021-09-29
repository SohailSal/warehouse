<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Account Groups
      </h2>
    </template>
    <div
      v-if="$page.props.flash.success"
      class="bg-green-600 text-white text-center"
    >
      {{ $page.props.flash.success }}
    </div>
    <div
      v-if="$page.props.flash.warning"
      class="bg-yellow-600 text-white text-center"
    >
      {{ $page.props.flash.warning }}
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
      <jet-button @click="create" class="mt-4 ml-2">Create</jet-button>
      <jet-button @click="generate" v-if="exists" class="mt-4 ml-2"
        >Auto Generate Groups</jet-button
      >

      <!-- disabled="false" -->
      <!-- <button
      class="border bg-indigo-300 rounded-xl px-4 py-1 m-1"
      @click="check();
        this.disable = true;
        (_) => {
          setTimeout(() => {}, 1000);
        };
      "
    >
      <span>Check</span>
    </button> -->

      <input
        type="search"
        v-model="params.search"
        aria-label="Search"
        placeholder="Search..."
        class="pr-2 pb-2 w-full lg:w-1/4 ml-6 rounded-md placeholder-indigo-300"
      />
      <select
        v-model="co_id"
        class="pr-2 ml-2 pb-2 w-full lg:w-1/4 rounded-md float-right mt-2"
        label="company"
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
              <th class="py-2 px-4 border w-2/5">Group Name</th>
              <th class="py-2 px-4 border">Group Type</th>
              <th class="py-2 px-4 border">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in balances.data" :key="item.id">
              <td class="py-1 px-4 border">{{ item.name }}</td>
              <td class="py-1 px-4 border text-center">{{ item.type_name }}</td>
              <td class="py-1 px-4 border text-center">
                <button
                  class="border bg-indigo-300 rounded-xl px-4 py-1 m-1"
                  @click="edit(item.id)"
                >
                  <span>Edit</span>
                </button>
                <button
                  class="border bg-red-500 rounded-xl px-4 py-1 m-1"
                  @click="destroy(item.id)"
                  v-if="item.delete"
                >
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

export default {
  components: {
    AppLayout,
    JetButton,
    Paginator,
    throttle,
    pickBy,
  },

  props: {
    data: Object,
    balances: Object,
    filters: Object,
    companies: Object,
    exists: Object,
  },

  data() {
    return {
      co_id: this.$page.props.co_id,

      params: {
        search: this.filters.search,
        // field: this.filters.field,
        // direction: this.filters.direction,
      },
    };
  },

  methods: {
    create() {
      this.$inertia.get(route("accountgroups.create"));
    },

    edit(id) {
      this.$inertia.get(route("accountgroups.edit", id));
    },

    destroy(id) {
      this.$inertia.delete(route("accountgroups.destroy", id));
    },

    generate() {
      this.$inertia.get(route("accountgroups.generate"));
    },

    coch() {
      this.$inertia.get(route("companies.coch", this.co_id));
    },

    sort(field) {
      this.params.field = field;
      this.params.direction = this.params.direction === "asc" ? "desc" : "asc";
    },

    check() {
      console.log("click");

      setTimeout(() => {
        console.log("timer");
        // this.postRecordSolo('clientStore/UPDATE_RECORDS_NO_TAB', this.endPoint, true)
      }, 1000);
    },

    // addRecord () {
    //   setTimeout(() => {
    //     this.postRecordSolo('clientStore/UPDATE_RECORDS_NO_TAB', this.endPoint, true)
    //   }, 1000)
    // }
  },
  watch: {
    params: {
      handler: throttle(function () {
        let params = pickBy(this.params);
        this.$inertia.get(this.route("accountgroups"), params, {
          replace: true,
          preserveState: true,
        });
      }, 150),
      deep: true,
    },
  },
};
</script>
