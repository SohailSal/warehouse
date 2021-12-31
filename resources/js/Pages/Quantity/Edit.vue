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
            <div
              class="
                ml-2
                text-center
                bg-red-100
                border border-red-400
                text-red-700
                px-4
                py-2
                rounded
                relative
              "
              role="alert"
              v-if="errors.item_id"
            >
              {{ errors.item_id }}
            </div>
          </div>

          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">Quantity :</label
            ><input
              type="number"
              v-model="form.qty"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              placeholder="Enter Quantity"
              label="qty"
            />
            <div
              class="
                ml-2
                text-center
                bg-red-100
                border border-red-400
                text-red-700
                px-4
                py-2
                rounded
                relative
              "
              role="alert"
              v-if="errors.qty"
            >
              {{ errors.qty }}
            </div>
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
            <div
              class="
                ml-2
                text-center
                bg-red-100
                border border-red-400
                text-red-700
                px-4
                py-2
                rounded
                relative
              "
              role="alert"
              v-if="errors.file_id"
            >
              {{ errors.file_id }}
            </div>
          </div>

          <!-- <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
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
          </div> -->

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
import Multiselect from "@suadelabs/vue3-multiselect";

export default {
  components: {
    AppLayout,
    Multiselect,
  },

  props: {
    errors: Object,
    items: Object,
    files: Object,
    invoices: Object,
    quantity: Object,

    item: Object,
    file: Object,
    invoice: Object,
  },

  data() {
    return {
      form: this.$inertia.form({
        item_id: this.item,
        qty: this.quantity.qty,
        file_id: this.file,
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
