<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Create File
      </h2>
    </template>
    <div
      v-if="$page.props.flash.warning"
      class="bg-yellow-600 text-white text-center"
    >
      {{ $page.props.flash.warning }}
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
      <div class="">
        <form @submit.prevent="form.post(route('files.store'))">
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
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >File Code :</label
            >
            <input
              type="text"
              v-model="form.file_code"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="file_code"
              placeholder="Enter File Code :"
            />
            <div v-if="errors.file_code">{{ errors.file_code }}</div>
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
              type="date"
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
            <label class="my-2 mr-8 text-right w-36 font-bold">VIR No :</label>
            <input
              type="text"
              v-model="form.vir_no"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="vir_no"
              placeholder="Enter VIR No :"
            />
            <div v-if="errors.vir_no">{{ errors.vir_no }}</div>
          </div>

          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Index No :</label
            >
            <input
              type="text"
              v-model="form.index_no"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="index_no"
              placeholder="Enter Index No :"
            />
            <div v-if="errors.index_no">{{ errors.index_no }}</div>
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

          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">LC No :</label>
            <input
              type="text"
              v-model="form.lc_no"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="lc_no"
              placeholder="Enter LC No :"
            />
            <div v-if="errors.lc_no">{{ errors.lc_no }}</div>
          </div>
          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Include Tax :</label
            >
            <!-- v-model="form.qty" -->
            <input
              v-model="form.status"
              name="status"
              type="radio"
              value="1"
              class="pr-2 pb-2 rounded-md placeholder-indigo-300"
            />
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Without Incl. Tax :</label
            >
            <!-- v-model="form.qty" -->
            <input
              v-model="form.status"
              name="status"
              type="radio"
              value="0"
              class="pr-2 pb-2 rounded-md placeholder-indigo-300"
            />
            <div v-if="errors.qty">{{ errors.qty }}</div>
          </div>
          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold">Amount :</label>
            <input
              type="number"
              @change="cal_s_tax"
              v-model="form.amount"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="amount"
              placeholder="Enter Amount :"
            />
            <div v-if="errors.amount">{{ errors.amount }}</div>
          </div>

          <div
            v-if="form.status == 0"
            class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap"
          >
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Sale Tax :</label
            >
            <input
              type="number"
              v-model="form.s_tax"
              readonly
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="s_tax"
              placeholder="Sale Tax :"
            />
            <div v-if="errors.s_tax">{{ errors.s_tax }}</div>
          </div>

          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
            <label class="my-2 mr-8 text-right w-36 font-bold"
              >Quantity :</label
            >
            <input
              type="number"
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
              placeholder="Enter Quantity :"
            />
            <div v-if="errors.qty">{{ errors.qty }}</div>
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
              :disabled="form.processing"
            >
              Create File
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

    agents: Array,
    importers: Array,
    clients: Array,
  },

  data() {
    return {
      agents: this.agents,
      importers: this.importers,
      clients: this.clients,
    };
  },

  setup(props) {
    const form = useForm({
      status: null,
      file_no: null,
      file_code: null,
      gd_no: null,
      bond_no: null,
      date_bond: new Date().toISOString().substr(0, 10),
      description: null,
      vessel: null,
      gross_wt: null,
      net_wt: null,
      bl_no: null,
      vir_no: null,
      index_no: null,
      insurance: null,
      lc_no: null,
      amount: null,
      s_tax: null,
      qty: null,
      agent_id: null,
      importer_id: null,
      client_id: null,
    });
    return { form };
  },

  methods: {
    cal_s_tax() {
      this.form.s_tax = ((this.form.amount * 13) / 100).toFixed(2);
    },
  },
};
</script>
