<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Edit Payment Voucher
      </h2>
    </template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
      <div class="">
        <form @submit.prevent="submit">
          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">Date:</label
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
              label="date"
              placeholder="xyz"
            />
            <div v-if="errors.date">{{ errors.date }}</div>
          </div>

          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">Payee:</label
            ><input
              type="text"
              v-model="form.payee"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="text"
              placeholder="Payee"
            />
            <div v-if="errors.payee">{{ errors.payee }}</div>
          </div>

          <div class="p-2 mr-2 mb-2 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">Debit :</label>
            <multiselect
              style="width: 25%"
              class="rounded-md border border-black"
              v-model="form.account_id"
              :options="accounts"
              placeholder="Select Name"
              label="name"
              track-by="id"
            ></multiselect>
            <div v-if="errors.account_id">{{ errors.account_id }}</div>
          </div>

          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Description:</label
            >
            <textarea
              v-model="form.description"
              rows="4"
              cols="100"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                leading-tight
                text-transform:
                capitalize
              "
              label="description"
            ></textarea>
            <div v-if="errors.description">{{ errors.description }}</div>
          </div>

          <!-- <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 ml-4 mr-5 text-right w-36 font-bold"
              >Cash :</label
            >
            <input
              v-model="form.p_status"
              name="p_status"
              type="radio"
              value="0"
              class="pr-2 pb-2 rounded-md placeholder-indigo-300"
            />
            <label class="my-2 ml-6 mr-5 text-right w-42 font-bold"
              >Bank :</label
            >
            <input
              v-model="form.p_status"
              name="p_status"
              type="radio"
              value="1"
              class="pr-2 pb-2 rounded-md placeholder-indigo-300"
            />
          </div> -->
          <div
            v-if="form.cheque"
            class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap"
          >
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Cheque No :</label
            ><input
              type="number"
              v-model="form.cheque"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="date"
              placeholder="0"
            />
            <div v-if="errors.h_tax">{{ errors.h_tax }}</div>
          </div>

          <!-- <div
            v-if="form.p_status != 0"
            class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap"
          >
            <label class="my-2 ml-4 mr-5 text-right w-36 font-bold"
              >With Holding Tax :</label
            >
            <input
              v-model="form.t_status"
              name="t_status"
              type="radio"
              value="1"
              class="pr-2 pb-2 rounded-md placeholder-indigo-300"
            />

            <label class="my-2 ml-6 mr-5 text-right w-42 font-bold"
              >Without Holding Tax :</label
            >
            <input
              v-model="form.t_status"
              name="t_status"
              type="radio"
              value="0"
              class="pr-2 pb-2 rounded-md placeholder-indigo-300"
            />
          </div> -->

          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">Amount:</label
            ><input
              type="number"
              @change="cal_h_tax"
              v-model="form.amount"
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
            <div v-if="errors.amount">{{ errors.amount }}</div>
          </div>

          <!-- v-if="form.t_status != 0 && form.p_status != 0" -->
          <div
            v-if="form.h_tax != 0"
            class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap"
          >
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Holding Tax :</label
            ><input
              type="number"
              v-model="form.h_tax"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              readonly
              label="date"
              placeholder="0"
            />
            <div v-if="errors.h_tax">{{ errors.h_tax }}</div>
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
              Update Payment Voucher
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
    payment: Object,
    accounts: Array,
    account: Object,
  },

  data() {
    return {
      form: this.$inertia.form({
        date: this.payment.date,
        description: this.payment.description,
        account_id: this.account,
        document_id: this.payment.document_id,
        payee: this.payment.payee,
        cheque: this.payment.cheque,
        amount: this.payment.amount,
        h_tax: this.payment.h_tax,
        total: 0,
      }),
    };
  },

  methods: {
    cal_h_tax() {
      if (this.payment.h_tax != 0) {
        this.form.h_tax = parseInt((this.form.amount * 10) / 100).toFixed(2);
        this.form.amount = parseInt(this.form.amount - this.form.h_tax).toFixed(
          2
        );
      } else {
        this.form.h_tax = 0;
      }

      this.form.total = (
        parseInt(this.form.amount) + parseInt(this.form.h_tax)
      ).toFixed(2);
    },

    submit() {
      this.$inertia.put(route("payments.update", this.payment.id), this.form);
    },
  },
};
</script>
