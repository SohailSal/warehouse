<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Reports</h2>
    </template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
      <div v-if="$page.props.flash.success" class="bg-green-600 text-white">
        {{ $page.props.flash.success }}
      </div>
      <!-- <jet-button @click="create" class="mt-4 ml-8">Create</jet-button> -->

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
      <!-- <div v-if="errors.type">{{ errors.type }}</div> -->
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
        <a href="trialbalance" target="_blank">Trial Balance</a>
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

      <!-- <div
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
      <a href="pd">Generate pdf file</a>
    </div> -->
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
      //   form: this.$inertia.form({
      //     account_id: this.account_first.id,
      //     date_start: null,
      //     date_end: null,
      //   }),

      //   form: this.$refs.form({
      //     account_id: this.account_first.id,
      //     date_start: "null",
      //     date_end: null,
      //   }),

      //   form: {
      //     account_id: this.account_first.id,
      //     date_start: null,
      //     date_end: null,
      //     // begin: null,
      //     // end: null,
      //   },
    };
  },
  //   setup(props) {
  //     const form = useForm({
  //       account_id: props.account_first.id,
  //       date_start: null,
  //       date_end: "",
  //     });
  //     return { form };
  //   },

  methods: {
    meth() {
      this.form.get(route("range"));
    },
    //TO GENERATE AN PDF WITH BUTTON
    submit: function () {
      this.$refs.form.submit();
    },
    // submit() {
    //   //   entries = this.entries;
    //   //   if (this.difference === 0) {
    //   this.form.post(route("range"));
    //   //   this.$inertia.get(route("range"), this.form);
    //   //   } else {
    //   //     alert("Entry is not equal");
    //   //   }
    // },

    create() {
      this.$inertia.get(route("years.create"));
    },

    // route() {
    //   this.$inertia.post(route("range"), this.form);
    //   //   this.$inertia.get(route("range"));
    // },

    route() {
      // this.$inertia.post(route("companies.store"), this.form);
      this.$inertia.get(route("pd"));
    },

    route() {
      // this.$inertia.post(route("companies.store"), this.form);
      this.$inertia.get(route("trialbalance"));
    },

    edit(id) {
      this.$inertia.get(route("years.edit", id));
    },

    destroy(id) {
      this.$inertia.delete(route("years.destroy", id));
    },
    coch() {
      this.$inertia.get(route("companies.coch", this.co_id));
    },
  },
};
</script>
