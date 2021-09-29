<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Years</h2>
    </template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
      <div v-if="$page.props.flash.success" class="bg-green-600 text-white">
        {{ $page.props.flash.success }}
      </div>
      <!-- <jet-button @click="create" class="mt-4 ml-8">Create</jet-button> -->

      <form @submit.prevent="form.get(route('years.create'))">
        <jet-button type="submit" @click="create" class="mt-4 ml-2"
          >Add Year</jet-button
        >

        <!-- <button
          class="border bg-indigo-300 rounded-xl px-4 py-1 m-1 ml-2 mt-4"
          type="submit"
          :disabled="form.processing"
        >
          Add Year
        </button> -->
        <select
          v-model="co_id"
          class="pr-2 ml-2 pb-2 w-full lg:w-1/4 rounded-md float-right mt-2"
          label="company"
          @change="coch"
        >
          <option v-for="type in companies" :key="type.id" :value="type.id">
            {{ type.name }}
          </option>
        </select>
        <!-- <div v-if="errors.type">{{ errors.type }}</div> -->
        <div class="">
          <table class="w-full shadow-lg border mt-4 ml-2 rounded-xl">
            <thead>
              <tr class="bg-indigo-100">
                <th class="py-2 px-4 border">Company</th>
                <th class="py-2 px-4 border">Begin</th>
                <th class="py-2 px-4 border">End</th>
                <th class="py-2 px-4 border">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in data" :key="item.id">
                <td class="py-1 px-4 border w-2/5">
                  {{ item.company_name }}
                </td>
                <td class="py-1 px-4 border text-center">{{ item.begin }}</td>
                <td class="py-1 px-4 border text-center">{{ item.end }}</td>
                <td class="py-1 px-4 border text-center">
                  <button
                    class="border bg-indigo-300 rounded-xl px-4 py-1 m-1"
                    @click="edit(item.id)"
                    type="button"
                  >
                    <span>Edit</span>
                  </button>
                  <button
                    class="border bg-red-500 rounded-xl px-4 py-1 m-1"
                    @click="destroy(item.id)"
                    type="button"
                    v-if="item.delete"
                  >
                    <span>Delete</span>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </form>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import JetButton from "@/Jetstream/Button";
import { useForm } from "@inertiajs/inertia-vue3";

export default {
  components: {
    AppLayout,
    JetButton,
    useForm,
  },

  props: ["data", "companies"],

  data() {
    return {
      co_id: this.$page.props.co_id,
    };
  },

  setup(props) {
    const form = useForm({});
    return { form };
  },

  methods: {
    create() {
      this.$inertia.get(route("years.create"));
    },

    edit(id) {
      this.$inertia.get(route("years.edit", id));
    },

    destroy(id) {
      this.$inertia.delete(route("years.destroy", id));
    },
    coch() {
      this.$inertia.get(route("companies.coch", this.co_id));
    },
  },
};
</script>
