<template>
  <button @click="payMomo">Thanh toán MoMo</button>
</template>

<script>
export default {
  methods:{
    async payMomo(){

      const res = await fetch("http://127.0.0.1:8000/api/momo_payment",{
        method:"POST",
        headers:{
          "Content-Type":"application/json"
        },
        body: JSON.stringify({
          total_momo: 50000
        })
      })

     const data = await res.json()
    console.log("MOMO RESPONSE:", data)

      if(data.payUrl){
        window.location.href = data.payUrl
      }else{
        alert("Không lấy được link MoMo")
      }
    }
  }
}

</script>
