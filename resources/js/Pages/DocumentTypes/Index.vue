<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Voucher</h2>
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
    <!-- <div class=""> -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
      <jet-button @click="create" class="mt-2 ml-2">Create</jet-button>
      <select
        v-model="co_id"
        class="pr-2 ml-2 pb-2 w-full lg:w-1/4 rounded-md float-right"
        label="company"
        @change="coch"
      >
        <option v-for="type in companies" :key="type.id" :value="type.id">
          {{ type.name }}
        </option>
      </select>
      <!-- </div> -->
      <!-- <div v-if="errors.type">{{ errors.type }}</div> -->
      <div class="">
        <table class="shadow-lg w-full border mt-4 ml-2 rounded-xl">
          <thead>
            <tr class="bg-indigo-100">
              <th class="py-2 px-4 border">Voucher Name</th>
              <th class="py-2 px-4 border w-2/5">Prefix</th>
              <th class="py-2 px-4 border">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in data" :key="item.id">
              <td class="py-1 px-4 border w-2/5">{{ item.name }}</td>
              <td class="py-1 px-4 border text-center">{{ item.prefix }}</td>
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
          </tbody>
        </table>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import JetButton from "@/Jetstream/Button";

export default {
  components: {
    AppLayout,
    JetButton,
  },

  props: ["data", "companies"],

  data() {
    return {
      co_id: this.$page.props.co_id,
    };
  },

  methods: {
    create() {
      this.$inertia.get(route("documenttypes.create"));
    },

    edit(id) {
      this.$inertia.get(route("documenttypes.edit", id));
    },

    destroy(id) {
      this.$inertia.delete(route("documenttypes.destroy", id));
    },
    coch() {
      this.$inertia.get(route("companies.coch", this.co_id));
    },
  },
};
</script>
