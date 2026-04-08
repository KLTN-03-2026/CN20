<template>
<div class="admin-page">

  <div class="content">

    <div class="card">
      <div class="card-header">
        <h2>Quản lý thanh toán</h2>
      </div>
    </div>

    <table class="table">

      <thead>
        <tr>
          <th>#</th>
          <th>Mã hóa đơn</th>
          <th>Phim</th>
          <th>Ngày chiếu</th>
          <th>Giờ</th>
          <th>Ghế</th>
          <th>Tổng tiền</th>
          <th>Trạng thái</th>
          <th>Action</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="(p,i) in payments" :key="p.id">
          <td>{{i+1}}</td>
          <td>{{p.order_code}}</td>
          <td>{{p.movie}}</td>
          <td>{{p.show_date}}</td>
          <td>{{p.show_time}}</td>
          <td>{{p.seats}}</td>
          <td>{{formatMoney(p.amount)}} đ</td>

          <td>
            <span class="status success">
              {{p.status}}
            </span>
          </td>

          <td>
            <button class="btn detail" @click="showDetail(p)">
              Chi tiết
            </button>

            <button class="refund-btn" @click="deleteInvoice(p.id)">
              Hoàn tiền
            </button>
          </td>
        </tr>
      </tbody>

    </table>

  </div>

  <div v-if="detail" class="modal">
    <div class="modal-box">

      <h3>Thông tin hóa đơn</h3>

      <p>Mã hóa đơn: {{detail.order_code}}</p>
      <p>Phim: {{detail.movie}}</p>
      <p>Ngày: {{detail.show_date}}</p>
      <p>Giờ: {{detail.show_time}}</p>
      <p>Ghế: {{detail.seats}}</p>
      <p>Tiền: {{formatMoney(detail.amount)}} đ</p>

      <div class="qr-box">
        <h3>Mã QR vé</h3>
        <canvas ref="qrcode"></canvas>
      </div>

      <button class="close-btn" @click="closeDetail">
        Đóng
      </button>

    </div>
  </div>

</div>
</template>

<script>
import axios from "axios"
import QRCode from "qrcode"

export default{

  data(){
    return{
      payments:[],
      detail:null
    }
  },

  async mounted(){
    const res = await axios.get("http://127.0.0.1:8000/api/payments")
    this.payments = res.data
  },

  methods:{

    async showDetail(p){

      this.detail = p

      this.$nextTick(async ()=>{

        const qrData = `
Mã hóa đơn: ${p.order_code}
Phim: ${p.movie}
Ngày: ${p.show_date}
Giờ: ${p.show_time}
Ghế: ${p.seats}
Tiền: ${p.amount}
`

        await QRCode.toCanvas(
          this.$refs.qrcode,
          qrData,
          { width:200 }
        )

      })

    },

    closeDetail(){
      this.detail = null
    },

    formatMoney(v){
      return Number(v).toLocaleString()
    },

    async deleteInvoice(id) {

      const confirmDelete = confirm("Bạn có chắc chắn muốn hoàn tiền hóa đơn này?")
      if (!confirmDelete) return

      try {

        await axios.delete(`http://127.0.0.1:8000/api/payments/${id}`)

        this.payments = this.payments.filter(payment => payment.id !== id)

        alert("Hoàn tiền và xóa hóa đơn thành công!")

      } catch (error) {

        alert("Hoàn tiền thất bại! Kiểm tra lại server.")
        console.error("Lỗi xóa hóa đơn:", error.response ? error.response.data : error.message)

      }

    }

  }

}
</script>

<style scoped>

.admin-page{
  padding:20px;
  background:#f5f6fa;
  min-height:100vh;
}

.card{
  background:white;
  border-radius:10px;
  padding:20px;
  box-shadow:0 2px 8px rgba(0,0,0,0.1);
}

.card-header{
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-bottom:20px;
}

.card-header h2{
  font-size:20px;
}

.table{
  width:100%;
  border-collapse:collapse;
}

.table th,
.table td{
  padding:10px;
  border-bottom:1px solid #eee;
  text-align:center;
}

.table th{
  background:#f3f3f3;
}

.status{
  background:#2ecc71;
  color:white;
  padding:4px 10px;
  border-radius:15px;
  font-size:12px;
}

.btn{
  border:none;
  padding:6px 10px;
  border-radius:4px;
  cursor:pointer;
  margin:2px;
}

.detail{
  background:#3498db;
  color:white;
}

.print{
  background:#2980b9;
  color:white;
}

.modal{
  position:fixed;
  top:0;
  left:0;
  width:100%;
  height:100%;
  background:rgba(0,0,0,0.5);
  display:flex;
  justify-content:center;
  align-items:center;
}

.modal-box{
  background:white;
  padding:20px;
  border-radius:10px;
  width:350px;
  text-align:center;
}

.close-btn{
  background:red;
  color:white;
  border:none;
  padding:6px 10px;
  border-radius:5px;
  margin-top:15px;
  cursor:pointer;
}

.qr-box{
  margin-top:20px;
  text-align:center;
}

.qr-box canvas{
  margin:auto;
  display:block;
}

.refund-btn{
  background:#ef4444;
  color:white;
  border:none;
  padding:6px 10px;
  border-radius:4px;
  cursor:pointer;
  margin-left:5px;
}

</style>