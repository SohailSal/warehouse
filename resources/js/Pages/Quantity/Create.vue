<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Create Quanitiy
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
        <form @submit.prevent="form.post(route('quantities.store'))">
          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Item Name:</label
            >
            <select
              v-model="form.item_id"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
            >
              <option v-for="item in items" :key="item.id" :value="item.id">
                {{ item.name }}
              </option>
            </select>
            <div v-if="errors.item_id">{{ errors.item_id }}</div>
          </div>
          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">Quantity:</label
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
              placeholder="Enter QTY."
            />
            <div v-if="errors.number">{{ errors.number }}</div>
          </div>
          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >file number:</label
            >
            <select
              v-model="form.file_id"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
            >
              <option v-for="file in files" :key="file.id" :value="file.id">
                {{ file.file_no }}
              </option>
            </select>
            <div v-if="errors.file_id">{{ errors.file_id }}</div>
          </div>
          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">Amount:</label>
            <select
              v-model="form.invoice_id"
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
              :disabled="form.processing"
            >
              Create Quanitiy
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

export default {
  components: {
    AppLayout,
  },

  props: {
    errors: Object,
    files: Object,
    items: Object,
    invoices: Object,
  },

  setup(props) {
    const form = useForm({
      item_id: props.items[0].id,
      number: null,
      file_id: props.files[0].id,
      invoice_id: props.invoices[0].id,
    });
    return { form };
  },
};
</script>
