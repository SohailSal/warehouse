<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Create Receipt
      </h2>
    </template>
    <div
      v-if="$page.props.flash.success"
      class="bg-yellow-600 text-white text-center"
    >
      {{ $page.props.flash.success }}
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
      <div class="">
        <form @submit.prevent="form.post(route('receipts.store'))">
          <!-- <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Client Name:</label
            >
            <select
              v-model="form.client_id"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
            >
              <option
                v-for="client in clients"
                :key="client.id"
                :value="client.id"
              >
                {{ client.name }}
              </option>
            </select>
            <div v-if="errors.client_id">{{ errors.client_id }}</div>
          </div> -->

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

          <div class="p-2 mr-2 mb-2 ml-6 flex flex-wrap">
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
            ></multiselect>
            <!-- @update:model-value="updateSelected" -->
            <div v-if="errors.file_id">{{ errors.file_id }}</div>
          </div>

          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 ml-4 mr-8 text-right w-36 font-bold"
              >Without Incl. Tax :</label
            >
            <input
              v-model="form.status"
              name="status"
              type="radio"
              value="0"
              class="pr-2 pb-2 rounded-md placeholder-indigo-300"
            />

            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Include Tax :</label
            >
            <input
              v-model="form.status"
              name="status"
              type="radio"
              value="1"
              class="pr-2 pb-2 rounded-md placeholder-indigo-300"
            />

            <label class="my-2 mr-8 text-right w-24 font-bold">None :</label>
            <input
              v-model="form.status"
              name="status"
              type="radio"
              value="2"
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
            v-if="form.status != 2"
            class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap"
          > -->
            <label
              v-if="form.status != 2"
              class="my-2 mr-8 text-right w-36 font-bold"
              >Invoice Tax:</label
            ><input
              v-if="form.status != 2"
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

            <div v-if="errors.i_tax">{{ errors.i_tax }}</div>
          </div>
          <div class="ml-52" v-if="errors.amount">{{ errors.amount }}</div>

          <!--
          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">Sales Tax:</label
            ><input
              type="number"
              v-model="form.s_tax"
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
          </div> -->

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
              :disabled="form.processing"
            >
              Create Receipt
            </button>
          </div>
        </form>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import { useForm } from "@inertiajs/inertia-vue3";
import Multiselect from "@suadelabs/vue3-multiselect";

export default {
  components: {
    AppLayout,
    Multiselect,
  },

  props: {
    errors: Object,
    files: Object,
  },

  setup(props) {
    const form = useForm({
      status: 0,
      total: null,
      file_id: props.files[0],

      date: new Date().toISOString().substr(0, 10),
      amount: null,
      i_tax: null,
      s_tax: null,
      com: null,
    });
    return { form };
  },
  methods: {
    cal_i_tax() {
      if (this.form.status == 2) {
        this.form.i_tax = 0;
        console.log("value 2");
      } else if (this.form.status == 0) {
        this.form.i_tax = parseInt((this.form.amount * 13) / 100).toFixed(2);
        console.log(this.form.i_tax);
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
