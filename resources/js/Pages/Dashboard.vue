<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard - {{ this.$page.props.co_id }} - {{ this.$page.props.yr_id }}
      </h2>
      <!-- <div
        class="px-4 py-2 bg-gray-100 border-t border-gray-200 flex justify-start items-center"
      > -->
      <!-- <button
        class="border bg-indigo-300 rounded-xl px-4 py-2 ml-4 mt-4"
        type="button"
        v-on="route()"
      >
        Generate PDF
      </button> -->
      <!-- :disabled="form.processing" -->
      <!-- </div> -->
    </template>
    <div v-if="$page.props.flash.warning" class="bg-yellow-600 text-white">
      {{ $page.props.flash.warning }}
    </div>
    <div v-if="$page.props.flash.success" class="bg-green-600 text-white">
      {{ $page.props.flash.success }}
    </div>

    <!-- ---------------------------------------------------------------------------- - - -->
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div
          class="
            bg-gray-700
            text-white text-3xl
            p-2
            overflow-hidden
            shadow-xl
            sm:rounded-lg
          "
        >
          Welcome to MZ ERP
        </div>

        <!-- <welcome /> -->
        <!-- v-if="can['edit']" -->
        <div
          class="
            inline-flex
            py-2
            px-4
            bg-gray-800
            text-white
            m-4
            rounded-lg
            shadow-lg
            overflow-auto
            md:w-1/2
          "
        >
          <!-- <form method="GET" action="https://sa.com.pk/dashboard"> -->
          <form @submit.prevent="form.post(route('dashboard.roleassign'))">
            <!-- <input
              type="hidden"
              name="_token"
              value="XuypUXXROQ6QQNxAGf4fsWaWfUPUJm3PXQyIbKSV"
            /> -->
            <div class="flex-col m-2">
              <h3>Assign usage rights to another user</h3>
            </div>
            <div class="flex-col m-2">
              <label class="inline-flex text-white mb-2 w-20">Email:</label>
              <input
                type="text"
                v-model="form.email"
                class="
                  bg-gray-600
                  text-white
                  rounded
                  focus:outline-none
                  focus:shadow-outline
                  px-1
                  hover:text-blue-200
                  w-52
                "
                label="email"
                placeholder="Enter Email of User"
              />
              <div v-if="errors.email">{{ errors.email }}</div>
            </div>
            <!-- <div class="flex-col m-2">`  1
              <label class="inline-flex text-white mb-2 w-20">Company:</label>
              <select
                v-model="form.company_id"
                class="
                  w-52
                  bg-gray-600
                  text-white
                  rounded
                  leading-tight
                  focus:outline-none
                  focus:shadow-outline
                "
                label="company"
                placeholder="Select Company"
              >
                <option
                  v-for="company in companies"
                  :key="company.id"
                  :value="company.id"
                >
                  {{ company.name }}
                </option>
              </select>
            </div> -->
            <!-- <div class="flex-col m-2">
              <label class="inline-flex text-white mb-2 w-20">Role:</label>
              <select
                v-model="form.role"
                class="
                  sadkjn@gmail.com
                  w-52sadkjn@gmail.com
                  bg-gray-600
                  text-white
                  rounded
                  leading-tight
                  focus:outline-none
                  focus:shadow-outline
                "
                label="role"
                placeholder="Select Role"
              >
                <option :value="role.id" v-for="role in roles" :key="role.id">
                  {{ role.name }}
                </option>
              </select>
            </div> -->
            <div class="flex-col m-2">
              <button
                class="
                  flex-wrap
                  mb-2
                  ml-20
                  px-4
                  py-1
                  rounded-lg
                  bg-gray-600
                  text-white
                  hover:bg-gray-700
                  focus:outline-none
                  focus:shadow-outline
                "
                type="submit"
                :disabled="form.processing"
              >
                Assign
              </button>
            </div>
          </form>
        </div>
        <!-- <div v-if="$page.props.flash.success" class="bg-yellow-600 text-white">
          {{ $page.props.flash.success }}
        </div>
        <div class="">
          <form @submit.prevent="form.post(route('accountgroups.store'))">
            <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
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
                placeholder="Enter Email of User:"
              />
              <div v-if="errors.name">{{ errors.name }}</div>
            </div>

            <select
              v-model="co_id"
              class="pr-2 ml-2 pb-2 w-full lg:w-1/4 rounded-md"
              label="company"
              placeholder="Select Company"
              @change="coch"
            >
              <option v-for="type in companies" :key="type.id" :value="type.id">
                {{ type.name }}
              </option>
            </select>

            <div class="p-2 mr-2 mb-2 ml-6 flex flex-wrap">
              <select
                v-model="form.type"
                class="pr-2 pb-2 w-full lg:w-1/4 rounded-md"
                label="type"
                placeholder="Enter type"
              >
                <option v-for="type in types" :key="type.id" :value="type.id">
                  {{ type.name }}
                </option>
              </select>
              <div v-if="errors.type">{{ errors.type }}</div>
            </div>
            <div class="p-2 mr-2 mb-2 ml-6 flex flex-wrap">
              <select
                v-model="form.role"
                class="pr-2 pb-2 w-full lg:w-1/4 rounded-md"
                label="type"
                placeholder="Enter type"
              >
                <option selected value="0">Select Role</option>
                <option value="Manager">Manager</option>
                <option value="Read Only">Read Only</option>
                <option v-for="type in types" :key="type.id" :value="type.id">
                  {{ type.name }}
                </option>
              </select>
              <div v-if="errors.type">{{ errors.type }}</div>
            </div>

            <div
              class="
                px-4
                py-2
                bg-gray-100
                border-t border-gray-200
                flex
                justify-start
                items-center
              "
            >
              <button
                class="border bg-indigo-300 rounded-xl px-4 py-2 ml-4 mt-4"
                type="submit"
                :disabled="form.processing"
              >
                Assign
              </button>
            </div>
          </form>
        </div> -->
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Welcome from "@/Jetstream/Welcome";
import { useForm } from "@inertiajs/inertia-vue3";

export default {
  components: {
    AppLayout,
    Welcome,
  },

  props: {
    errors: Object,
    companies: Object,
    // roles: Object,
    // can: Object,

    // types: Object,
    // first: Object,
  },
  setup(props) {
    const form = useForm({
      email: null,
      // company_id: props.companies[0].id,
      // role: props.roles[0].id,
    });

    return { form };
  },
  mounted: function () {
    console.log(this.$page.props.co_id);
    console.log(this.$page.props.yr_id);
  },

  methods: {
    coch() {
      this.$inertia.get(route("companies.coch", this.co_id));
    },
    // route() {
    //   // this.$inertia.post(route("companies.store"), this.form);
    //   this.$inertia.get(route("pd"));
    // },
  },
};
</script>
