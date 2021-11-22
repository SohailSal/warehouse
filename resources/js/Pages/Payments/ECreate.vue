<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Create Expense
      </h2>
    </template>
    <div v-if="$page.props.flash.success" class="bg-yellow-600 text-white">
      {{ $page.props.flash.success }}
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
      <div class="">
        <form @submit.prevent="form.post(route('expenses.store'))">
          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Expense type :</label
            >
            <input
              type="text"
              v-model="form.name"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="name"
              placeholder="Enter name:"
            />
            <div v-if="errors.name">{{ errors.name }}</div>
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
              :disabled="form.processing"
              type="submit"
            >
              Create Expense
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
    group_first: Object,
  },

  setup(props) {
    const form = useForm({
      name: null,
    });

    return { form };
  },

  //   data() {
  //     return {
  //       form: this.$inertia.form({
  //         name: null,
  //         number: null,
  //         group: this.group_first.id,
  //       }),
  //     };
  //   },

  //   methods: {
  //     submit() {
  //       this.$inertia.post(route("accounts.store"), this.form);
  //     },
  //   },
};
</script>
