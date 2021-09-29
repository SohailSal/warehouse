<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Year</h2>
    </template>
    <div class="">
      <form @submit.prevent="submit">
        <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
          <input
            type="date"
            v-model="form.begin"
            class="pr-2 pb-2 rounded-md placeholder-indigo-300"
            label="date"
            placeholder="Begin year:"
          />
          <div v-if="errors.begin">{{ errors.begin }}</div>
        </div>

        <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
          <input
            type="date"
            v-model="form.end"
            class="pr-2 pb-2 rounded-md placeholder-indigo-300"
            label="date"
            placeholder="End year:"
          />
          <div v-if="errors.end">{{ errors.end }}</div>
        </div>
        <div
          class="px-4 py-2 bg-gray-100 border-t border-gray-200 flex justify-start items-center"
        >
          <button
            class="border bg-indigo-300 rounded-xl px-4 py-2 ml-4 mt-4"
            type="submit"
          >
            Update Year
          </button>
        </div>
      </form>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
// import Datepicker from "vue3-datepicker";
import format from "date-fns/format";
import Input from "../../Jetstream/Input.vue";

export default {
  components: {
    AppLayout,
    // Datepicker,
    Input,
  },

  props: {
    errors: Object,
    year: Object,
  },

  data() {
    return {
      form: {
        begin: this.year.begin,
        end: this.year.end,
      },
    };
  },

  methods: {
    submit() {
      this.$inertia.put(route("years.update", this.year.id), this.form);
    },
  },
};
</script>
