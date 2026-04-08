<template>
<div class="movie-section">
  <div class="movie-container">

    <h2 class="movie-title">
      PHIM ĐANG CHIẾU
    </h2>

    <div class="movie-grid">
      <div 
        v-for="(movie,index) in movies"
        :key="movie.id"
        class="movie-card"
      >

        <div class="poster-box">
          <img
            :src="getImage(movie.hinh_anh)"
            class="poster"
          />

          <div v-if="index<3" class="top-rank">
            {{index+1}}
          </div>

          <div class="overlay">
            <button class="btn-ticket" @click="datVe(movie)">
              Đặt vé
            </button>
          </div>
        </div>

        <div class="movie-info">
          <h3 
            class="movie-name"
            @click="goDetail(movie.slug)"
          >
            {{movie.ten_phim}}
          </h3>

          <p class="movie-meta">
            Thể loại:
            <span>{{movie.the_loai}}</span>
          </p>

          <p class="movie-meta">
            {{movie.thoi_luong}} phút |
            <span :class="getRatingColor(extractRating(movie.gioi_han_do_tuoi))">
              {{ extractRating(movie.gioi_han_do_tuoi) }}
            </span>
          </p>

          <p class="movie-meta">
            Khởi chiếu:
            <span>{{movie.ngay_chieu}}</span>
          </p>
        </div>

      </div>
    </div>

  </div>
</div>

<div v-if="showBooking" class="booking-modal" @click.self="showBooking=false">
  <div class="booking-box">

    <div class="booking-header">
      <h3>
        Lịch chiếu - {{ selectedMovie?.ten_phim }}
      </h3>
      <span class="close" @click="showBooking=false">✖</span>
    </div>

    <div class="booking-body">

      <h4>Chọn ngày chiếu</h4>

      <div class="month-title">
        Tháng {{ selectedDate?.month }}
      </div>

      <div class="date-list">
        <div 
          class="date-item"
          v-for="d in dates"
          :key="d.day + d.month"
          :class="{active: selectedDate?.day === d.day}"
          @click="selectedDate = d"
        >
          <p>{{ d.dayName }}</p>
          <b>{{ d.day }}</b>
        </div>
      </div>

      <h4 style="margin-top:30px">Chọn lịch chiếu</h4>

      <div class="movie-show">

        <img 
          v-if="selectedMovie"
          :src="'http://127.0.0.1:8000/storage/movies/' + selectedMovie.hinh_anh"
          class="showtime-poster"
        >

        <div class="showtimes">
          <div 
            class="time-box"
            v-for="show in filteredShowtimes"
            :key="show.id"
            @click="openSeat(show)" 
          >
            <div class="time">
              {{ show.start }} - {{ show.end }}
            </div>
            <p>{{ show.room }}</p>
          </div>
        </div>

      </div>

    </div>
  </div>

  <div v-if="showSeat" class="seat-modal">
    <div class="seat-container">

      <div class="seat-left">

        <div class="screen">MÀN HÌNH</div>

        <div class="seat-map">
          <div 
            v-for="row in rows" 
            :key="row" 
            class="seat-row"
          >
            <span class="row-name">{{ row }}</span>

            <div
              v-for="n in (row === 'H' ? 5 : 12)"
              :key="row+n"
              class="seat"
              :class="[
                bookedSeats.includes(row+n) ? 'booked' : '',
                selectedSeats.includes(row+n) ? 'active' : '',
                row==='H' ? 'couple' : '',
                (row==='D'||row==='E'||row==='F'||row==='G') ? 'vip' : '',
                (row==='A'||row==='B'||row==='C') ? 'normal' : ''
              ]"
              @click="!bookedSeats.includes(row+n) && toggleSeat(row+n)"
            >
              {{ row+n }}
            </div>

          </div>
        </div>

      </div>

      <div class="seat-right">

        <img 
          :src="'http://127.0.0.1:8000/storage/movies/' + selectedMovie.hinh_anh"
          class="seat-poster"
        >

        <p><b>Phim:</b> {{ selectedMovie.ten_phim}}</p>
        <p><b>Ngày:</b> {{ selectedDate.day }}/{{ selectedDate.month }}/2026</p>
        <p><b>Ghế:</b> {{ selectedSeats.join(', ') }}</p>
        <p><b>Số vé:</b> {{ selectedSeats.length }}</p>

        <p class="total">
          Tổng tiền: {{ totalPrice.toLocaleString() }} VND
        </p>

        <div class="legend">
          <div class="legend-item"><span class="box booked"></span> Ghế đã đặt</div>
          <div class="legend-item"><span class="box selecting"></span> Ghế đang chọn</div>
          <div class="legend-item"><span class="box normal"></span> Ghế thường</div>
          <div class="legend-item"><span class="box vip"></span> Ghế VIP</div>
          <div class="legend-item"><span class="box couple"></span> Ghế couple</div>
        </div>

        <div class="coupon-box">
          <input 
            v-model="couponCode"
            placeholder="Mã giảm giá"
            class="coupon-input"
          />

          <button class="btn-apply" @click="applyCoupon">
            Áp mã
          </button>

          <button class="btn-get" @click="goCouponPage">
            Lấy mã giảm giá
          </button>
        </div>

        <div class="seat-actions">
          <button class="btn-back" @click="showSeat=false;">
            Quay lại
          </button>

          <button class="btn-next" @click="continueBooking">
            Tiếp tục
          </button>
        </div>

      </div>

    </div>
  </div>

</div>
</template>

<script>

import axios from "axios"

export default{

data(){

return{
movies:[],
showBooking: false,
dates: [],
showtimes: [],
selectedDate: null,
selectedMovie: null,
showSeat: false,
rows: ['A','B','C','D','E','F','G','H'],
bookedSeats: [],
selectedSeats: [],
couponCode: ""
}
},

mounted(){
this.fetchMovies()
const data = localStorage.getItem("showtimes")

if(data){
  this.showtimes = JSON.parse(data)
  
}

},


methods:{
  applyCoupon(){
  alert("Áp mã thành công (demo)")
},
goCouponPage(){
  this.$router.push('/coupon')
},
continueBooking(){
  alert("Đi thanh toán...")
},
  toggleSeat(seat){
  const index = this.selectedSeats.indexOf(seat)

  if(index > -1){
    this.selectedSeats.splice(index,1)
  }else{
    this.selectedSeats.push(seat)
  }
},
  openSeat(show){
  this.selectedShow = show
  this.showSeat = true
},
extractRating(text) {
  if (!text) return "";
  const match = text.match(/C\d+|P/i);
  return match ? match[0] : "";
},

async fetchMovies(){

const res=await axios.get(
"http://127.0.0.1:8000/api/movies"
)

this.movies=res.data.filter(
m=>m.tinh_trang==="dangchieu"
)

},

getImage(img){
return "http://127.0.0.1:8000/storage/movies/"+img
},

 getRatingColor(r) {
    if (!r) return "";
    if (r.includes("18")) return "text-red font-bold";
    if (r.includes("16")) return "text-orange font-bold";
    if (r.includes("13")) return "text-yellow font-bold";
    if (r.toLowerCase() === "p") return "text-green font-bold";
    return "";
  

},
datVe(movie){
  this.selectedMovie = movie
  this.showBooking = true
  this.generateDates() 
},
goDetail(slug){
  this.$router.push(`/movie/${slug}`)
},
generateDates() {
  const today = new Date()
  const days = []

  const dayNames = ["CN","T2","T3","T4","T5","T6","T7"]

  for (let i = 0; i < 7; i++) {
    const d = new Date()
    d.setDate(today.getDate() + i)

    days.push({
      day: d.getDate(),
      month: d.getMonth() + 1,
      dayName: dayNames[d.getDay()]
    })
  }

  this.dates = days
  this.selectedDate = days[0] // 👉 chọn mặc định
}
},
computed:{
  filteredShowtimes(){
  if(!this.selectedDate || !this.selectedMovie) return []

  return this.showtimes.filter(s => {

    const matchMovie = s.movie.trim() === this.selectedMovie.ten_phim.trim()

    const date = new Date(s.date)
    const matchDate =
      date.getDate() === this.selectedDate.day &&
      (date.getMonth()+1) === this.selectedDate.month

    return matchMovie && matchDate
  })
},
totalPrice(){
  let total = 0

  this.selectedSeats.forEach(seat => {
    if(seat.startsWith('H')) total += 120000
    else if(['D','E','F','G'].includes(seat[0])) total += 100000
    else total += 80000
  })

  return total
}

}

}

</script>

<style scoped>

.movie-section{
padding:70px 0;
background:#f8fafc;
}

.movie-container{
width:92%;
max-width:1500px;
margin:auto;
}

.movie-title{
font-size:32px;
font-weight:800;
margin-bottom:40px;
border-bottom:3px solid #e5e7eb;
padding-bottom:10px;
}

.movie-grid{
display:grid;
grid-template-columns:repeat(4,1fr);
gap:55px 35px;
}

.movie-card{
transition:0.3s;
}

.movie-card:hover{
transform:translateY(-8px);
}

.poster-box {
position: relative;
border-radius: 12px;
overflow: hidden;
width: 100%;
aspect-ratio: 2/3;
box-shadow: 0 10px 25px rgba(0,0,0,0.18);
}

.poster {
width: 100%;
height: 100%;
object-fit: cover;
object-position: center top;
transition: transform 0.3s ease;
}

.poster-box:hover .poster {
transform: scale(1.03);
}

.poster-box:hover .overlay{
opacity:1;
}

.overlay {
position: absolute;
inset: 0;
background: rgba(0,0,0,0.8);
display: flex;
flex-direction: column;
justify-content: center;
align-items: center;
gap: 15px;
opacity: 0;
transition: 0.3s;
}

.poster-box:hover .overlay {
opacity: 1;
}

.btn-ticket{
background: orange;
color: black;
padding: 12px 25px;
border-radius: 30px;
border: none;
font-weight: bold;
cursor: pointer;
transition: 0.2s;
}

.btn-ticket:hover{
transform: scale(1.1);
}

.top-rank{
position:absolute;
top:-6px;
right:10px;
width:42px;
height:52px;
background:linear-gradient(180deg,#ffcc00,#ff9900);
color:white;
font-weight:bold;
display:flex;
justify-content:center;
align-items:center;
font-size:18px;
clip-path:polygon(0 0,100% 0,100% 80%,50% 100%,0 80%);
}

.movie-info{
margin-top:14px;
}

.movie-name {
font-size: 18px;
font-weight: 800;
margin-bottom: 8px;
display: -webkit-box;
-webkit-line-clamp: 2;
-webkit-box-orient: vertical;
overflow: hidden;
text-transform: uppercase;
color: #111827;
}

.movie-meta{
font-size:14px;
color:#6b7280;
margin:4px 0;
}

.movie-meta span{
color:#111827;
font-weight:600;
}

.age-tag{
padding:3px 8px;
border-radius:5px;
font-size:12px;
color:white;
font-weight:bold;
}

.age-red{
background:#ef4444;
}

.age-orange{
background:#fb923c;
}

.age-yellow{
background:#facc15;
color:#000;
}

.age-green{
background:#22c55e;
}

.movie-meta span.text-red { color: #ef4444 !important; }
.movie-meta span.text-orange { color: #fb923c !important; }
.movie-meta span.text-yellow { color: #facc15 !important; }
.movie-meta span.text-green { color: #22c55e !important; }

</style>