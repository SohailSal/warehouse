<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Edit Receipt
      </h2>
    </template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
      <div class="">
        <form @submit.prevent="submit">
          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">Date :</label
            ><input
              type="date"
              v-model="form.date"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
            />
            <div v-if="errors.date">{{ errors.date }}</div>
          </div>

          <!-- <div class="p-2 mr-2 mb-2 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Select Importer :</label
            >
            <multiselect
              style="width: 25%"
              class="rounded-md border border-black"
              v-model="form.file_id"
              :options="files"
              placeholder="Select File"
              label="file_no"
              track-by="id"
            ></multiselect> -->
          <!-- @update:model-value="updateSelected" -->
          <!-- <div v-if="errors.file_id">{{ errors.file_id }}</div>
          </div> -->
          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 ml-4 mr-8 text-right w-36 font-bold"
              >Without Incl. Tax :</label
            >
            <input
              v-model="form.tax_status"
              name="tax_status"
              type="radio"
              value="0"
              class="pr-2 pb-2 rounded-md placeholder-indigo-300"
            />

            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Include Tax :</label
            >
            <input
              v-model="form.tax_status"
              name="tax_status"
              type="radio"
              value="1"
              class="pr-2 pb-2 rounded-md placeholder-indigo-300"
            />
            <label class="my-2 mr-8 text-right w-24 font-bold">None :</label>
            <input
              v-model="form.tax_status"
              name="tax_status"
              type="radio"
              value="2"
              class="pr-2 pb-2 rounded-md placeholder-indigo-300"
            />
          </div>

          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">Amount :</label
            ><input
              type="number"
              @change="cal_i_tax"
              v-model="form.amount"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
            />
            <div v-if="errors.amount">{{ errors.amount }}</div>
          </div>

          <div
            v-if="form.tax_status != 2"
            class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap"
          >
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Income Tax :</label
            ><input
              type="number"
              v-model="form.i_tax"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
            />
            <div v-if="errors.i_tax">{{ errors.i_tax }}</div>
          </div>

          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">Com :</label
            ><input
              type="number"
              v-model="form.com"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
            />
            <div v-if="errors.com">{{ errors.com }}</div>
          </div>

          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">Total :</label
            ><input
              type="number"
              v-model="form.total"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              readonly
            />
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
              Update Receipt
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
    receipt: Object,
    // files: Object,
  },

  data() {
    return {
      form: this.$inertia.form({
        date: this.receipt.date,
        file_id: this.receipt.files,
        document_id: this.receipt.document_id,
        tax_status: this.receipt.tax_status,
        amount: this.receipt.amount,
        i_tax: this.receipt.i_tax,
        total: this.receipt.total,
        com: this.receipt.com,
      }),
    };
  },

  methods: {
    submit() {
      this.$inertia.put(route("receipts.update", this.receipt.id), this.form);
    },
    cal_i_tax() {
      if (this.form.tax_status == 2) {
        this.form.i_tax = 0;
      } else if (this.form.tax_status == 0) {
        this.form.i_tax = parseInt((this.form.amount * 13) / 100).toFixed(2);
      } else {
        this.form.i_tax = parseInt((this.form.amount * 13) / 100).toFixed(2);
        this.form.amount = parseInt(this.form.amount - this.form.i_tax).toFixed(
          2
        );
      }
      this.form.total = (
        parseInt(this.form.amount) + parseInt(this.form.i_tax)
      ).toFixed(2);
    },
  },
};
</script>
