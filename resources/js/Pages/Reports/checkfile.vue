<template>
  <div class="bg-gray-100 shadow mx-auto lg:max-w-4xl">
    <form @submit.prevent="submit" action="range" ref="form">
      <div class="p-5">
        <label for="param">Enter your name:</label>
        <input type="text" name="param" class="px-2 ml-2 rounded-lg border" />
        <button
          type="submit"
          class="
            px-2
            py-1
            ml-2
            rounded-lg
            border
            bg-gray-500
            text-white
            hover:bg-black
          "
        >
          Generate PDF
        </button>
      </div>
    </form>
    <!-- <table class="w-full">
      <tr class="bg-gray-900 text-white">
        <th class="px-2 py-1 text-sm font-bold text-left">ID</th>
        <th class="px-2 py-1 text-sm font-bold text-left">Name</th>
        <th class="px-2 py-1 text-sm font-bold text-left">Email</th>
      </tr>
      <tr
        v-for="(user, index) in users"
        :key="index"
        :class="{ 'bg-gray-300': index % 2 === 0 }"
      >
        <td class="px-2 py-1 text-sm text-left">{{ user.id }}</td>
        <td class="px-2 py-1 text-sm text-left">{{ user.name }}</td>
        <td class="px-2 py-1 text-sm text-left">{{ user.email }}</td>
      </tr>
    </table> -->
  </div>
</template>

<script>
export default {
  props: {
    users: Object,
  },
  methods: {
    submit: function () {
      this.$refs.form.submit();
    },
  },
};
</script>
