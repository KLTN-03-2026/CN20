<template>
  <div class="coupon-page">

    <div class="coupon-header">
      <p>Trang chủ / Mã giảm giá</p>
      <h1>MÃ GIẢM GIÁ</h1>
    </div>

    <div class="coupon-list">

      <div class="coupon-card" v-for="(c, i) in magiamgia" :key="i">

        <div class="left">
          <img :src="getVoucherImage(c.value)">
        </div>

        <div class="right">
          <h2>Giảm {{ formatPrice(c.value) }}</h2>

          <p><b>Mã khuyến mãi:</b> {{ c.code }}</p>

          <p class="date">
            📅 Từ {{ formatDate(c.start) }} đến {{ formatDate(c.end) }}
          </p>

          <button 
            :disabled="new Date() > new Date(c.end)"
            @click="copyCode(c.code, c.end)"
          >
            {{ new Date() > new Date(c.end) ? "Đã hết hạn" : "Sao chép mã" }}
          </button>
        </div>

      </div>

    </div>

  </div>
</template>

<script>
export default {

  data(){
    return{
      magiamgia: [],
    }
  },

  async mounted(){
    let res = await fetch("http://localhost:8000/api/vouchers")
    let data = await res.json()
    this.magiamgia = data
  },

  methods:{

    getVoucherImage(value){
      if(value == 20000){
        return new URL('../assets/20k.PNG', import.meta.url).href
      }
      if(value == 50000){
        return new URL('../assets/50k.PNG', import.meta.url).href
      }
      if(value == 30000){
        return new URL('../assets/30k.png', import.meta.url).href
      }
      if(value == 100000){
        return new URL('../assets/100k.jpg', import.meta.url).href
      }
      return new URL('../assets/20k.PNG', import.meta.url).href
    },

    async copyCode(code, end){

      const today = new Date()
      const endDate = new Date(end)

      if(today > endDate){
        alert("❌ Mã đã hết hạn, không thể sao chép")
        return
      }

      const currentUser = JSON.parse(localStorage.getItem("currentUser"))

      if(!currentUser){
        alert("Bạn chưa đăng nhập")
        return
      }

      try{

        await navigator.clipboard.writeText(code)


        await fetch("http://localhost:8000/api/save-voucher",{
          method:"POST",
          headers:{
            "Content-Type":"application/json"
          },
          body:JSON.stringify({
            user_id: currentUser.id,
            code: code
          })
        })

        alert("Đã lưu mã vào tài khoản!")

      }catch(err){

        console.error(err)
        alert("Lỗi lưu mã")

      }

    },

    formatPrice(value){
      return Number(value).toLocaleString() + " VND"
    },

    formatDate(date){
      const d = new Date(date)
      return d.toLocaleDateString("vi-VN")
    }

  }

}
</script>

<style scoped>

.coupon-page{
  background:#f5f5f5;
  min-height:100vh;
  padding:40px 80px;
}

.coupon-header{
  text-align:center;
  margin-bottom:40px;
}

.coupon-header p{
  color:#777;
}

.coupon-header h1{
  font-size:40px;
  margin-top:10px;
}

.coupon-list{
  display:flex;
  flex-direction:column;
  gap:25px;
}

.coupon-card{
  display:flex;
  align-items:center;
  background:white;
  border-radius:12px;
  overflow:hidden;
  padding:20px;
  box-shadow:0 6px 20px rgba(0,0,0,0.08);
}

.left{
  width:180px;
  height:120px;
  flex-shrink:0;
}

.left img{
  width:100%;
  height:100%;
  object-fit:cover;
  border-radius:8px;
}

.right{
  margin-left:25px;
}

.right h2{
  color:#ff4d00;
  margin-bottom:8px;
}

.right p{
  margin:4px 0;
}

.date{
  color:#777;
  font-size:14px;
}

.right button{
  margin-top:12px;
  padding:8px 18px;
  border:none;
  background:#ff5a00;
  color:white;
  cursor:pointer;
  border-radius:6px;
  font-weight:500;
  transition:0.2s;
}

.right button:hover{
  background:#e24f00;
}

button:disabled{
  background:#ccc;
  cursor:not-allowed;
}

</style>