<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Edit Transactions
      </h2>
    </template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
      <div class="">
        <form @submit.prevent="submit">
          <!--
        @submit.prevent="
          this.difference == 0 ? form.post(route('documents.store')) : ''
        "
        -->
          <!-- DOCUMENT TYPE ID -->
          <div class="p-2 mr-2 mb-2 ml-6 flex flex-wrap">
            <!-- <select
            v-model="form.type_id"
            class="pr-2 pb-2 w-full lg:w-1/4 rounded-md"
            label="voucher"
          >
            <option v-for="type in doc_types" :key="type.id" :value="type.id">
              {{ type.name }}
            </option>
          </select> -->
            <input
              type="text"
              v-model="document.type_name"
              class="
                pr-2
                pb-2
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="ref"
              placeholder="Enter Voucher"
              readonly
            />
            <div v-if="errors.type">{{ errors.type }}</div>
            <!-- </div> -->
            <!-- DESCRIPTION -->
            <!-- <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap"> -->
            <input
              type="text"
              v-model="document.ref"
              class="
                pr-2
                pb-2
                ml-6
                w-full
                lg:w-1/4
                rounded-md
                placeholder-indigo-300
              "
              label="ref"
              placeholder="Enter Refernce"
              readonly
            />
            <div v-if="errors.ref">{{ errors.ref }}</div>
          </div>
          <!-- DESCRIPTION -->
          <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
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
              placeholder="Enter Description"
            />
            <div v-if="errors.description">{{ errors.description }}</div>
            <!-- </div> -->
            <!-- DATE -->
            <!-- <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap"> -->
            <input
              type="date"
              v-model="form.date"
              class="pr-2 pb-2 ml-6 rounded-md placeholder-indigo-300"
              label="date"
              placeholder="Date:"
            />
            <!-- <datepicker
            v-model="form.date"
            class="pr-2 pb-2 w-full rounded-md placeholder-indigo-300"
            label="date"
            placeholder="Enter Date:"
          /> -->
            <div v-if="errors.date">{{ errors.date }}</div>
          </div>

          <!-- TABLE FOR ENTRIES ---- START ------------- -->
          <div class="panel-body">
            <button
              class="border bg-indigo-300 rounded-xl px-4 py-2 m-4"
              type="button"
              @click.prevent="addRow"
            >
              Add row
            </button>
            <div v-if="isError">{{ firstError }}</div>
            <table class="table border">
              <thead class="">
                <tr>
                  <th>Account:</th>
                  <th>Debit:</th>
                  <th>Credit:</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(entry, index) in form.entries" :key="entry.id">
                  <!-- <tr v-for="(entry, index) in entries" :key="entry.id"> -->
                  <td>
                    <select v-model="entry.account_id" class="rounded-md w-36">
                      <option
                        v-for="account in accounts"
                        :key="account.id"
                        :value="account.id"
                      >
                        {{ account.name }}
                      </option>
                    </select>
                  </td>
                  <td>
                    <input
                      v-model="entry.debit"
                      type="text"
                      @change="debitchange(index)"
                      class="rounded-md w-36"
                    />
                  </td>
                  <td>
                    <input
                      v-model="entry.credit"
                      type="text"
                      @change="creditchange(index)"
                      class="rounded-md w-36"
                    />
                  </td>
                  <td>
                    <button
                      @click.prevent="deleteRow(index)"
                      v-if="index > 1"
                      class="border bg-indigo-300 rounded-xl px-4 py-2 m-4"
                    >
                      Delete
                    </button>
                    <div v-else class="border rounded-xl px-4 py-2 m-4"></div>
                  </td>
                </tr>

                <tr>
                  <th>Difference:</th>
                  <th>Debit:</th>
                  <th>Credit:</th>
                </tr>

                <tr>
                  <td>
                    <input
                      type="text"
                      v-model="difference"
                      readonly
                      class="rounded-md w-36"
                    />
                  </td>
                  <td>
                    <input
                      type="text"
                      v-model="debit"
                      readonly
                      class="rounded-md w-36"
                    />
                  </td>
                  <td>
                    <input
                      type="text"
                      v-model="credit"
                      readonly
                      class="rounded-md w-36"
                    />
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- TABLE FOR ENTRIES ---- END ------------- -->

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
            >
              <!-- :disabled="form.processing" -->
              Update Transaction
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
// import Label from "../../Jetstream/Label.vue";
import Datepicker from "vue3-datepicker";
import format from "date-fns/format";

export default {
  components: {
    AppLayout,
    Datepicker,
    format,
  },

  props: {
    errors: Object,

    doc_types: Object,
    doc_type_first: Object,

    document: Object,
    entriess: Object,

    accounts: Object,
    account_first: Object,
  },

  // setup(props) {
  //   const form = useForm({
  //     type_id: props.doc_type_first.id,
  //     date: null,
  //     description: null,

  //     entries: [
  //       {
  //         account_id: props.accounts[0].id,
  //         debit: 0,
  //         credit: 0,
  //       },
  //       {
  //         account_id: props.accounts[0].id,
  //         debit: 0,
  //         credit: 0,
  //       },
  //     ],
  //   });

  //   return { form };
  // },

  data() {
    return {
      difference: 0,
      credit: 0,
      debit: 0,
      total: 0,
      //   count: entries.length,
      isError: null,
      form: this.$inertia.form({
        // entries: this.entries,
        type_id: this.document.type_id,
        date: this.document.date,
        description: this.document.description,

        entries: this.entriess,
        // []: this.entriess[],
        //   [
        // array.forEach((element) => {
        // array.forEach(
        //   (this.entriess = {
        //     account_id: entriess.account_id,
        //     debit: entriess.debit,
        //     credit: entriess.credit,
        //   })
        // ),
        //   {
        //     account_id: this.accounts[0].id,
        //     debit: 0,
        //     credit: 0,
        //   },
        //   //   {
        //   //     account_id: this.accounts[1].id,
        //   //     debit: 0,
        //   //     credit: 0,
        //   //   },
        //   ],
      }),
    };
  },

  methods: {
    submit() {
      //   entries = this.entries;
      if (this.difference === 0) {
        this.$inertia.put(
          route("documents.update", this.document.id),
          this.form
        );
      } else {
        alert("Entry is not equal");
      }
    },
    //ON CHANGE FUNCTION ON DEBIT CREDIT TO NULL THE PARALLEL VALUES ---START ----
    debitchange(index) {
      let a = this.form.entries[index];
      a.credit = 0;
      console.log(a.debit);

      this.tdebit();
      this.tcredit();
    },
    creditchange(index) {
      let b = this.form.entries[index];
      b.debit = 0;
      console.log(b.credit);

      this.tcredit();
      this.tdebit();
    },
    //ON CHANGE FUNCTION ON DEBIT CREDIT TO NULL THE PARALLEL VALUES --- END ----

    // CALCULATING TOTAL AMOUNT OF DEBIT AND CREDIT ----START ----------------
    tcredit() {
      let dtotal = 0;
      for (var i = 0; i < this.form.entries.length; i++) {
        dtotal = dtotal + parseInt(this.form.entries[i].credit);
      }
      this.credit = dtotal;
    },
    tdebit() {
      let dtotal = 0;
      for (var i = 0; i < this.form.entries.length; i++) {
        dtotal = dtotal + parseInt(this.form.entries[i].debit);
      }
      this.debit = dtotal;
    },
    // CALCULATING TOTAL AMOUNT OF DEBIT AND CREDIT ---- END ----------------

    //TO CHECK THAT THE DEBIT CREDIT ARE NOT ZERO --------------- STARTS ------------------
    checkingZero() {
      for (var i = 0; i < this.form.entries.length; i++) {
        if (
          this.form.entries[i].credit == 0 &&
          this.form.entries[i].debit == 0
        ) {
          this.difference = null;
          alert("Please fill debit OR credit field of a Transaction");
        }
      }
    },
    //TO CHECK THAT THE DEBIT CREDIT ARE NOT ZERO --------------- END ------------------

    addRow() {
      this.form.entries.push({
        // account_id: this.account_first.id,
        account_id: this.accounts[0].id,
        debit: 0,
        credit: 0,
      });
      this.difference = null;

      count += 1;
      console.log(count);
    },
    deleteRow(index) {
      this.form.entries.splice(index, 1);
      this.tcredit();
      this.tdebit();
      //   this.creditchange(index);
      //   this.debitchange(index);
    },
  },
  mount: {
    // tcredit() {
    //   let dtotal = 0;
    //   for (var i = 0; i < this.form.entries.length; i++) {
    //     dtotal = dtotal + parseInt(this.form.entries[i].credit);
    //   }
    //   this.credit = dtotal;
    // },
    // tdebit() {
    //   let dtotal = 0;
    //   for (var i = 0; i < this.form.entries.length; i++) {
    //     dtotal = dtotal + parseInt(this.form.entries[i].debit);
    //   }
    //   this.debit = dtotal;
    // },
  },
  watch: {
    //  FOR DIFFERENCE OF DEBIT CREDIT ---START -----
    debit: function () {
      this.checkingZero();
      let diff = 0;
      if (this.debit == 0 && this.credit == 0) {
        this.difference = null;
      } else {
        diff = parseInt(this.debit) - parseInt(this.credit);
        this.difference = diff;
      }
    },
    credit: function () {
      this.checkingZero();

      let diff = 0;
      console.log(this.credit);
      if (this.debit == 0 && this.credit == 0) {
        this.difference = null;
      } else {
        diff = parseInt(this.debit) - parseInt(this.credit);
        this.difference = diff;
      }
    },
    //  FOR DIFFERENCE OF DEBIT CREDIT --- END -----
  },
};
</script>
