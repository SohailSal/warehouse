<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Edit File
      </h2>
    </template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
      <div class="">
        <form @submit.prevent="submit">
          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">File No :</label>
            <input
              type="text"
              v-model="form.file_no"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="file_no"
              placeholder="Enter File No :"
            />
            <div v-if="errors.file_no">{{ errors.file_no }}</div>
          </div>

          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">GD No :</label>
            <input
              type="text"
              v-model="form.gd_no"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="gd_no"
              placeholder="Enter GD No :"
            />
            <div v-if="errors.gd_no">{{ errors.gd_no }}</div>
          </div>

          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">Bond No :</label>
            <input
              type="text"
              v-model="form.bond_no"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="bond_no"
              placeholder="Enter Bond No :"
            />
            <div v-if="errors.bond_no">{{ errors.bond_no }}</div>
          </div>

          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Date Bond :</label
            >
            <input
              type="text"
              v-model="form.date_bond"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="bond_no"
              placeholder="Enter Date Bond :"
            />
            <div v-if="errors.date_bond">{{ errors.date_bond }}</div>
          </div>

          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Description :</label
            >
            <input
              type="text"
              v-model="form.description"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="description"
              placeholder="Enter Description :"
            />
            <div v-if="errors.description">{{ errors.description }}</div>
          </div>

          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">Vessel :</label>
            <input
              type="text"
              v-model="form.vessel"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="vessel"
              placeholder="Enter Vessel :"
            />
            <div v-if="errors.vessel">{{ errors.vessel }}</div>
          </div>

          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Gross Weight :</label
            >
            <input
              type="text"
              v-model="form.gross_wt"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="gross_wt"
              placeholder="Enter Gross Weight :"
            />
            <div v-if="errors.gross_wt">{{ errors.gross_wt }}</div>
          </div>

          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Net Weight :</label
            >
            <input
              type="text"
              v-model="form.net_wt"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="net_wt"
              placeholder="Enter Net Weight :"
            />
            <div v-if="errors.net_wt">{{ errors.net_wt }}</div>
          </div>

          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">BL No :</label>
            <input
              type="text"
              v-model="form.bl_no"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="bl_no"
              placeholder="Enter BL No :"
            />
            <div v-if="errors.bl_no">{{ errors.bl_no }}</div>
          </div>

          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Insurance :</label
            >
            <input
              type="text"
              v-model="form.insurance"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="insurance"
              placeholder="Enter Insurance :"
            />
            <div v-if="errors.insurance">{{ errors.insurance }}</div>
          </div>

          <div class="p-2 mr-2 mb-2 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Select Agent :</label
            >
            <multiselect
              style="width: 25%"
              class="rounded-md border border-black"
              v-model="form.agent_id"
              :options="agents"
              placeholder="Select Agent"
              label="name"
              track-by="id"
            ></multiselect>
            <div v-if="errors.agent_id">{{ errors.agent_id }}</div>
          </div>

          <div class="p-2 mr-2 mb-2 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Select Importer :</label
            >
            <multiselect
              style="width: 25%"
              class="rounded-md border border-black"
              v-model="form.importer_id"
              :options="importers"
              placeholder="Select Importer"
              label="name"
              track-by="id"
            ></multiselect>
            <div v-if="errors.importer_id">{{ errors.importer_id }}</div>
          </div>

          <div class="p-2 mr-2 mb-2 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Select Client :</label
            >
            <multiselect
              style="width: 25%"
              class="rounded-md border border-black"
              v-model="form.client_id"
              :options="clients"
              placeholder="Select Client"
              label="name"
              track-by="id"
            ></multiselect>
            <div v-if="errors.client_id">{{ errors.client_id }}</div>
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
              Update File
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
import Multiselect from "@suadelabs/vue3-multiselect";

export default {
  components: {
    AppLayout,
    Multiselect,
  },

  props: {
    errors: Object,
    file: Object,

    agents: Array,
    importers: Array,
    clients: Array,
  },

  data() {
    return {
      agents: this.agents,
      importers: this.importers,
      clients: this.clients,

      form: this.$inertia.form({
        file_no: this.file.file_no,
        gd_no: this.file.gd_no,
        bond_no: this.file.bond_no,
        date_bond: this.file.date_bond,
        description: this.file.description,
        vessel: this.file.vessel,
        gross_wt: this.file.gross_wt,
        net_wt: this.file.net_wt,
        bl_no: this.file.bl_no,
        insurance: this.file.insurance,
        agent_id: this.file.agent_id,
        importer_id: this.file.importer_id,
        client_id: this.file.client_id,
      }),
    };
  },

  methods: {
    submit() {
      this.$inertia.put(route("files.update", this.file.id), this.form);
    },
  },
};
</script>
