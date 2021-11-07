<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Ledgers</h2>
    </template>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
      <div v-if="$page.props.flash.success" class="bg-green-600 text-white">
        {{ $page.props.flash.success }}
      </div>
      <!-- <jet-button @click="create" class="mt-4 ml-8">Create</jet-button> -->

      <!-- <div class=""> -->
      <!-- <form @submit.prevent="submit" action="range" ref="form"> -->

      <form @submit.prevent="submit">
        <!-- class="rounded-md border border-black" -->
        <multiselect
          class="
            ml-2
            w-full
            inline-block
            lg:w-1/4
            border border-black
            rounded-md
            float-left
          "
          v-model="form.account_id"
          :options="option"
          placeholder="Select account group"
          label="name"
          track-by="id"
          @update:model-value="getledger"
        ></multiselect>
        <!-- style="width: 25%" -->
        <!-- <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap border"> -->
        <!-- placeholder="Select Option..." -->
        <!-- class="pr-2 ml-2 pb-2 rounded-md" -->
        <!-- lg:w-1/4 -->
        <!-- class="rounded-md w-36" -->
        <!-- <option disabled>Select option</option> -->
        <!-- <select
          v-model="form.account_id"
          name="account_id"
          class="pr-2 ml-2 pb-2 w-full lg:w-1/4 rounded-md"
          @change="getledger"
        >
          <option value="0" disabled>Choose an Account</option>
          <option
            v-for="account in accounts"
            :key="account.id"
            :value="account.id"
          >
            {{ account.name }}
          </option>
        </select> -->
        <input
          v-model="form.date_start"
          type="date"
          label="date"
          placeholder="Enter Begin date:"
          class="pr-2 ml-2 pb-2 rounded-md"
          @change="getledger"
          name="date_start"
        />
        <!-- class="pr-2 pb-2 ml-4 rounded-md placeholder-indigo-300" -->
        <div v-if="errors.date_start">{{ errors.date_start }}</div>

        <input
          v-model="form.date_end"
          type="date"
          class="pr-2 ml-2 pb-2 rounded-md"
          label="date"
          placeholder="Enter End date:"
          @change="getledger"
          name="date_end"
        />
        <!-- class="pr-2 pb-2 ml-4 rounded-md placeholder-indigo-300" -->
        <!-- value="{{new Date().toISOString().substr(0, 10)}}" -->
        <div v-if="errors.date_end">{{ errors.date_end }}</div>

        <!-- <multiselect
          style="display: inline-block"
          class="rounded-md border border-black"
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
          class="pr-2 ml-2 pb-2 w-full lg:w-1/4 rounded-md float-right"
          label="company"
          @change="coch"
        >
          <option v-for="type in companies" :key="type.id" :value="type.id">
            {{ type.name }}
          </option>
        </select>
        <table class="shadow-lg w-full border mt-4 mx-2 rounded-xl">
          <thead>
            <tr class="bg-indigo-100">
              <th class="py-2 px-4 border">Reference</th>
              <th class="py-2 px-4 border">Date</th>
              <th class="py-2 px-4 border">Decription</th>
              <th class="py-2 px-4 border">Debit</th>
              <th class="py-2 px-4 border">Credit</th>
              <th class="py-2 px-4 border">Balance</th>
            </tr>
          </thead>
          <tbody v-if="this.account_id != 0">
            <tr>
              <td class="py-1 px-4 border"></td>
              <td class="py-1 px-4 border"></td>
              <td class="py-1 px-4 border font-bold">Opening Balance</td>
              <td class="py-1 px-4 border"></td>
              <td class="py-1 px-4 border"></td>
              <td class="py-1 px-4 border font-bold text-center">
                {{ prebal }}
              </td>
            </tr>
            <tr v-for="(item, index) in entries" :key="item.id">
              <td class="py-1 px-4 border">{{ item.ref }}</td>
              <td class="py-1 px-4 border text-center">{{ item.date }}</td>
              <td class="py-1 px-4 border">{{ item.description }}</td>
              <td class="py-1 px-4 border text-center">{{ item.debit }}</td>
              <td class="py-1 px-4 border text-center">{{ item.credit }}</td>
              <!-- <td class="py-1 px-4 border">{{ item.balance }}</td> -->
              <td class="py-1 px-4 border text-center">{{ balance[index] }}</td>
            </tr>
            <tr>
              <td class="py-1 px-4 border"></td>
              <td class="py-1 px-4 border"></td>
              <td class="py-1 px-4 border font-bold">Totals</td>
              <td class="py-1 px-4 border font-bold text-center">
                {{ debits }}
              </td>
              <td class="py-1 px-4 border font-bold text-center">
                {{ credits }}
              </td>
              <td class="py-1 px-4 border"></td>
            </tr>
          </tbody>
        </table>
      </form>
      <!-- </div> -->
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import JetButton from "@/Jetstream/Button";
import { useForm } from "@inertiajs/inertia-vue3";
import Multiselect from "@suadelabs/vue3-multiselect";

export default {
  components: {
    AppLayout,
    JetButton,
    Multiselect,
  },

  props: {
    errors: Object,
    data: Object,
    companies: Object,
    // accounts: Object,
    accounts: Array,
    account_first: Object,

    entries: Object,
    debits: Object,
    credits: Object,
    balance: Object,
    prebal: Object,

    date_start: Object,
    date_end: Object,
  },

  data() {
    return {
      co_id: this.$page.props.co_id,
      option: this.accounts,

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

      form: {
        // account_id: this.account_first.id,
        account_id: this.accounts[0],
        // account_id: "",
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
  //   setup(props) {
  //     const form = useForm({
  //       account_id: props.account_first.id,
  //       date_start: null,
  //       date_end: "",
  //     });
  //     return { form };
  //   },

  methods: {
    getledger() {
      //   console.log(this.form.account_id);
      //   this.$inertia.get(route("getledger", this.form.account_id));
      this.$inertia.get(route("ledgers", this.form));
    },
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
