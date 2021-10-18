<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Warehouse Reports
      </h2>
    </template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
      <div v-if="$page.props.flash.success" class="bg-green-600 text-white">
        {{ $page.props.flash.success }}
      </div>

      <select
        v-model="co_id"
        class="pr-2 ml-2 pb-2 w-full lg:w-1/4 rounded-md float-right m-2"
        label="company"
        @change="coch"
      >
        <option v-for="type in companies" :key="type.id" :value="type.id">
          {{ type.name }}
        </option>
      </select>
      <div
        class="
          border
          rounded-lg
          shadow-md
          p-2
          m-2
          inline-block
          hover:bg-gray-600
          hover:text-white
        "
      >
        <a href="deliveryorder" target="_blank">Delivery Order</a>
      </div>

      <div
        class="
          border
          rounded-lg
          shadow-md
          p-2
          m-2
          inline-block
          hover:bg-gray-600
          hover:text-white
        "
      >
        <a href="bs" target="_blank">Balance Sheet</a>
      </div>

      <div
        class="
          border
          rounded-lg
          shadow-md
          p-2
          m-2
          inline-block
          hover:bg-gray-600
          hover:text-white
        "
      >
        <a href="pl" target="_blank">Profit or Loss A/C</a>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import JetButton from "@/Jetstream/Button";
import { useForm } from "@inertiajs/inertia-vue3";

export default {
  components: {
    AppLayout,
    JetButton,
  },

  props: {
    errors: Object,
    data: Object,
    companies: Object,
    accounts: Object,
    account_first: Object,
  },

  data() {
    return {
      co_id: this.$page.props.co_id,
    };
  },

  methods: {
    meth() {
      this.form.get(route("range"));
    },
    //TO GENERATE AN PDF WITH BUTTON
    submit: function () {
      this.$refs.form.submit();
    },

    route() {
      this.$inertia.get(route("pd"));
    },

    route() {
      this.$inertia.get(route("deliveryorder"));
    },

    coch() {
      this.$inertia.get(route("companies.coch", this.co_id));
    },
  },
};
</script>
