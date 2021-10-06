<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Edit Quantity
      </h2>
    </template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
      <div class="">
        <form @submit.prevent="submit">
          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">
              Item Name:</label
            >
            <select
              v-model="form.item_id"
              class="pr-2 pb-2 w-full lg:w-1/4 rounded-md"
              label="bank_id"
              placeholder="Enter type"
            >
              <option v-for="item in items" :key="item.id" :value="item.id">
                {{ item.name }}
              </option>
            </select>
            <div v-if="errors.item_id">{{ errors.item_id }}</div>
          </div>
          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">Number :</label
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
              label="name"
            />
            <div v-if="errors.number">{{ errors.number }}</div>
          </div>
          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">
              File Number:</label
            >
            <select
              v-model="form.file_id"
              class="pr-2 pb-2 w-full lg:w-1/4 rounded-md"
              label="bank_id"
              placeholder="Enter type"
            >
              <option v-for="file in files" :key="file.id" :value="file.id">
                {{ file.file_no }}
              </option>
            </select>
            <div v-if="errors.file_id">{{ errors.file_id }}</div>
          </div>
          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold"> Amount:</label>
            <select
              v-model="form.invoice_id"
              class="pr-2 pb-2 w-full lg:w-1/4 rounded-md"
              label="bank_id"
              placeholder="Enter type"
            >
              <option
                v-for="invoice in invoices"
                :key="invoice.id"
                :value="invoice.id"
              >
                {{ invoice.amount }}
              </option>
            </select>
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

export default {
  components: {
    AppLayout,
  },

  props: {
    errors: Object,
    items: Object,
    files: Object,
    invoices: Object,
    quantity: Object,
  },

  data() {
    return {
      form: this.$inertia.form({
        item_id: this.quantity.item_id,
        number: this.quantity.number,
        file_id: this.quantity.file_id,
        invoice_id: this.quantity.invoice_id,
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
