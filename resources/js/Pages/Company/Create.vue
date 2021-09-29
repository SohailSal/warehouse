<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Create Company
      </h2>
    </template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
      <div class="">
        <form @submit.prevent="form.post(route('companies.store'))">
          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">Name :</label>
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
              placeholder="Enter Company name:"
            />
            <div v-if="errors.name">{{ errors.name }}</div>
          </div>

          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">Address :</label>
            <input
              type="text"
              v-model="form.address"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="address"
              placeholder="Enter address:"
            />
            <div v-if="errors.address">{{ errors.address }}</div>
          </div>

          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">Email :</label>
            <input
              type="text"
              v-model="form.email"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="email"
              placeholder="Enter email:"
            />
            <div v-if="errors.email">{{ errors.email }}</div>
          </div>

          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Web Address :</label
            >
            <input
              type="text"
              v-model="form.web"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="website"
              placeholder="Enter web address:"
            />
            <div v-if="errors.web">{{ errors.website }}</div>
          </div>

          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Phone No :</label
            >
            <input
              type="text"
              v-model="form.phone"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="phone"
              placeholder="Enter phone no:"
            />
            <div v-if="errors.phone">{{ errors.phone }}</div>
          </div>
          <div class="p-2 mr-2 mb-2 ml-6 flex flex-wrap">
            <label class="my-2 text-right w-36 mr-8 font-bold">Fiscal :</label>
            <select
              v-model="form.fiscal"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="ficsal"
              placeholder="Select Fiscal:"
            >
              <option v-for="fiscal in fiscals" :key="fiscal" :value="fiscal">
                {{ fiscal }}
              </option>
            </select>
            <div v-if="errors.fiscal">{{ errors.fiscal }}</div>
          </div>
          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">Incorp :</label>
            <input
              type="date"
              v-model="form.incorp"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="incorp"
              placeholder="Enter Incorp:"
            />
            <div v-if="errors.incorp">{{ errors.incorp }}</div>
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
              Create Company
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
    fiscals: Object,
    fiscal_first: Object,
  },

  setup(props) {
    const form = useForm({
      name: null,
      address: null,
      email: null,
      web: null,
      phone: null,
      fiscal: props.fiscal_first,
      incorp: null,
    });
    return { form };
  },

  //   data() {
  //     return {
  //       form: this.$inertia.form({
  //         name: null,
  //         address: null,
  //         email: null,
  //         website: null,
  //         phone: null,
  //         fiscal: this.fiscal_first,
  //         incorp: null,
  //       }),
  //     };
  //   },

  //   methods: {
  //     submit() {
  //       this.$inertia.post(route("companies.store"), this.form);
  //     },
  //   },
};
</script>
