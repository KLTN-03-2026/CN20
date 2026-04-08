<template>
  <router-view />
</template>

<script>

export default {

  data(){
    return{
      user:null
    }
  },

  created(){

    const savedUser = localStorage.getItem("currentUser")

    if(savedUser){
      try{
        this.user = JSON.parse(savedUser)
      }catch(e){
        console.error("Dữ liệu user lỗi:", savedUser)
        localStorage.removeItem("currentUser")
        this.user = null
      }
    }

  }

}
</script>