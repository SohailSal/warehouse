<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Edit Delivery
      </h2>
    </template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
      <div class="">
        <form @submit.prevent="submit">
          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">Date :</label
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
              label="name"
            />
            <div v-if="errors.date">{{ errors.date }}</div>
          </div>
          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >File Name :</label
            >
            <multiselect
              class="rounded-md border border-black"
              v-model="form.file_id"
              :options="files"
              placeholder="Select file"
              label="file_no"
              track-by="id"
              style="width: 25%"
            ></multiselect>
            <div v-if="errors.file_id">{{ errors.file_id }}</div>
          </div>

          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">Cash No :</label
            ><input
              type="text"
              v-model="form.Cash_no"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="Cash_no"
            />
            <div v-if="errors.Cash_no">{{ errors.Cash_no }}</div>
          </div>
          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Vehicle No :</label
            ><input
              type="text"
              v-model="form.Vehicle_no"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="hscode"
            />
            <div v-if="errors.Vehicle_no">{{ errors.Vehicle_no }}</div>
          </div>
          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Item Name :</label
            >
            <multiselect
              class="rounded-md border border-black"
              v-model="form.item_id"
              :options="items"
              placeholder="Select Item"
              label="name"
              track-by="id"
              style="width: 25%"
            ></multiselect>
            <div v-if="errors.item_id">{{ errors.item_id }}</div>
          </div>

          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">Quantity :</label
            ><input
              type="text"
              v-model="form.qty"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="qty"
            />
            <div v-if="errors.qty">{{ errors.qty }}</div>
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
              Update Delivery
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
    delivery: Object,
    items: Array,
    files: Array,
    items_first: Object,
    file_first: Object,
  },

  data() {
    return {
      files: this.files,
      items: this.items,
      form: this.$inertia.form({
        date: this.delivery.date,
        file_id: this.file_first,
        Cash_no: this.delivery.Cash_no,
        Vehicle_no: this.delivery.Vehicle_no,
        item_id: this.items_first,
        qty: this.delivery.qty,
      }),
    };
  },

  methods: {
    submit() {
      this.$inertia.put(
        route("deliveries.update", this.delivery.id),
        this.form
      );
    },
  },
};
</script>
