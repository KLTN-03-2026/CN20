<template>
  <div class="profile-page">
    <div class="profile-container">

      <div class="sidebar">
        <div class="sidebar-title">TÀI KHOẢN</div>

        <div class="sidebar-item" :class="{active: activeTab==='profile'}" @click="activeTab='profile'">
          THÔNG TIN TÀI KHOẢN
        </div>

        <div class="sidebar-item" :class="{active: activeTab==='password'}" @click="activeTab='password'">
          THAY ĐỔI MẬT KHẨU
        </div>

        <div class="sidebar-item" :class="{active: activeTab==='history'}" @click="openHistory">
          LỊCH SỬ GIAO DỊCH
        </div>

        <div class="sidebar-item" :class="{active: activeTab==='discount'}" @click="activeTab='discount'">
          MÃ GIẢM GIÁ
        </div>
      </div>

      <div class="content">

        <div v-if="activeTab==='profile'" class="form-box">
          <div class="content-title">THÔNG TIN TÀI KHOẢN</div>

          <div class="form-grid">
            <div class="form-group">
              <label>Họ Tên</label>
              <input v-model="user.name" />
            </div>

            <div class="form-group">
              <label>Giới Tính</label>
              <div class="gender-group">
                <label class="gender-item">
                    <span>Nam</span>
                    <input type="radio" value="Nam" v-model="user.gender"/>
                </label>

                <label class="gender-item">
                    <span>Nữ</span>
                    <input type="radio" value="Nữ" v-model="user.gender"/>
                </label>
                </div>
            </div>

            <div class="form-group">
              <label>Ngày Sinh</label>
              <input v-model="user.birth" />
            </div>

            <div class="form-group">
              <label>Số Điện Thoại</label>
              <input v-model="user.phone" />
            </div>

            <div class="form-group">
              <label>Email</label>
              <input v-model="user.email" disabled class="disabled-input" />
            </div>

            <div class="form-group">
              <label>Số CMND</label>
              <input v-model="user.cmnd" />
            </div>

            <div class="form-group">
              <label>Thành Phố</label>
              <select v-model="user.city">
                 <option>Đà Nẵng</option>
                <option>Hà Nội</option>
                <option>Hồ Chí Minh</option>
              </select>
            </div>

            <div class="form-group">
              <label>Quận/Huyện</label>
              <select v-model="user.district">
                <option value="">Chọn quận</option>
                <option>Hải Châu</option>
                <option>Sơn Trà</option>
                <option>Thanh Khê</option>
                <option>Liên Chiểu</option>
                <option>Cẩm Lệ</option>
                <option>Ngũ Hành Sơn</option>
              </select>
            </div>

            <div class="form-group full-width">
              <label>Địa Chỉ</label>
              <textarea v-model="user.address"></textarea>
            </div>
          </div>

          <button class="save-btn" @click="saveProfile">LƯU LẠI</button>
        </div>

        <div v-if="activeTab==='password'" class="form-box">
          <div class="content-title">THAY ĐỔI MẬT KHẨU</div>

          <div class="form-grid">
            <div class="form-group full-width">
              <label>Mật Khẩu Cũ</label>
              <input type="password" v-model="passwordData.old_password">
            </div>

            <div class="form-group">
              <label>Mật Khẩu Mới</label>
              <input type="password" v-model="passwordData.new_password">
            </div>

            <div class="form-group">
              <label>Nhập Lại Mật Khẩu</label>
              <input type="password" v-model="passwordData.confirm_password">
            </div>
          </div>

          <button class="save-btn" @click="changePassword">LƯU LẠI</button>
        </div>

        <!-- VOUCHER -->
        <div v-if="activeTab==='discount'" class="discount-box">
          <div class="content-title">MÃ GIẢM GIÁ</div>

          <div v-if="vouchers.length===0" class="no-ticket">Bạn chưa lưu mã giảm giá nào</div>

          <div class="coupon-card" v-for="(v,i) in vouchers" :key="i">
            <img :src="getVoucherImage(v.value)">

            <div class="right">
              <h2>Giảm {{ formatPrice(v.value) }}</h2>
              <p><b>Mã:</b> {{ v.code }}</p>
              <p class="date">📅 {{ formatDate(v.start) }} - {{ formatDate(v.end) }}</p>

              <button @click="copyCode(v.code)">
                {{ copiedCode===v.code ? 'Đã copy ✓' : 'Sao chép mã' }}
              </button>
            </div>
          </div>
        </div>

        <div v-if="activeTab==='history'" class="history-box">
          <div class="content-title">LỊCH SỬ GIAO DỊCH</div>

          <div v-if="tickets.length===0" class="no-ticket">Bạn chưa mua vé nào</div>

          <div class="ticket-card" v-for="t in tickets" :key="t.id">
              <div class="ticket-poster">
            <img
              :src="getPoster(t.poster)"
              @error="handleImgError"
            />
        </div>

            <div class="ticket-info">
              <h3>{{ t.movie }}</h3>
              <p><b>Phòng:</b> {{ t.room }}</p>
              <p><b>Ghế:</b> {{ t.seat }}</p>
              <p><b>Suất:</b> {{ t.showtime }}</p>
              <p><b>Giá:</b> {{ t.price }} đ</p>
              <p class="paid">Đã thanh toán</p>
            </div>

            <div class="ticket-qr">
              <canvas :ref="'qr'+t.id"></canvas>
            </div>

            <button class="delete-btn" @click="deleteTicket(t.id)">🗑</button>
          </div>
        </div>

      </div>
    </div>
    </div>
</template>

<script>
import defaultImg from '@/assets/tho-oi.jpg'
import img20k from '@/assets/20k.PNG'
import img30k from '@/assets/30k.png'
import img50k from '@/assets/50k.PNG'
import img100k from '@/assets/100k.jpg'

export default {
  data(){
    return {
      activeTab:'profile',
      user:{},
      passwordData:{},
      tickets:[],
      vouchers:[],
      copiedCode:''
    }
  },

 mounted(){
  const u = JSON.parse(localStorage.getItem('currentUser'))
  console.log('USER:', u)

  if(u){

    this.user = {
         id: u.id,
      name: u.name || '',
      gender: u.gender || '',
      birth: u.birth || '',
      phone: u.phone || '',
      email: u.email || '',
      cmnd: u.cmnd || '',
      city: u.city || '',
      district: u.district || '',
      address: u.address || ''
    }
  }
},

  methods:{
    getVoucherImage(v){
      if(v==20000) return img20k
      if(v==30000) return img30k
      if(v==50000) return img50k
      if(v==100000) return img100k
      return img20k
    },

    openHistory(){
      this.activeTab='history'
      const u = JSON.parse(localStorage.getItem('currentUser'))
      fetch(`http://127.0.0.1:8000/api/tickets/${u.id}`)
      .then(r=>r.json())
      .then(d=>this.tickets=d)
    },

    copyCode(c){
      navigator.clipboard.writeText(c)
      this.copiedCode=c
    },

    formatPrice(v){
      return Number(v).toLocaleString()+' VND'
    },

    formatDate(d){
      return new Date(d).toLocaleDateString('vi-VN')
    },

   saveProfile(){
  fetch('http://127.0.0.1:8000/api/update-profile',{
    method:'POST',
    headers:{'Content-Type':'application/json'},
    body: JSON.stringify(this.user)
  })
  .then(res => res.json())
  .then(data => {

    console.log('SERVER:', data)

    this.user = data 
    localStorage.setItem('currentUser', JSON.stringify(data))

    alert('Cập nhật thành công!')
  })
  .catch(err => {
    console.error(err)
    alert('Lỗi cập nhật!')
  })
},

    changePassword(){
      if(this.passwordData.new_password!==this.passwordData.confirm_password) return
      fetch('http://127.0.0.1:8000/api/change-password',{
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify(this.passwordData)
      })
    },

    deleteTicket(id){
      fetch(`http://127.0.0.1:8000/api/tickets/${id}`,{method:'DELETE'})
      this.tickets=this.tickets.filter(t=>t.id!==id)
    },
   getPoster(poster){
  if(!poster || poster === 'null'){
    return defaultImg
  }
  if(poster.startsWith('http')){
    return poster
  }

  if(poster.includes('movies/')){
    return 'http://127.0.0.1:8000/storage/' + poster
  }

  return 'http://127.0.0.1:8000/storage/movies/' + poster
},

  handleImgError(e){
    e.target.src = defaultImg
  }
  }
}
</script>

<style>

.profile-page{
  background:#f2f2f2;
  min-height:100vh;
  padding:50px 0;
}

.profile-container{
  width:1100px;
  margin:auto;
  display:flex;
  gap:40px;
}

.sidebar{
  width:250px;
  background:white;
  border:1px solid #ddd;
}

.sidebar-title{
  padding:15px;
  font-weight:bold;
  border-bottom:1px solid #ddd;
}

.sidebar-item{
  padding:15px;
  border-bottom:1px solid #eee;
  cursor:pointer;
}

.sidebar-item.active{
  background:#ff5a00;
  color:white;
}

.content{
  flex:1;
  background:white;
  border:1px solid #ddd;
  padding:30px;
}

.form-box {
  max-width:800px;
  margin:auto;
  border:1px solid #ddd;
  background:#fff;
  padding-bottom:30px;
}

.content-title {
  background:#8799b0;
  color:white;
  padding:10px;
  text-align:center;
  font-size:16px;
  font-weight:bold;
  margin-bottom:20px;
}

.form-grid {
  display:grid;
  grid-template-columns:1fr 1fr;
  column-gap:30px;
  row-gap:15px;
  padding:0 40px;
}

.form-group > label{
  display:block;
  margin-bottom:5px;
  font-size:13px;
  font-weight:500;
  color:#333;
}

input, select, textarea{
  width:100%;
  padding:6px 10px;
  border:1px solid #ccc;
  border-radius:3px;
  font-size:13px;
  box-sizing:border-box;
}

textarea{
   width:100%;
}

.disabled-input{
  background:#eee;
}

.gender-group{
  display:flex;
  gap:20px;
}

.save-btn{
  display:block;
  margin:20px auto 30px;
  padding:10px 40px;
  background:#8799b0;
  border:none;
  color:white;
  cursor:pointer;
}
.ticket-poster{
  width:160px;
  aspect-ratio:2/3;
  border-radius:12px;
  overflow:hidden;
  flex-shrink:0;
  background:#000;
}

.ticket-poster img{
  width:100%;
  height:100%;
  object-fit: cover;
  transition:0.3s;
}
.ticket-card:hover .ticket-poster img{
  transform:scale(1.08);
}
.save-btn:hover{
  background:#6d7d94;
}

.history-box{
  max-width:800px;
  margin:auto;
}

.ticket-card{
  display:flex;
  align-items:center;
  gap:25px;
  padding:20px;
}
.ticket-info h3{
  margin-bottom:10px;
}

.ticket-info p{
  margin:4px 0;
}

.paid{
  color:green;
  font-weight:bold;
}

.ticket-qr{
  display:flex;
  align-items:center;
  justify-content:center;
  width:100px;
}

.ticket-qr canvas{
  width:90px;
  height:90px;
}

.delete-btn{
  width:90px;
  height:160px;
  display:flex;
  align-items:center;
  justify-content:center;

  background:#ff4d4f;
  color:white;
  border:none;
  border-radius:8px;
  cursor:pointer;
  font-size:16px;
}

.delete-btn:hover{
  background:#d9363e;
}

.no-ticket{
  text-align:center;
  padding:40px;
  color:#888;
}

.discount-box{
  max-width:800px;
  margin:auto;
}

.coupon-card{
  display:flex;
  align-items:center;
  background:white;
  border-radius:12px;
  overflow:hidden;
  margin-bottom:20px;
  box-shadow:0 5px 15px rgba(0,0,0,0.1);
  transition:0.3s;
}

.coupon-card:hover{
  transform:translateY(-4px);
  box-shadow:0 10px 25px rgba(0,0,0,0.15);
}

.coupon-card img{
  width:200px;
  height:140px;
  object-fit:contain;
  flex-shrink:0;
  background:#fff;
  padding:5px;
}

.coupon-card .right{
  flex:1;
  padding:18px 20px;
  display:flex;
  flex-direction:column;
  justify-content:center;
}

.coupon-card h2{
  color:#ff5a00;
  font-size:22px;
  margin-bottom:6px;
}

.coupon-card p{
  margin:4px 0;
  font-size:14px;
  color:#333;
}

.coupon-card .date{
  color:#888;
  font-size:13px;
  margin-top:3px;
}

.coupon-card button{
  margin-top:10px;
  width:150px;
  padding:7px 10px;
  border:none;
  background:#ff5a00;
  color:white;
  border-radius:6px;
  cursor:pointer;
  font-size:13px;
  transition:0.2s;
}

.coupon-card button:hover{
  background:#e14e00;
}
.gender-group{
  display: flex;
  gap: 20px;
}

.gender-item{
  display:flex !important;
  justify-content: space-between;
  align-items:center;
  width:50px;
  cursor:pointer;

}
.gender-item span{
  font-size:20px;
}
.gender-item input{
  width: auto;
}
</style>
