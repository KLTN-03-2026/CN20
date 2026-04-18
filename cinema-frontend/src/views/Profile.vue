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

        <div class="sidebar-item" :class="{active: activeTab==='discount'}" @click="openVoucher">
          MÃ GIẢM GIÁ
        </div>
        <div class="sidebar-item" :class="{active: activeTab==='member'}" @click="openMemberCard">
  THẺ THÀNH VIÊN
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
              <p><b>Giá:</b> {{ getFinalPrice(t.price) }} đ</p>
              <p class="paid">Đã thanh toán</p>
            </div>

            <div class="ticket-qr">
              <canvas :ref="'qr'+t.id"></canvas>
            </div>

            <button class="delete-btn" @click="deleteTicket(t.id)">🗑</button>
          </div>
        </div>
         <div v-if="activeTab==='member'" class="member-box">

  <div class="content-title">THẺ THÀNH VIÊN</div>

  <div v-if="!memberCard">

    <input
      v-model="memberCode"
      placeholder="Nhập mã thẻ thành viên"
      class="member-input"
    >

    <button class="link-btn" @click="linkMemberCard">
      Liên Kết Thẻ
    </button>

  </div>

  <div v-else class="member-card">
      <div v-if="memberCard" class="level-badge" :class="memberCard.level">
    {{ memberCard.level }}
  </div>

    <h2>{{ memberCard.level }}</h2>

    <p>Mã thẻ: {{ memberCard.code }}</p>

    <p>Giảm giá: {{ memberCard.discount }}%</p>

    <p>Tổng chi tiêu: {{ formatPrice(memberCard.total_spent) }}</p>

  </div>
<div v-if="memberCard" class="progress-wrapper">
  <div class="progress-bar">
    <div class="progress-fill" :style="{ width: percent + '%' }"></div>
  </div>

  <div class="milestones">
    <span>0</span>
    <span>500k</span>
    <span>1tr</span>
    <span>2tr</span>
        </div>
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
      copiedCode:'',
      memberCode:'',
      memberCard:null
    }
  },

async mounted() {
  const u = JSON.parse(localStorage.getItem('currentUser'))

  if (!u?.id) return

  try {
    let res = await fetch(`http://127.0.0.1:8000/api/user/${u.id}`)
    let data = await res.json()

    console.log("USER FROM DB:", data)
    this.user = {
      id: data.id,
      name: data.name || '',
      gender: data.gender || '',
      birth: data.birth || '',
      phone: data.phone || '',
      email: data.email || '',
      cmnd: data.cmnd || '',
      city: data.city || '',
      district: data.district || '',
      address: data.address || ''
    }
    localStorage.setItem('currentUser', JSON.stringify(data))
    await this.openMemberCard()

    if (this.memberCard) {
      this.memberCard.discount = this.getDiscount(this.memberCard.level)

      localStorage.setItem("memberCard", JSON.stringify({
        level: this.memberCard.level,
        discount: this.memberCard.discount
      }))
    }

  } catch (err) {
    console.error(err)
  }
},
computed:{
  percent(){
    if (!this.memberCard) return 0

    const total = this.memberCard.total_spent

    if (total < 500000) {
      return (total / 500000) * 33
    } else if (total < 1000000) {
      return 33 + ((total - 500000) / 500000) * 33
    } else {
      return 66 + ((total - 1000000) / 1000000) * 34
    }
  }
},
methods:{
  getFinalPrice(price){
    if (!this.memberCard) return price
    const discount = this.memberCard.discount || 0
    return price - (price * discount / 100)
  },

  getDiscount(level){
  const map = {
    BAC: 10,
    BẠC: 10,
    VANG: 15,
    VÀNG: 15,
    KIMCUONG: 25,
    KIM_CUONG: 25
  }

  const key = level
    ?.normalize("NFD")
    .replace(/[\u0300-\u036f]/g, "") // bỏ dấu tiếng Việt
    .toUpperCase()
    .replace(/\s/g, "_")

  return map[key] || 0
},
    async upgradeMember(type){
  const user = JSON.parse(localStorage.getItem("currentUser"))

  let res = await fetch("http://127.0.0.1:8000/api/member/update", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({
      user_id: user.id,
      member_type: type
    })
  })

  let data = await res.json()

  if(res.ok){
    alert("Cập nhật thẻ thành công")

    // update UI
    this.memberCard = data.member

    // update localStorage
    let current = JSON.parse(localStorage.getItem("currentUser"))
    current.member_type = data.member.type
    current.member_discount = data.member.discount
    localStorage.setItem("currentUser", JSON.stringify(current))
  }else{
    alert(data.message)
  }
},
 async linkMemberCard(){
  const currentUser = JSON.parse(localStorage.getItem("currentUser"))

  if(!currentUser?.id){
    alert("User không hợp lệ")
    return
  }

  if(!this.memberCode){
    alert("Chưa nhập mã thẻ")
    return
  }

  let res = await fetch("http://127.0.0.1:8000/api/link-member-card",{
    method:"POST",
    headers:{ "Content-Type":"application/json" },
    body: JSON.stringify({
      user_id: currentUser.id,
      code: this.memberCode
    })
  })

  let text = await res.text()
  console.log("RAW RESPONSE:", text)

  let data
  try {
    data = JSON.parse(text)
  } catch(e){
    console.log("❌ Backend không trả JSON:", text)
    alert("Server lỗi 500")
    return
  }

  if(!res.ok){
    alert(data.message || "Link thất bại")
    return
  }

  // =========================
  // ✅ FIX CHÍNH Ở ĐÂY
  // =========================

  let card = data.card || data.member || data

  this.memberCard = card

  this.memberCard.discount = this.getDiscount(card.level)

  // update localStorage nếu cần
  localStorage.setItem("memberCard", JSON.stringify(this.memberCard))

  alert("Liên kết thành công")
  await this.openMemberCard()
},
async openMemberCard(){

  this.activeTab = 'member'

  const currentUser = JSON.parse(localStorage.getItem("currentUser"))

  if(!currentUser?.id){
    alert("Không tìm thấy user")
    return
  }

  let res = await fetch(
    `http://127.0.0.1:8000/api/member-card/${currentUser.id}`
  )

  let data = await res.json()

  console.log("MEMBER CARD API:", data)

  // 👉 lấy đúng object card (tuỳ backend trả về kiểu gì)
  let card = data.card || data.member || data

  // nếu không có dữ liệu
  if(!card || !card.level){
    this.memberCard = null
    return
  }

  this.memberCard = card

  // 👉 tính discount ngay sau khi load
  this.memberCard.discount = this.getDiscount(card.level)
},
    async openVoucher(){

  this.activeTab='discount'

  const currentUser = JSON.parse(localStorage.getItem("currentUser"))

  if(!currentUser) return

  try{

    let res = await fetch(
      `http://127.0.0.1:8000/api/user-voucher/${currentUser.id}`
    )

    let data = await res.json()

    this.vouchers = data

  }catch(err){

    console.log(err)

  }

},
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

 saveProfile() {
  fetch('http://127.0.0.1:8000/api/update-profile', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(this.user)
  })
  .then(res => res.json())
  .then(data => {

    console.log('SERVER:', data)

    // ✅ PHẢI LẤY TRƯỚC
    let oldUser = JSON.parse(localStorage.getItem('currentUser')) || {}

    // update từng field
    oldUser.name = data.name ?? oldUser.name
    oldUser.gender = data.gender ?? oldUser.gender
    oldUser.birth = data.birth ?? oldUser.birth
    oldUser.phone = data.phone ?? oldUser.phone
    oldUser.cmnd = data.cmnd ?? oldUser.cmnd
    oldUser.city = data.city ?? oldUser.city
    oldUser.district = data.district ?? oldUser.district
    oldUser.address = data.address ?? oldUser.address

    // update UI
    this.user = oldUser

    // lưu lại localStorage
    localStorage.setItem('currentUser', JSON.stringify(oldUser))

    this.$forceUpdate()

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
}.member-box{
  max-width:800px;
  margin:auto;
}

.member-input{
  width:100%;
  padding:12px;
  margin-bottom:15px;
}

.link-btn{
  background:#ff5a00;
  color:white;
  border:none;
  padding:12px 20px;
  border-radius:8px;
  cursor:pointer;
}

.member-card{
  padding:30px;
  border-radius:20px;
  color:#222;
  background: linear-gradient(135deg,#ffffff,#f3f6ff);
  box-shadow:0 10px 30px rgba(0,0,0,0.08);
  border:1px solid #eee;
  position:relative;
  overflow:hidden;
}

.member-card::before{
  content:"";
  position:absolute;
  top:0; left:0;
  width:100%;
  height:6px;
  background:linear-gradient(90deg,#ff9800,#ff5722,#2196f3);
}

.member-card h2{
  font-size:28px;
  margin-bottom:15px;
  color:#ff5a00;
}.level-badge{
  display:inline-block;
  padding:6px 12px;
  border-radius:20px;
  font-weight:bold;
  margin-bottom:10px;
}

.BAC, .BẠC{
  background:#e0e0e0;
  color:#333;
}

.VANG, .VÀNG {
  background:gold;
  color:#000;
}

.KIMCUONG, .KIM_CUONG {
  background:linear-gradient(45deg,#00c6ff,#0072ff);
  color:white;
}
.progress-wrapper{
  margin-top:20px;
}

.progress-bar{
  height:8px;
  background:#ddd;
  border-radius:10px;
  overflow:hidden;
}

.progress-fill{
  height:100%;
  background:linear-gradient(90deg,#ff9800,#ff5722);
  transition:0.6s;
}

.milestones{
  display:flex;
  justify-content:space-between;
  margin-top:6px;
  font-size:12px;
}
</style>
