
<template>
  <div class="container">
    

    <div class="center">
      <h1>Add Expense</h1>
      <table>
      <thead>
        <tr>
          <th>Total Balance</th>
          <th>Date</th>
          <th>Exp name</th>
          <th>Exp amount</th>
          <th>Image</th>
          <th >Add Expense</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{{ singlewallet }}</td>
          <td> <input
            type="date"
            name="Expensedate"
            id="Expensedate"
            placeholder="Expense date"
          /></td>
          <td> <input
            type="text"
            name="expense_name"
            id="expense_name"
            placeholder="Expense Name"
          /></td>
          <td><input
            type="number"
            name="expense_amount"
            id="expense_amount"
            placeholder="Expense amount"
          /></td>
          <td><input type="file" name="image" id="image" /></td>
          <td >
           <button v-on:click="postExpense()">Save</button>
          </td>

        </tr>
      </tbody>
    </table>
    </div>

    <ReuseExp v-if="rerender" />
  </div>
</template>

<script>
import ReuseExp from "./ReuseExp.vue";
import moment from "moment";

export default {
  components: { ReuseExp },
  name: "Expense",
  data() {
    return {
      userid: "",
      totalexp: [],
      singlewallet: 0,
      username: "",
      rerender: true,
    };
  },
  created() {
    this.getuserdata();
  },
  mounted() {
    console.log("Component mounted.");
  },
  methods: {
    getuserdata() {
      axios.get("/userdata").then((res) => {
        this.userid = res.data.id;
        this.username = res.data.name;
        this.singlewallets();
      });
    },
    singlewallets() {
      axios.get("/singlewallets").then((res) => {
        this.singlewallet = res.data[0].current_balance;
        console.log(res.data);
      });
    },
    postExpense() {
      let formData = new FormData();
      formData.append("date", document.getElementById("Expensedate").value);
      formData.append(
        "expense_name",
        document.getElementById("expense_name").value
      );
      formData.append(
        "expense_amount",
        parseInt(document.getElementById("expense_amount").value)
      );
      formData.append("image", document.getElementById("image").files[0]);
      formData.append("user_id", this.userid);
      formData.append("user_name", this.username);
      axios.post("/userexpense", formData).then((res) => {
        console.log(res);

        document.getElementById("expense_name").value = "";
        document.getElementById("expense_amount").value = "";
        document.getElementById("image").value = "";
      });
      this.rerender = false;
      this.$nextTick().then(() => {
        this.rerender = true;
      });
    },
  },
};
</script>
<style scoped>
.center {
  width: 100%;
  display: flex;
  justify-content: center;
  flex-direction: column;
}
button {
  outline: none;
  border: none;
  background-color: rgb(100, 218, 218);
  border-radius: 5px;
  padding: 5px;
  margin: 5px;
}

tbody > tr {
  background-color: white;
}
table {
  width: 100%;
  table-layout: fixed;
  background-color: #d9d5ec;
  border-collapse: collapse;
  margin-top: 40px;
  margin-bottom: 40px;
}
thead {
  border: 1px solid #d9d5ec;
}
th {
  width: 100%;
  background-color: #f2f2f2;
  padding: 10px;
  margin: 0px;
  text-align: left;
  vertical-align: middle;
  font-family: DM Sans;
  font-style: normal;
  font-weight: bold;
  font-size: 14px;
  line-height: 18px;
  color: #2b3541;
  border: none !important;
}
td {
  padding: 10px;
  font-family: DM Sans;
  font-style: normal;
  font-weight: 500;
  font-size: 12px;
  line-height: 16px;
  color: #2b3541;
  text-align: left;
  vertical-align: middle;
  border: 1px solid #d9d5ec;
}
</style>