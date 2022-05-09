<template>
    <div class="container">
        
    <table>
      <thead>
        <tr>
          <th>No.</th>
          <th>User</th>
          <th>Current balance</th>
          <th>Add amount</th>
          <th>Add</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(val, index) in userdata" v-bind:key="index">
          <td>{{index +1}}</td>
          <td>{{val.name}}</td>
          <td>{{val.currentbalance}}</td>
          <td><input type="number" :id="'wallet'+val.id"></td>
          <td><button v-on:click="addwallet(val.id,0,val.currentbalance,'balance added',val.id, val.name)">Add wallet</button></td>
        </tr>
      </tbody>
      </table>

        <Walletdata/>
         
    </div>
</template>

<script>
import moment from "moment";
import Walletdata from './Walletdata.vue';


export default {
  name: "AddWallet",
  components: { Walletdata},
  data() {
    return {
      userdata: [],
      totalexp: [],
      currentuser: 0,
      currentbalance: 0,
      
    };
  },
  created() {
    this.getuserdata();
  },
  methods: {
    getuserdata() {
      axios.get("/alluserdata").then((res) => {
        let data = res.data.filter((val) => {
          return val.role === "user";
        });
        axios.get("/wallets").then((res2) => {
          for (let i = 0; i < data.length; i++) {
            data[i]["currentbalance"] = 0;
            for (let j = 0; j < res2.data.length; j++) {
              if (data[i].id == res2.data[j].user_id) {
                data[i]["currentbalance"] = res2.data[i].current_balance;
              }
            }
          }
          this.userdata = data;
        });
      });
    },
    addwallet(id, expid, current, status, amounts, name) {
      let formData = {};
      let amount;
      let a = 0;
      if (expid == 0) {
        amount = document.getElementById("wallet" + amounts).value;
        formData["current_balance"] = parseInt(current) + parseInt(amount);
        a = parseInt(current) + parseInt(amount);
      } else {
        amount = amounts;
        formData["current_balance"] = parseInt(current) - parseInt(amount);
        a = parseInt(current) - parseInt(amount);
      }
      formData["username"] = name;
      formData["user_id"] = id;
      formData["amount"] = parseInt(amount);
      formData["expense_id"] = expid;
      formData["status"] = status;
      console.log(formData);
      axios.post("/wallet", formData).then((res) => {
        console.log(res);
        document.getElementById("wallet" + id).value = "";
        alert("Amount added");
      });
      this.getuserdata();
    },
    format_date(value) {
      if (value) {
        return moment(String(value)).format("MMMM Do YYYY");
      }
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
.user {
  display: flex;
  justify-content: center;
  align-items: center;
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