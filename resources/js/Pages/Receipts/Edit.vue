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

          <!-- Income Tax Radio Button -->

          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 ml-4 mr-8 text-right w-42 font-bold"
              >Income Tax Deducted :</label
            >
            <input
              v-model="form.tax_status"
              @change="cal_check_income"
              name="tax_status"
              type="radio"
              value="1"
              class="pr-2 pb-2 rounded-md placeholder-indigo-300"
            />

            <label class="my-2 mr-8 text-right w-24 font-bold">None :</label>
            <input
              @change="cal_none_i_tax"
              v-model="form.tax_status"
              name="tax_status"
              type="radio"
              value="0"
              class="pr-2 pb-2 rounded-md placeholder-indigo-300"
            />
          </div>

          <!-- Sale Tax Radio Button -->
          <div
            v-if="form.tax_status == 1"
            class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap"
          >
            <label class="my-2 ml-6 mr-9 text-right w-42 font-bold"
              >Sales Tax Deducted :</label
            >
            <input
              v-model="form.s_tax_status"
              name="s_tax_status"
              type="radio"
              value="1"
              class="pr-2 pb-2 rounded-md placeholder-indigo-300"
            />

            <label class="my-2 mr-8 text-right w-24 font-bold">None :</label>
            <input
              @change="cal_none_s_tax"
              v-model="form.s_tax_status"
              name="s_tax_status"
              type="radio"
              value="0"
              class="pr-2 pb-2 rounded-md placeholder-indigo-300"
            />
          </div>

          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">Amount:</label
            ><input
              type="number"
              v-model="form.amount"
              @change="cal_i_tax"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="date"
              placeholder="10,000"
            />
            <!-- <div v-if="errors.amount">{{ errors.amount }}</div> -->
            <!-- </div>
          <div
            class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap"
          > -->
            <!-- v-if="form.tax_status != 2" -->
            <label
              class="my-2 mr-8 text-right w-36 font-bold"
              v-if="form.tax_status == 1"
              >Income Tax:</label
            >
            <!-- v-if="form.tax_status != 2" -->
            <input
              v-if="form.tax_status == 1"
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
              readonly
              placeholder="50"
            />
            <br />
          </div>
          <div class="ml-52" v-if="errors.amount">{{ errors.amount }}</div>

          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">Com:</label
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
              label="date"
              placeholder="50"
            />
            <div v-if="errors.com">{{ errors.com }}</div>

            <label
              class="my-2 mr-8 text-right w-36 font-bold"
              v-if="form.s_tax_status == 1 && form.tax_status == 1"
              >Sales Tax:</label
            ><input
              type="number"
              v-model="form.s_tax"
              @change="cal_s_tax"
              v-if="form.s_tax_status == 1 && form.tax_status == 1"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="date"
              placeholder="50"
            />
            <div v-if="errors.s_tax">{{ errors.s_tax }}</div>
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
              placeholder="10,000"
              readonly
            />
            <div v-if="errors.com">{{ errors.com }}</div>
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
        s_tax_status: this.receipt.s_tax_status,
        amount: this.receipt.amount,
        i_tax: this.receipt.i_tax,
        s_tax: this.receipt.s_tax,
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
      if (this.form.tax_status == 1) {
        this.form.i_tax = parseInt((this.form.amount * 10) / 100).toFixed(2);
      } else {
        this.form.i_tax = 0;
      }
      this.form.total = (
        parseInt(this.form.amount) + parseInt(this.form.i_tax)
      ).toFixed(2);
    },
    cal_s_tax() {
      if (this.form.s_tax_status == 1) {
        let x = (
          parseInt(this.form.amount) + parseInt(this.form.s_tax)
        ).toFixed(2);
        this.form.total = parseInt(x) + parseInt(this.form.i_tax);
      } else {
        this.form.s_tax = 0;
      }
    },
    cal_none_s_tax() {
      if (this.form.s_tax_status == 0) {
        this.form.s_tax = 0;
        this.cal_i_tax();
      } else {
        this.cal_i_tax();
      }
    },
    cal_none_i_tax() {
      this.form.i_tax = 0;
      this.form.s_tax = 0;
      this.form.s_tax_status = 0;
      this.cal_i_tax();
    },
    cal_check_income() {
      this.cal_i_tax();
    },
  },
};
</script>
