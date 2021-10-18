<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Edit File
      </h2>
    </template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
      <div class="">
        <form @submit.prevent="submit">
          <div class="p-2 mr-2 mb-2 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Select Item :</label
            >
            <multiselect
              style="width: 25%"
              class="rounded-md border border-black"
              v-model="form.item_id"
              :options="items"
              placeholder="Select Item"
              label="name"
              track-by="id"
            ></multiselect>
            <div v-if="errors.item_id">{{ errors.item_id }}</div>
          </div>

          <div class="p-2 mr-2 mb-2 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Select File :</label
            >
            <multiselect
              style="width: 25%"
              class="rounded-md border border-black"
              v-model="form.file_id"
              :options="files"
              placeholder="Select File"
              label="file_no"
              track-by="id"
            ></multiselect>
            <div v-if="errors.file_id">{{ errors.file_id }}</div>
          </div>

          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">Number :</label>
            <input
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
              placeholder="Enter Number :"
            />
            <div v-if="errors.number">{{ errors.number }}</div>
          </div>

          <div class="p-2 mr-2 mb-2 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Select Invoice :</label
            >
            <multiselect
              style="width: 25%"
              class="rounded-md border border-black"
              v-model="form.invoice_id"
              :options="invoices"
              placeholder="Select Invoice"
              label="amount"
              track-by="id"
            ></multiselect>
            <div v-if="errors.invoice_id">{{ errors.invoice_id }}</div>
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
              Update Quantity
            </button>
          </div>
        </form>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Label from "../../Jetstream/Label.vue";
import Multiselect from "@suadelabs/vue3-multiselect";

export default {
  components: {
    AppLayout,
    Multiselect,
  },

  props: {
    errors: Object,
    quantity: Object,

    items: Array,
    files: Array,
    invoices: Array,

    item: Object,
    file: Object,
    invoice: Object,
  },

  data() {
    return {
      agents: this.agents,
      importers: this.importers,
      clients: this.clients,

      form: this.$inertia.form({
        item_id: this.item,
        file_id: this.file,
        number: this.quantity.number,
        invoice_id: this.invoice,
      }),
    };
  },

  methods: {
    submit() {
      this.$inertia.put(
        route("quantities.update", this.quantity.id),
        this.form
      );
    },
  },
};
</script>
