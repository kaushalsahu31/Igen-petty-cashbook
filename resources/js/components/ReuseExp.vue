<template>
  <div class="container">
    <table>
      <thead>
        <tr>
          <th>Date</th>
          <th>User Name</th>
          <th>Exp name</th>
          <th>Exp amount</th>
          <th>Exp status</th>
          <th>Image</th>
          <th >Approval</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="val in pageOfItems" v-bind:key="val.expense_name">
          <td>{{ val.date }}</td>
          <td>{{ val.user_name }}</td>
          <td>{{ val.expense_name }}</td>
          <td>{{ val.expense_amount }}</td>
          <td>{{ val.status }}</td>
          <td><a :href="val.img_path" target="_blank">View image</a></td>
          <td v-if="val.status === 'Pending' && user === 'admin'">
            <button v-on:click="accepted(val.user_id,val.id, val.expense_amount, 'Accepted', val.user_name )">Accept</button>
            <button :id="'rejectbtn'+val.id" v-on:click="rejectcomments(val.id)">Reject</button>
            <div class="hide" :id="'rejected'+val.id">
              <input type="text" :id="'rejectcomment'+val.id">
              <button v-on:click="rejected(val.id, 'Rejected' )">Reject</button>
            </div>
          </td>
          <td v-else-if="val.status === 'Rejected'">
            Rejected Comment: {{val.reject_comment}}
          </td>
          <td v-else-if="val.status === 'Pending' && user !== 'admin'">
            <button v-on:click="deleteexp(val.id)"
          class="del-btn">remove</button>
          </td>
          <td v-else></td>
        </tr>
      </tbody>
    </table>
    <div class="left"><jw-pagination :items="totalexp" @changePage="onChangePage"></jw-pagination></div>
    
  </div>
</template>

<script>
const totalexp = [...Array(150).keys()].map(i => ({ id: (i+1), name: 'Item ' + (i+1) }));
import moment from "moment";


export default {
  name: "test",
  data() {
    return {
      user: "",
      totalexp,
      pageOfItems: [],
      totalexp: [],
      userid: "",
    };
  },
  created() {
    this.getuserdata();
  },
  methods: {
    onChangePage(pageOfItems) {
            // update page of items
            this.pageOfItems = pageOfItems;
        },
    deleteexp(id) {
      axios.delete("/userexpense/" + id).then((res) => {
        this.getUserExp();
      });
    },accepted(user_id, id, amounts, status , username){
      axios.get("/userwallets/" + user_id).then((res) => {
        console.log(res);
        let formData = {};
        formData["current_balance"] = parseInt(res.data[0].current_balance) - parseInt(amounts);
        formData["user_id"] = user_id;
        formData["username"] = username;
        formData["amount"] = parseInt(amounts);
        formData["expense_id"] = id;
        formData["status"] = status;
        console.log(formData);
        axios.post("/wallet", formData).then((res) => {
          console.log(res);
          alert("Expense accepted");
          this.getuserdata();
        });
        
      });
      
    },
    rejectcomments(id){
      document.getElementById("rejected"+id).style.display="block";
      document.getElementById("rejectbtn"+id).style.display="none";
    },
    rejected(id, status ){
      let formData={}
      formData["expense_id"] = id;
      formData["status"] = status;
      formData["reject_comment"] = document.getElementById("rejectcomment"+id).value;
      

      axios.post("/reject", formData).then((res) => {
          console.log(res);
          alert("Expense rejected");
          this.getuserdata();
          document.getElementById("rejectcomment"+id).value="";
          document.getElementById("rejected"+id).style.display="none";
          
        });

    },
    format_date(value) {
      if (value) {
        return moment(String(value)).format("MMMM Do YYYY");
      }
    },
    getTotalExp() {
      axios.get("/userexpense").then((res) => {
        this.totalexp = res.data;
        // console.log(this.totalexp);
      });
    },
    getUserExp() {
      axios.get("/userexpense/" + this.userid).then((res) => {
        this.totalexp = res.data;
        console.log(this.totalexp);

      });
    },
    getuserdata() {
      axios.get("/userdata").then((res) => {
        this.user = res.data.role;
        this.userid = res.data.id;
        if(res.data.role==="admin"){
          this.getTotalExp();
        }else{
          this.getUserExp();
        }
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
.hide{
  display: none;
}
.left{
  width: 100%;
  display: flex;
  justify-content: center;
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