<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">File</h2>
    </template>
    <div
      v-if="$page.props.flash.success"
      class="bg-green-600 text-white text-center"
    >
      {{ $page.props.flash.success }}
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
      <jet-button @click="create" class="mt-4 ml-2">Create</jet-button>
      <input
        type="search"
        v-if="file"
        v-model="params.search"
        aria-label="Search"
        placeholder="Search..."
        class="pr-2 pb-2 w-full lg:w-1/4 ml-6 rounded-md placeholder-indigo-300"
      />
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
              <th class="py-2 px-4 border">File No</th>
              <th class="py-2 px-4 border">GD No</th>
              <th class="py-2 px-4 border">Bond No</th>
              <th class="py-2 px-4 border">Date Bond</th>
              <th class="py-2 px-4 border">Description</th>
              <th class="py-2 px-4 border">Vessel</th>
              <th class="py-2 px-4 border">Gross wt</th>
              <th class="py-2 px-4 border">Net wt</th>
              <th class="py-2 px-4 border">BL no</th>
              <th class="py-2 px-4 border">Insurance</th>
              <th class="py-2 px-4 border">Agent</th>
              <th class="py-2 px-4 border">Importer</th>
              <th class="py-2 px-4 border">Client</th>
              <th class="py-2 px-4 border">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in balances.data" :key="item.id">
              <td class="py-1 px-4 border">{{ item.file_no }}</td>
              <td class="py-1 px-4 border">{{ item.gd_no }}</td>
              <td class="py-1 px-4 border">{{ item.bond_no }}</td>
              <td class="py-1 px-4 border">{{ item.date_bond }}</td>
              <td class="py-1 px-4 border">{{ item.description }}</td>
              <td class="py-1 px-4 border">{{ item.vessel }}</td>
              <td class="py-1 px-4 border">{{ item.gross_wt }}</td>
              <td class="py-1 px-4 border">{{ item.net_wt }}</td>
              <td class="py-1 px-4 border">{{ item.bl_no }}</td>
              <td class="py-1 px-4 border">{{ item.insurance }}</td>
              <td class="py-1 px-4 border">{{ item.agent_id }}</td>
              <td class="py-1 px-4 border">{{ item.importer_id }}</td>
              <td class="py-1 px-4 border">{{ item.client_id }}</td>
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
    balances: Object,
    filters: Object,
    companies: Object,
    file: Object,
  },

  data() {
    return {
      co_id: this.$page.props.co_id,

      params: {
        search: this.filters.search,
        field: this.filters.field,
        direction: this.filters.direction,
      },
    };
  },

  methods: {
    create() {
      this.$inertia.get(route("files.create"));
    },

    edit(id) {
      this.$inertia.get(route("files.edit", id));
    },

    destroy(id) {
      this.$inertia.delete(route("files.destroy", id));
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
      handler: throttle(function () {
        let params = pickBy(this.params);
        this.$inertia.get(this.route("files"), params, {
          replace: true,
          preserveState: true,
        });
      }, 150),
      deep: true,
    },
  },
};
</script>
