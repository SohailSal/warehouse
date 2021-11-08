<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard - {{ this.$page.props.co_id }} - {{ this.$page.props.yr_id }}
      </h2>
      <!-- <div
        class="px-4 py-2 bg-gray-100 border-t border-gray-200 flex justify-start items-center"
      > -->
      <!-- <button
        class="border bg-indigo-300 rounded-xl px-4 py-2 ml-4 mt-4"
        type="button"
        v-on="route()"
      >
        Generate PDF
      </button> -->
      <!-- :disabled="form.processing" -->
      <!-- </div> -->
    </template>

    <!-- ---------------------------------------------------------------------------- - - -->
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div
          class="
            bg-gray-700
            text-white text-3xl
            p-2
            overflow-hidden
            shadow-xl
            sm:rounded-lg
          "
        >
          Welcome to MZ ERP
        </div>
        <welcome />
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Welcome from "@/Jetstream/Welcome";

export default {
  components: {
    AppLayout,
    Welcome,
  },

  mounted: function () {
    console.log(this.$page.props.co_id);
    console.log(this.$page.props.yr_id);
  },

  methods: {
    // route() {
    //   // this.$inertia.post(route("companies.store"), this.form);
    //   this.$inertia.get(route("pd"));
    // },
  },
};
</script>
