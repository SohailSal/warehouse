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

    <div class="max-w-7xl mx-auto pb-2">
      <div class="relative mt-5 flex-row border-t border-b border-gray-200">
        <div v-if="isError">{{ firstError }}</div>
        <form @submit.prevent="form.post(route('quantities.store'))">
          <div class="">
            <table class="shadow-lg border mt-4 mb-4 ml-12 rounded-xl w-11/12">
              <thead>
                <tr class="bg-indigo-100 text-black text-centre font-bold">
                  <th class="px-3 pt-3 pb-3 border">Select Item</th>
                  <th class="px-3 pt-3 pb-3 border">Quantity</th>
                  <th class="px-3 pt-3 pb-3 border">Select File</th>
                  <th class="px-3 pt-3 pb-3 border">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in form.quantities" :key="item.id">
                  <td class="w-4/12">
                    <multiselect
                      style="width: 99%"
                      class="rounded-md border border-black"
                      v-model="item.item_id"
                      :options="items"
                      placeholder="Select Item"
                      label="name"
                      track-by="id"
                    ></multiselect>
                  </td>
                  <td class="w-4/12">
                    <input
                      style="width: 100%"
                      type="number"
                      v-model="item.qty"
                      class="rounded-md w-full"
                      placeholder="Enter QTY."
                    />
                  </td>
                  <td class="w-4/12">
                    <multiselect
                      style="width: 99%"
                      class="rounded-md border border-black"
                      v-model="item.file_id"
                      :options="files"
                      placeholder="Select File"
                      label="file_no"
                      track-by="id"
                    ></multiselect>
                  </td>

                  <td>
                    <button
                      type="button"
                      @click.prevent="deleteRow(index)"
                      class="
                        border
                        bg-red-500
                        rounded-xl
                        px-4
                        py-2
                        m-1
                        hover:text-white hover:bg-red-600
                      "
                    >
                      Delete
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div
            class="
              relative
              mt-5
              mb-5
              ml-7
              flex-row
              bg-gray-100
              justify-start
              items-center
            "
          >
            <button
              class="border bg-indigo-300 rounded-xl px-4 py-1 m-1"
              type="button"
              @click.prevent="addRow"
            >
              Add More Quantity
            </button>

            <button
              type="submit"
              class="border bg-indigo-300 rounded-xl px-6 py-1 m-1"
              :disabled="form.processing"
            >
              Save
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
    items: Object,
    invoices: Object,
  },

  setup(props) {
    const form = useForm({
      quantities: [
        {
          item_id: null,
          qty: null,
          file_id: null,
          invoice_id: null,
        },
      ],
    });
    return { form };
  },
  watch: {
    errors: function () {
      if (this.errors) {
        this.firstError = this.errors[Object.keys(this.errors)[0]];
        this.isError = true;
      }
    },
  },
  methods: {
    addRow() {
      this.form.quantities.push({
        item_id: null,
        qty: null,
        file_id: null,
        invoice_id: null,
      });
    },

    deleteRow(index) {
      this.form.quantities.splice(index, 1);
    },
  },
};
</script>
