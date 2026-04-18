<template>
<div class="success-page">

  <div class="success-box">

    <div class="icon">✔</div>

    <h1>Thanh toán thành công!</h1>
    <p class="sub">Cảm ơn bạn đã đặt vé xem phim</p>

    <div class="section">

      <h3>Thông tin đặt vé</h3>

      <div class="row">
        <span>Phim</span>
        <b>{{ movie }}</b>
      </div>

      <div class="row">
        <span>Ngày chiếu</span>
        <b>{{ date }}</b>
      </div>

      <div class="row">
        <span>Giờ chiếu</span>
        <b>{{ time }}</b>
      </div>

      <div class="row">
        <span>Ghế</span>
        <b>{{ seats.join(" ") }}</b>
      </div>

      <div class="row">
        <span>Mã đơn</span>
        <b>{{ orderId }}</b>
      </div>

      <div class="row">
        <span>Số tiền</span>
        <b class="money">{{ formatMoney(amount) }} VND</b>
      </div>

      <div class="row">
        <span>Phương thức</span>
        <b>MoMo</b>
      </div>

      <div class="row">
        <span>Trạng thái</span>
        <b>Thành công </b>
      </div>

    </div>

    <div class="qr-box" v-if="qrCode">
      <h3>Mã QR vé</h3>
      <img :src="qrCode" width="180"/>
      <p>Vui lòng trình mã QR khi vào rạp</p>
    </div>

    <div class="buttons">
      <button class="home" @click="$router.push('/')">
        Trang chủ
      </button>
    </div>

  </div>

</div>
</template>

<script>
import axios from "axios"
import QRCode from "qrcode"

export default {

  data(){
    return{
      orderId:'',
      amount:0,
      movie:'',
      date:'',
      time:'',
      seats:[],
      qrCode:''
    }
  },

  async mounted(){
    this.orderId = this.$route.query.orderId
    this.amount = this.$route.query.amount

    const booking = JSON.parse(localStorage.getItem("booking"))

    if(!booking){
      return
    }

    this.movie = booking.movie
    this.date = booking.date
    this.time = booking.time
    this.seats = booking.seats || []

    const currentUser = JSON.parse(localStorage.getItem("currentUser"))

    const ticketData = {
      user_id: currentUser?.id || 1,
      movie: this.movie,
      room: booking.room,
      seat: this.seats.join(" "),
      showtime: this.date + " " + this.time,
      price: Number(this.amount),
    }

    try{

      const payment = await axios.post("http://127.0.0.1:8000/api/payments",{
        order_code: this.orderId,
        movie: this.movie,
        show_date: this.date,
        show_time: this.time,
        seats: this.seats.join(","),
        amount: this.amount,
        method: "MoMo",
        status: "Đã thanh toán"
      })

    }catch(e){
    }

    try{

      const ticket = await axios.post(
        "http://127.0.0.1:8000/api/tickets",
        ticketData
      )

    }catch(e){
    }

    const qrData = `Order:${this.orderId}`

    QRCode.toDataURL(qrData)
    .then(url=>{
      this.qrCode = url
    })

  },

  methods:{
    formatMoney(value){
      return Number(value).toLocaleString("vi-VN")
    }
  }

}
</script>

<style>

.success-page{
  background:#071426;
  min-height:100vh;
  display:flex;
  justify-content:center;
  align-items:flex-start;
  padding-top:10px;
  color:white;
}

.success-box{
  background:#0f1f36;
  padding:40px;
  width:420px;
  max-width:90%;
  border-radius:10px;
  text-align:center;
}

.icon{
  width:70px;
  height:70px;
  background:#3bb54a;
  border-radius:50%;
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:30px;
  margin:auto;
  margin-bottom:20px;
}

.sub{
  opacity:0.7;
  margin-bottom:30px;
}

.section{
  text-align:left;
  margin-top:20px;
}

.row{
  display:flex;
  justify-content:space-between;
  margin:12px 0;
  font-size:18px;
}

.row span{
  color:#ddd;
  min-width:120px;
}

.row b{
  text-align:right;
  flex:1;
}

.money{
  color:#00ff90;
}

.buttons{
  margin-top:30px;
  display:flex;
  gap:10px;
}

.home{
  flex:1;
  background:#e53935;
  border:none;
  color:white;
  padding:12px;
  border-radius:6px;
  cursor:pointer;
}

</style>
