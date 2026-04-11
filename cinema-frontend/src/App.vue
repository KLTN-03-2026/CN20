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

  created() {
  const saved = localStorage.getItem("currentUser")

  if (saved) {
    this.user = JSON.parse(saved)
  }
}

  }


</script>
