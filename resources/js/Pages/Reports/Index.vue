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

      <!-- <select
        v-model="co_id"
        class="pr-2 ml-2 pb-2 w-full lg:w-1/4 rounded-md float-right m-2"
        label="company"
        @change="coch"
      >
        <option v-for="type in companies" :key="type.id" :value="type.id">
          {{ type.name }}
        </option>
      </select> -->
      <!-- <div v-if="errors.type">{{ errors.type }}</div> -->
      <!-- Trial Balance Button -->
      <!-- <div
        class="
          border
          rounded-lg
          shadow-md
          p-2
          m-2
          inline-block
          hover:bg-gray-600 hover:text-white
        "
      >
        <a href="trialbalance" target="_blank">Trial Balance</a>
      </div> -->

      <!-- Balance Sheet  Button-->
      <!-- <div
        class="
          border
          rounded-lg
          shadow-md
          p-2
          m-2
          inline-block
          hover:bg-gray-600 hover:text-white
        "
      >
        <a href="bs" target="_blank">Balance Sheet</a>
      </div> -->

      <!-- Profit And Loss  Button-->
      <!-- <div
        class="
          border
          rounded-lg
          shadow-md
          p-2
          m-2
          inline-block
          hover:bg-gray-600 hover:text-white
        "
      >
        <a href="pl" target="_blank">Profit or Loss A/C</a>
      </div> -->

      <!-- Labour Contract  Button-->
      <!-- <div
        class="
          border
          rounded-lg
          shadow-md
          p-2
          m-2
          inline-block
          hover:bg-gray-600 hover:text-white
        "
      >
        <a href="labourcontract" target="_blank">Labour Contract</a>
      </div> -->

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

      <div class="mt-6 flex">
        <form
          @submit.prevent="submit_tl"
          action="trialbalance_date"
          ref="form_tl"
          class="inline-block"
        >
          <input
            v-model="form.date_start"
            type="date"
            label="date"
            placeholder="Enter Begin date:"
            class="pr-2 ml-2 pb-2 rounded-md"
            name="date_start"
          />
          <div v-if="errors.date_start">{{ errors.date_start }}</div>

          <input
            v-model="form.date_end"
            type="date"
            class="pr-2 ml-2 pb-2 rounded-md"
            label="date"
            placeholder="Enter End date:"
            name="date_end"
          />
          <div v-if="errors.date_end">{{ errors.date_end }}</div>

          <div
            class="
              border
              rounded-lg
              shadow-md
              p-2
              m-2
              inline-block
              hover:bg-gray-600 hover:text-white
              bg-indigo-300
            "
          >
            <button type="submit">Trial Balance</button>
          </div>
        </form>

        <form @submit.prevent="submit_bs" action="bs_date" ref="form_bs">
          <input
            v-model="form.date_start"
            type="date"
            label="date"
            placeholder="Enter Begin date:"
            class="pr-2 ml-2 pb-2 rounded-md hidden"
            name="date_start"
          />
          <div v-if="errors.date_start">{{ errors.date_start }}</div>

          <input
            v-model="form.date_end"
            type="date"
            class="pr-2 ml-2 pb-2 rounded-md hidden"
            label="date"
            placeholder="Enter End date:"
            name="date_end"
          />
          <div v-if="errors.date_end">{{ errors.date_end }}</div>

          <div
            class="
              border
              rounded-lg
              shadow-md
              p-2
              m-2
              inline-block
              hover:bg-gray-600 hover:text-white
              bg-indigo-300
            "
          >
            <button type="submit">Balance Sheet</button>
          </div>
        </form>

        <form @submit.prevent="submit_pl" action="pl_date" ref="form_pl">
          <input
            v-model="form.date_start"
            type="date"
            label="date"
            placeholder="Enter Begin date:"
            class="pr-2 ml-2 pb-2 rounded-md hidden"
            name="date_start"
          />
          <div v-if="errors.date_start">{{ errors.date_start }}</div>

          <input
            v-model="form.date_end"
            type="date"
            class="pr-2 ml-2 pb-2 rounded-md hidden"
            label="date"
            placeholder="Enter End date:"
            name="date_end"
          />
          <div v-if="errors.date_end">{{ errors.date_end }}</div>

          <div
            class="
              border
              rounded-lg
              shadow-md
              p-2
              m-2
              inline-block
              hover:bg-gray-600 hover:text-white
              bg-indigo-300
            "
          >
            <button type="submit">Profit or Loss A/C</button>
          </div>
        </form>
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
      form: {
        date_start: this.date_start
          ? this.date_start
          : new Date().toISOString().substr(0, 10),
        date_end: this.date_end
          ? this.date_end
          : new Date().toISOString().substr(0, 10),
        // begin: null,
        // end: null,
      },
    };
  },
  // setup(props) {
  //   const form = useForm({
  //     date_start: null,
  //     date_end: this.date_end
  //       ? null
  //       : // ? this.date_end
  //         new Date().toISOString().substr(0, 10),
  //   });
  //   return { form };
  // },
  methods: {
    submit_tl: function () {
      this.$refs.form_tl.submit();
    },
    submit_bs: function () {
      this.$refs.form_bs.submit();
    },
    submit_pl: function () {
      this.$refs.form_pl.submit();
    },
  },
};
</script>

// methods: {
//     meth() {
//       this.form.get(route("range"));
//     },
//     //TO GENERATE AN PDF WITH BUTTON
//     // submit: function () {
//     //   this.$refs.form.submit();
//     // },

//     // submit() {
//     //   //   entries = this.entries;
//     //   //   if (this.difference === 0) {
//     //   this.form.post(route("range"));
//     //   //   this.$inertia.get(route("range"), this.form);
//     //   //   } else {
//     //   //     alert("Entry is not equal");
//     //   //   }
//     // },

//     create() {
//       this.$inertia.get(route("years.create"));
//     },

//     // route() {
//     //   this.$inertia.post(route("range"), this.form);
//     //   //   this.$inertia.get(route("range"));
//     // },

//     route() {
//       // this.$inertia.post(route("companies.store"), this.form);
//       this.$inertia.get(route("pd"));
//     },

//     route() {
//       // this.$inertia.post(route("companies.store"), this.form);
//       this.$inertia.get(route("trialbalance"));
//     },

//     route() {
//       this.$inertia.get(route("labourcontract"));
//     },

//     edit(id) {
//       this.$inertia.get(route("years.edit", id));
//     },

//     destroy(id) {
//       this.$inertia.delete(route("years.destroy", id));
//     },
//     coch() {
//       this.$inertia.get(route("companies.coch", this.co_id));
//     },
//   },
