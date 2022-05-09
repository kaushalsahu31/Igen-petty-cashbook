
<template >
   <div v-if="user==='admin'">
 <AddWallet></AddWallet >
   </div>
   <div v-else>
       <Expense></Expense >
   </div>
    
</template>



<script>
  import Expense from "./Expense.vue";
  import AddWallet from "./AddWallet.vue";

    export default {
        components: { Expense, AddWallet },
        name: "Home",
        data(){
            return {
                user: "",

            }
        },created(){
            this.getuserdata();
            
        },
        mounted() {
            
            
        },
        methods:{
            getuserdata(){
                axios.get("/userdata").then((res)=>{
                    this.user= res.data.role
                })
            }
        }
    }
</script>
<style scoped>

</style>