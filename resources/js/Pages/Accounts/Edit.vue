<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Edit Accounts
      </h2>
    </template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
      <div class="">
        <form @submit.prevent="submit">
          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Account Name :</label
            ><input
              type="text"
              v-model="form.name"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="name"
              placeholder="Enter name:"
            />
            <div v-if="errors.name">{{ errors.name }}</div>
          </div>
          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Account Number :</label
            ><input
              type="text"
              v-model="form.number"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="number"
              placeholder="Enter number:"
            />
            <div v-if="errors.number">{{ errors.number }}</div>
          </div>
          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Account Group :</label
            >
            <multiselect
              class="rounded-md border border-black"
              v-model="form.group"
              :options="option"
              placeholder="Select account group"
              label="name"
              track-by="id"
              style="width: 25%"
            ></multiselect>
            <!-- <select
              v-model="form.group"
              class="pr-2 pb-2 w-full lg:w-1/4 rounded-md"
              label="group"
              placeholder="Enter Group"
            >
              <option v-for="type in groups" :key="type.id" :value="type.id">
                {{ type.name }}
              </option>
            </select> -->
            <div v-if="errors.group">{{ errors.group }}</div>
          </div>
          <div
            class="
              px-4
              py-2
              bg-gray-100
              border-t border-gray-200
              flex
              justify-center
              items-center
            "
          >
            <button
              class="border bg-indigo-300 rounded-xl px-4 py-2 ml-4 mt-4"
              type="submit"
            >
              Update Account
            </button>
          </div>
        </form>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Multiselect from "@suadelabs/vue3-multiselect";

export default {
  components: {
    AppLayout,
    Multiselect,
  },

  props: {
    errors: Object,
    account: Object,
    groups: Array,
    group_first: Object,
    // groups: Object,
  },

  data() {
    return {
      option: this.groups,
      form: this.$inertia.form({
        name: this.account.name,
        number: this.account.number,
        // group: this.groups[this.account.group_id],
        group: this.group_first,
      }),
    };
  },

  methods: {
    submit() {
      this.$inertia.put(route("accounts.update", this.account.id), this.form);
    },
  },
};
</script>
