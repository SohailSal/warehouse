<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Edit Supplier
      </h2>
    </template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
      <div class="">
        <form @submit.prevent="submit">
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
              placeholder="Enter name:"
            />
            <div
              class="
                ml-2
                text-center
                bg-red-100
                border border-red-400
                text-red-700
                px-4
                py-2
                rounded
                relative
              "
              role="alert"
              v-if="errors.name"
            >
              {{ errors.name }}
            </div>
          </div>

          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">Email :</label>
            <input
              type="email"
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
              placeholder="Enter Email:"
            />
            <div
              class="
                ml-2
                text-center
                bg-red-100
                border border-red-400
                text-red-700
                px-4
                py-2
                rounded
                relative
              "
              role="alert"
              v-if="errors.email"
            >
              {{ errors.email }}
            </div>
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
            <label class="my-2 mr-8 text-right w-36 font-bold">STN No :</label>
            <input
              type="text"
              v-model="form.stn_no"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="stn_no"
              placeholder="Enter STN No :"
            />
            <div v-if="errors.stn_no">{{ errors.stn_no }}</div>
          </div>

          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Phone No :</label
            >
            <input
              type="text"
              v-model="form.phone_no"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="phone"
              placeholder="Enter Phone no:"
            />
            <div v-if="errors.phone_no">{{ errors.phone_no }}</div>
          </div>

          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">NTN No :</label>
            <input
              type="text"
              v-model="form.ntn_no"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="ntn_no"
              placeholder="Enter NTN No :"
            />
            <div v-if="errors.ntn_no">{{ errors.ntn_no }}</div>
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
              Update Supplier
            </button>
          </div>
        </form>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Label from "../../Jetstream/Label.vue";

export default {
  components: {
    AppLayout,
  },

  props: {
    errors: Object,
    supplier: Object,
  },

  data() {
    return {
      form: this.$inertia.form({
        name: this.supplier.name,
        email: this.supplier.email,
        address: this.supplier.address,
        stn_no: this.supplier.stn_no,
        phone_no: this.supplier.phone_no,
        ntn_no: this.supplier.ntn_no,
        account_id: this.supplier.account_id,
      }),
    };
  },

  methods: {
    submit() {
      this.$inertia.put(route("suppliers.update", this.supplier.id), this.form);
    },
  },
};
</script>
