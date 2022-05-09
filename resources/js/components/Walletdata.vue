<template>
  <div class="container">
    <table>
      <thead>
        <tr>
          <th>Date</th>
          <th>User Name</th>
          <th>Amount Added</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="val in totalexp" v-bind:key="val.expense_name">
          <td>{{format_date(Date(val.created_at))}}</td>
          <td>{{ val.username}}</td>
          <td>{{val.amount}}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import moment from "moment";

export default {
  name: "Walletdata",
  data() {
    return {
      totalexp: [],
    };
  },
  created() {
    this.getTotalExp();
  },
  methods: {
    
    
    format_date(value) {
      if (value) {
        return moment(String(value)).format("MMMM Do YYYY");
      }
    },
    getTotalExp() {
      axios.get("/allwallets").then((res) => {
        let data = res.data.filter((val) => {
          return val.expense_id === "0";
        });
        this.totalexp = data;
        console.log(this.totalexp);
      });
    },
  },
};
</script>
<style scoped>
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