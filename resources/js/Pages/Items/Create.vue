<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Create Item
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
        <form @submit.prevent="form.post(route('items.store'))">
          <div class="">
            <table class="shadow-lg border mt-4 mb-4 ml-12 rounded-xl w-11/12">
              <thead>
                <tr class="bg-indigo-100 text-black text-centre font-bold">
                  <th class="px-3 pt-3 pb-3 border">Item Name</th>
                  <th class="px-3 pt-3 pb-3 border">Description</th>
                  <th class="px-3 pt-3 pb-3 border">HS Code#</th>
                  <th class="px-3 pt-3 pb-3 border">Unit Type</th>
                  <th class="px-3 pt-3 pb-3 border">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in form.items" :key="item.id">
                  <td class="w-3/12">
                    <input
                      v-model="item.name"
                      type="text"
                      class="rounded-md w-full"
                    />
                  </td>
                  <td class="w-3/12">
                    <input
                      v-model="item.description"
                      type="text"
                      class="rounded-md w-full"
                    />
                  </td>
                  <td class="w-3/12">
                    <input
                      v-model="item.hscode"
                      type="text"
                      class="rounded-md w-full"
                    />
                  </td>
                  <td class="w-4/12 rounded-md">
                    <select v-model="item.unit_id" class="rounded-md w-full">
                      <option
                        v-for="unit in unittypes"
                        :key="unit.id"
                        :value="unit.id"
                      >
                        {{ unit.name }}
                      </option>
                    </select>
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
                        hover:text-white
                        hover:bg-red-600
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
              Add More Item
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

export default {
  components: {
    AppLayout,
  },

  props: {
    errors: Object,
    data: Object,
    unittypes: Object,
  },

  setup(props) {
    const form = useForm({
      items: [
        {
          name: null,
          description: null,
          hscode: null,
          unit_id: props.unittypes[0].id,
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
      this.form.items.push({
        name: null,
        description: null,
        hscode: null,
        unit_id: this.unittypes[0].id,
      });
    },

    deleteRow(index) {
      this.form.items.splice(index, 1);
    },
  },
};
</script>
