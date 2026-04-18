  <template>

      <div class="container">
        <div class="main-banner">
          <button class="nav left" @click="prevSlide">❮</button>
          <img :src="slides[index]" class="big-image" />
          <button class="nav right" @click="nextSlide">❯</button>
        </div>

        <div class="thumbnail-list">
          <img
            v-for="(item, i) in slides"
            :key="i"
            :src="item"
            :class="['thumb', { activeThumb: index === i }]"
            @click="chonSlide(i)"
          />
        </div>

        <div class="movie-wrapper">

          <div class="movie-tabs">
            <button
              :class="{ active: currentTab === 'dangchieu' }"
              @click="currentTab = 'dangchieu'"
            >
              PHIM ĐANG CHIẾU
            </button>

            <button
              :class="{ active: currentTab === 'sapchieu' }"
              @click="currentTab = 'sapchieu'"
            >
              PHIM SẮP CHIẾU
            </button>
          </div>
     <div class="movie-slider">

  <button class="nav left" @click="prevMovie">❮</button>

  <div class="movie-grid">

    <div
      class="movie-card"
      v-for="movie in visibleMovies"
      :key="movie.id"
      @click="goDetail(movie.slug)"
    >

      <div class="image-wrapper">
        <img :src="'http://127.0.0.1:8000/storage/movies/' + movie.hinh_anh" />

        <div class="overlay">
          <button
            class="btn trailer-btn"
            @click.stop="xemTrailer(movie)">
            ▶ TRAILER
          </button>

          <button
            class="btn book-btn"
            @click.stop="datVe(movie)">
            🎟 ĐẶT VÉ
          </button>
        </div>
      </div>

      <h3>{{ movie.ten_phim }}</h3>

      <p>
        {{ movie.thoi_luong }} PHÚT |
        <span class="rating">{{ movie.the_loai }}</span>
      </p>

      <p>KHỞI CHIẾU {{ movie.ngay_chieu }}</p>

    </div>

  </div>

  <button class="nav right" @click="nextMovie">❯</button>

</div>
        </div>

        <div class="promo-section" @click="goCouponPage">

          <h2 class="promo-title">MÃ GIẢM GIÁ </h2>

          <div class="promo-grid">

            <div class="promo-box promo-text">
              <h3>MÃ GIẢM GIÁ HẤP DẪN</h3>
              <p>
                Khám phá ngay hàng trăm lợi ích dành cho bạn trong chuyên mục
                Mã giảm giá hấp dẫn của Rio Cinema.
              </p>
            </div>

            <div class="promo-box" @click="goCouponPage">
              <img src="../assets/20k.PNG">
            </div>

            <div class="promo-box" @click="goCouponPage">
              <img src="../assets/30k.png">
            </div>

            <div class="promo-box" @click="goCouponPage" >
              <img src="../assets/50k.PNG">
            </div>

            <div class="promo-box" @click="goCouponPage">
              <img src="../assets/100k.jpg">
            </div>
          </div>
        </div>
      </div>
  <div v-if="showBooking" class="booking-modal">

  <div class="booking-box">

    <div class="booking-header">
      <h3>Lịch chiếu</h3>
      <span class="close" @click="showBooking=false">✖</span>
    </div>

    <div class="booking-body">


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

        <img :src="'http://127.0.0.1:8000/storage/movies/' + selectedMovie.hinh_anh" class="showtime-poster">

        <div class="showtimes">
  <div class="time-box"
    v-for="show in filteredShowtimes"
    :key="show.id"
    @click="openSeat(show)"
  >
    <div class="time">
      {{ show.start_time }} - {{ show.end_time }}
    </div>

    <p>{{ show.room }}</p>
    <small>{{ show.format }}</small>

  </div>
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

          <div class="legend-item">
            <span class="box booked"></span> Ghế đã đặt
          </div>

          <div class="legend-item">
            <span class="box selecting"></span> Ghế đang chọn
          </div>

          <div class="legend-item">
            <span class="box normal"></span> Ghế thường
          </div>

          <div class="legend-item">
            <span class="box vip"></span> Ghế VIP
          </div>

          <div class="legend-item">
            <span class="box couple"></span> Ghế couple
          </div>
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


<div v-if="showTrailer" class="trailer-modal">
  <div class="trailer-box">
    <span class="close" @click="showTrailer=false">✖</span>

    <!-- mp4 -->
    <video v-if="trailerUrl.endsWith('.mp4')" width="600" controls autoplay>
      <source :src="trailerUrl" type="video/mp4" />
      Trình duyệt của bạn không hỗ trợ video.
    </video>

    <iframe
      v-else
      :src="trailerUrl"
      width="600"
      height="350"
      frameborder="0"
      allowfullscreen>
    </iframe>

  </div>
  </div>

<div class="contact-box">
  <button class="contact-btn" @click="open = !open">Liên hệ</button>

  <div class="popup" v-if="open">

    <div class="item" @click="openChatbot">
      <img src="https://cdn-icons-png.flaticon.com/512/4712/4712100.png" class="icon">
      <span>Chat với Chatbot AI</span>
    </div>

    <div class="item" @click="showZalo = true">
      <img src="https://upload.wikimedia.org/wikipedia/commons/9/91/Icon_of_Zalo.svg" class="icon">
      <span>Liên hệ Zalo</span>
    </div>

    <span class="close" @click="open = false">✖</span>
  </div>
</div>

<div v-if="showZalo" class="zalo-modal" @click.self="showZalo = false">
  <div class="zalo-box">

    <div class="zalo-header">
      <img src="https://upload.wikimedia.org/wikipedia/commons/9/91/Icon_of_Zalo.svg" class="zalo-logo">
      <span>Zalo</span>
      <span class="close" @click="showZalo=false">✖</span>
    </div>

    <!-- CONTENT -->
    <div class="zalo-content">

      <!-- LEFT -->
      <div class="zalo-left">
        <div class="brand">
          <div class="logo">R</div>
          <div>
            <h3>RIO CINEMA</h3>
            <p>Đặt vé & hỗ trợ</p>
          </div>
        </div>

        <button class="chat-btn">Nhắn tin</button>

        <div class="desc">
          Quét QR để liên hệ nhanh qua Zalo.
        </div>
      </div>

      <!-- RIGHT -->
      <div class="zalo-right">
        <img
          src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=https://zalo.me"
        />
        <p>Quét QR để mở Zalo</p>
      </div>

    </div>
  </div>
</div>
<div v-if="showChatbot" class="support-modal" @click.self="showChatbot=false">
  <div class="support-box">
    <div class="support-header">
      <div class="left">
        <img src="https://cdn-icons-png.flaticon.com/512/4712/4712027.png"/>
        <div>
          <h4>Chat với AI tư vấn</h4>
          <p>Em ở đây để hỗ trợ cho mình ạ</p>
        </div>
      </div>
      <span class="close" @click="showChatbot=false">✖</span>
    </div>

    <div class="support-content">

      <div class="user-box">
        <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png"/>
        <div class="info">
        <p v-if="user?.name"> {{ user.name }}</p>

        <p v-if="user?.phone"> {{ user.phone }}</p>

        <p v-if="user?.email"> {{ user.email }}</p>

    <small>{{ user.gender || 'Không rõ giới tính' }}</small>
    </div>
</div>

     <div class="chat-box">
  <div
    v-for="(msg, index) in messages"
    :key="index"
    :class="msg.role === 'user' ? 'msg user' : 'msg bot'"
  >
    {{ msg.text }}
  </div>
</div>

<input v-model="userMessage" placeholder="Nhập tin nhắn..." />

<button type="button" @click="sendMessage">
  Gửi
</button>

    </div>

  </div>
</div>
  </template>



  <script>
  import banner1 from '../assets/tho-oi.jpg'
  import banner2 from '../assets/nha-ba-toi-mot-phong.jpg'
  import banner3 from '../assets/bau-vat-troi-cho.jpg'
  import banner4 from '../assets/mui-pho.jpg'

  export default {
    data() {

      return {
        user: JSON.parse(localStorage.getItem("currentUser")) || null,
        index: 0,
        timer: null,
        slides: [banner1, banner2, banner3, banner4],
        currentTab: 'dangchieu',
        movies: [],
        showBooking: false,
        selectedMovie: null,
        dates: [],
        selectedDate: null,
        showSeat: false,
        seats: [],
        selectedSeats: [],
        rows:["A","B","C","D","E","F","G","H"],
        bookedSeats:["A3","B5","C8","D6","E7","F10","G4","H2"],
        showtimes: [],
        selectedShowtime:null,
        showTrailer: false,
        trailerUrl: "",
        couponCode: "",
        discount: 0,
        movieIndex: 0,
        movieTimer: null,
        loading: false,
        showZalo: false,
        open: false,
        showChatbot: false,
        userMessage: "",
        messages: [],
        memberDiscount: 0,
        memberLevel: null,
      }
    },

      computed:{
      totalPrice() {
  let total = 0

  this.selectedSeats.forEach(seat => {
    total += this.getSeatPrice(seat)
  })

  const memberDiscount = parseFloat(this.memberDiscount) || 0
  const voucher = parseFloat(this.discount) || 0

  if (memberDiscount > 0) {
    total *= (1 - memberDiscount / 100)
  }

  total -= voucher

  return total < 0 ? 0 : Math.round(total)
},
 filteredShowtimes() {
  if (!this.selectedMovie || !this.selectedDate) return []

  return this.showtimes.filter(s => {
    return (
      Number(s.movie_id) === Number(this.selectedMovie.id) &&
      s.date === this.selectedDate.fullDate
    )
  })
},

      dangChieu(){
        return this.movies.filter(m => m.tinh_trang === "dangchieu")
      },

      sapChieu(){
        return this.movies.filter(m => m.tinh_trang === "sapchieu")
      },

      filteredMovies(){

        return this.currentTab === "dangchieu"
          ? this.dangChieu
          : this.sapChieu

      },
      visibleMovies(){
  return this.filteredMovies.slice(this.movieIndex, this.movieIndex + 4)
}

    },
  methods: {

  async sendMessage() {
  if (!this.userMessage.trim()) return

  this.messages.push({
    role: "user",
    text: this.userMessage
  })

  try {
    const res = await fetch("http://127.0.0.1:8000/api/chatbot", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "Accept": "application/json"
      },
      body: JSON.stringify({
        message: this.userMessage
      })
    })

    const data = await res.json()

    this.messages.push({
      role: "bot",
      text: data.reply
    })

  } catch (err) {
    console.log(err)

    this.messages.push({
      role: "bot",
      text: "Lỗi kết nối server"
    })
  }

  this.userMessage = ""
},
     openChatbot(){
    this.showChatbot = true
  },
    openZalo() {
     window.open("https://oa.zalo.me/yourpageid", "_blank", "width=500,height=700")
  },
    autoMovieSlide(){
  this.movieTimer = setInterval(() => {

    if(this.movieIndex + 4 < this.filteredMovies.length){
      this.movieIndex++
    }else{
      this.movieIndex = 0
    }

  }, 3000)
},
    nextMovie(){
  if(this.movieIndex + 4 < this.filteredMovies.length){
    this.movieIndex++
  }
},

prevMovie(){
  if(this.movieIndex > 0){
    this.movieIndex--
  }
},
    getSeatPrice(seat){

  if(!this.selectedShowtime) return 0

  const base = Number(this.selectedShowtime?.price || 0)

  const row = seat.charAt(0)

  if(row === "H"){
    return base + 40000
  }

  if(row === "D" || row === "E" || row === "F" || row === "G"){
    return base + 20000
  }

  return base

},
  goDetail(slug){
    this.$router.push(`/movie/${slug}`)
  },
  logout(){
  localStorage.removeItem("currentUser")
  this.user = null
  this.$router.push("/")
  },

  openSeat(show){
  this.selectedShowtime = show
  this.showSeat = true
},

  nextSlide(){
    this.index = (this.index + 1) % this.slides.length
  },

  prevSlide(){
    this.index = (this.index - 1 + this.slides.length) % this.slides.length
  },

  chonSlide(i){
    this.index = i
  },

  autoSlide(){
    this.timer = setInterval(()=>{
      this.nextSlide()
    },3000)
  },

  xemTrailer(movie) {

    if(movie.ten_phim === "Thỏ Ơi") {
      this.trailerUrl = "https://www.youtube.com/embed/XMv1Zhj5TQg";
    } else {
      this.trailerUrl = movie.trailer || "";
      if(!this.trailerUrl){
        alert("Phim này chưa có trailer!");
        return;
      }
    }

    this.showTrailer = true;
  },

  datVe(movie){
console.log("selectedMovie:", movie)
    if(!this.user){
      alert("Bạn cần đăng nhập để đặt vé!")
      this.$router.push("/login")
      return
    }

    this.selectedMovie = movie
    this.selectedSeats = []
    this.showBooking = true

  },
  toggleSeat(seat){

    if(this.selectedSeats.includes(seat)){
      this.selectedSeats = this.selectedSeats.filter(s => s !== seat)
    }else{
      this.selectedSeats.push(seat)
    }

  },

  generateSeats(){

    this.seats = []

    const rows = ["A","B","C","D","E","F","G"]

    rows.forEach(r=>{
      for(let i=1;i<=12;i++){
        this.seats.push(r + i)
      }
    })

    for(let i=1;i<=5;i++){
      this.seats.push("H" + i)
    }

  },

  generateDates(){

    const today = new Date()
    this.dates = []

    const days = [
      "Chủ nhật",
      "Thứ 2",
      "Thứ 3",
      "Thứ 4",
      "Thứ 5",
      "Thứ 6",
      "Thứ 7"
    ]

    for(let i=0;i<7;i++){

      const d = new Date()
      d.setDate(today.getDate() + i)

      this.dates.push({
        dayName: days[d.getDay()],
        day: d.getDate(),
        month: d.getMonth() + 1,
        fullDate: d.toISOString().split("T")[0]
      })

    }

    this.selectedDate = this.dates[0]

  },

 async continueBooking() {
  if (!this.selectedShowtime) {
    alert("Bạn chưa chọn suất chiếu");
    return;
  }

  if (this.selectedSeats.length === 0) {
    alert("Bạn chưa chọn ghế");
    return;
  }

 const booking = {
  movie: this.selectedMovie.ten_phim,
  date: this.selectedDate.day + "/" + this.selectedDate.month + "/2026",
  time: this.selectedShowtime.start_time + " - " + this.selectedShowtime.end_time,
  room: this.selectedShowtime.room,
  seats: this.selectedSeats,
  total: this.totalPrice
};

localStorage.setItem("booking", JSON.stringify(booking));
  console.log("Booking saved:", booking);

  const res = await fetch("http://127.0.0.1:8000/api/momo_payment", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({
      total_momo: this.totalPrice
    })
  });

  const data = await res.json();

  if (data.payUrl) {
    window.location.href = data.payUrl;
  } else {
    alert("Không lấy được link MoMo");
  }
},
async applyCoupon(){

  if(!this.couponCode){
    alert("Vui lòng nhập mã")
    return
  }
  console.log("discount:", this.discount)

  try{
    const res = await fetch("http://127.0.0.1:8000/api/vouchers")
    const data = await res.json()

    const found = data.find(v =>
  v.code.trim().toLowerCase() === this.couponCode.trim().toLowerCase()
)

  if(!found){
  alert("Mã không hợp lệ")
  this.discount = 0
}else{
  this.discount = parseInt(found.value) || 0
  console.log("Voucher value:", found.value)
  console.log("Discount after parse:", this.discount)

  alert("Áp mã thành công - giảm " + this.discount.toLocaleString() + " VND")
}

  }catch(e){
    console.log(e)
    alert("Lỗi server")
  }

},

goCouponPage(){
  this.$router.push("/magiamgia")
},
  },

mounted() {

  const saved = localStorage.getItem("chat_history")

  if (saved) {
    this.messages = JSON.parse(saved)
  }
  const memberStr = localStorage.getItem("memberCard")

  let member = {
    type: "normal",
    discount: 0
  }

  try {
    if (memberStr) {
      member = JSON.parse(memberStr)
    }
  } catch (e) {
    console.log("Parse memberCard lỗi:", e)
  }

  this.memberLevel = member.type || "normal"
  this.memberDiscount = Number(member.discount) || 0

  console.log("memberLevel:", this.memberLevel)
  console.log("memberDiscount:", this.memberDiscount)

  this.generateDates()
  this.generateSeats()
  this.autoSlide()
  this.autoMovieSlide()

  fetch("http://127.0.0.1:8000/api/movies")
    .then(res => res.json())
    .then(data => {
      this.movies = data

      const slug = this.$route.query.booking
      if (slug) {
        const movie = this.movies.find(m => m.slug === slug)
        if (movie) this.datVe(movie)
      }
    })
    .catch(err => console.log(err))

 fetch("http://127.0.0.1:8000/api/showtimes")
  .then(res => res.json())
  .then(data => {
    this.showtimes = data
  })

},
watch: {
  messages: {
    deep: true,
    handler(val) {
      localStorage.setItem("chat_history", JSON.stringify(val))
    }
  }
}
  }

  </script>

  <style>
  html, body {
    margin: 0;
    padding: 0;
    background: #0a0f1c;
  }

  .page {
    min-height: 100vh;
    color: white;
    font-family: Arial, sans-serif;
  }

  .top-bar {
    background: #111827;
    color: #ccc;
    text-align: right;
    padding: 8px 50px;
    font-size: 14px;
  }

  .navbar {
    background: #0f172a;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 50px;
    border-bottom: 1px solid #1f2937;
  }

  .logo {
    font-weight: bold;
    font-size: 20px;
    color: orange;
  }

  .menu a {
    color: #ddd;
    margin: 0 15px;
    text-decoration: none;
    font-weight: bold;
  }


  .menu a:hover {
    color: orange;
  }


  .login a {
    color: orange;
    text-decoration: none;
    font-weight: bold;
  }
  .user-box{
  display:flex;
  align-items:center;
  gap:12px;
}

.profile-link{
  color:white;
  font-weight:bold;
  text-decoration:none;
  padding:6px 10px;
  border-radius:6px;
  background:#1f2937;
}

.profile-link:hover{
  background:#374151;
}

.logout-btn{
  background:#ef4444;
  border:none;
  padding:6px 12px;
  border-radius:6px;
  color:white;
  font-weight:bold;
  cursor:pointer;
}

.logout-btn:hover{
  background:#dc2626;
}

  .container {
    width: 85%;
    margin: 30px auto;
  }

  .main-banner {
    position: relative;
  }

  .big-image {
    width: 100%;
    height: 450px;
    object-fit: cover;
    border-radius: 10px;
  }

  .nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: orange;
    border: none;
    font-size: 25px;
    padding: 15px;
    cursor: pointer;
    border-radius: 50%;
    width: 50px;
    color: black;
  }

  .left { left: 20px; }
  .right { right: 20px; }

  .thumbnail-list {
    display: flex;
    gap: 15px;
    margin-top: 20px;
    justify-content: center;
  }

  .thumb {
    width: 250px;
    height: 100px;
    object-fit: cover;
    cursor: pointer;
    border-radius: 8px;
    opacity: 0.6;
  }


  .activeThumb {
    border: 3px solid orange;
    opacity: 1;
  }

  .movie-wrapper {
    margin-top: 60px;
    padding: 50px 0;
    background: #111827;
    border-radius: 20px;
  }

  .movie-tabs {
    text-align: center;
    margin-bottom: 40px;
  }

  .movie-tabs button {
    padding: 15px 30px;
    margin: 0 15px;
    border-radius: 30px;
    border: 2px solid orange;
    background: transparent;
    color: orange;
    font-weight: bold;
    cursor: pointer;
  }

  .movie-tabs .active {
    background: orange;
    color: black;
  }

  .movie-grid {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 30px;
  width: 100%;
}

  .movie-card {
  color: white;
    width: 220px;
    text-align: center;
  }

  .movie-card img {
    width: 100%;
    height: 320px;
    object-fit: cover;
    border-radius: 10px;
  }

  .rating {
    color: lime;
    font-weight: bold;
  }

  .image-wrapper{
  width:100%;
  aspect-ratio: 2/3;
  overflow:hidden;
  border-radius:12px;
  position: relative;
  box-shadow: 0 10px 25px rgba(0,0,0,0.3);
}

  .image-wrapper img{
    width:100%;
    height:100%;
    object-fit:cover;
  }
  .image-wrapper:hover img{
  transform: scale(1.05);
}
.movie-card{
  width: 240px;
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
    border-radius: 10px;
  }

  .image-wrapper:hover .overlay {
    opacity: 1;
  }

  .btn {
    padding: 12px 25px;
    border-radius: 30px;
    border: none;
    font-weight: bold;
    cursor: pointer;
  }

  .book-btn {
    background: orange;
    color: black;
  }

  .trailer-btn {
    background: red;
    color: white;
  }

  .btn:hover {
    transform: scale(1.1);
  }

  .promo-section{
    margin-top:80px;
  }

 .promo-title{
  text-align:center;
  font-size:32px;
  font-weight:bold;
  margin-bottom:40px;
  color: #ffffff;
  transition: 0.3s;
}

  .promo-grid{
    display:grid;
    grid-template-columns: repeat(4,1fr);
    gap:25px;
  }

  .promo-box{
    background:#111827;
    border-radius:10px;
    overflow:hidden;
    height:260px;
    display:flex;
    align-items:center;
    justify-content:center;
  }

  .promo-text{
    background:#e5e5e5;
    color:black;
    padding:40px;
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:flex-start;
    grid-column: span 2;
  }

  .promo-text h3{
     color: black !important;
    margin-bottom:20px;
  }

  .promo-text p{
     color: black !important;
    line-height:1.6;
  }

  .promo-box img{
    width:100%;
    height:100%;
    object-fit:cover;
  }

  .more-box{
    background:black;
    flex-direction:column;
    cursor:pointer;
  }

  .more-box span{
    font-size:40px;
  }

  .more-box p{
    margin-top:10px;
  }


  .booking-modal{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.8);
    display:flex;
    justify-content:center;
    align-items:center;
    z-index:1000;
  }

  .booking-box{
    width:900px;
    background:#f2f2f2;
    border-radius:8px;
    overflow:hidden;
  }

  .booking-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 20px;
    border-bottom:2px solid orange;
  }

  .booking-header h3{
    color:#ff4d00;
  }

  .close{
    cursor:pointer;
    font-size:18px;
  }

  .booking-body{
    padding:30px;
    color:black;
  }

  .date-list{
    display:flex;
    gap:20px;
    margin-top:15px;
  }

  .date-item{
    text-align:center;
    cursor:pointer;
  }

  .date-item b{
    background:#ddd;
    padding:10px 15px;
    border-radius:50%;
    display:block;
  }

  .date-item.active b{
    background:orange;
    color:white;
  }

  .movie-show{
    display:flex;
    gap:30px;
    margin-top:20px;
    align-items:flex-start;
  }

  .poster{
    width:200px;
    height:300px;
    object-fit:cover;
    border-radius:10px;
    box-shadow:0 8px 20px rgba(0,0,0,0.25);
  }

  .time-box{
    border:1px solid #ddd;
    padding:15px;
    text-align:center;
    background:white;
    border-radius:8px;
    cursor:pointer;
    transition:0.3s;
  }

  .time-box:hover{
    background:#ffb400;
    color:white;
    transform:translateY(-3px);
  }

  .time-box:hover p{
    color:white;
  }

  .time-box:hover .time{
    background:#ffb400;
    color:white;
    border-color:white;
  }
  .time{
    font-weight:bold;
    padding:8px;
    border:1px solid #ccc;
    margin-bottom:5px;
    background:#f5f5f5;
    transition:0.3s;
  }

  .time:hover{
    background:orange;
    color:white;
  }
  .month-title{
    text-align:center;
    font-size:22px;
    font-weight:bold;
    margin:20px 0;
  }

  .date-list{
    display:flex;
    justify-content:space-between;
    gap:20px;
  }

  .date-item{
    text-align:center;
    flex:1;
    cursor:pointer;
  }

  .date-item p{
    margin-bottom:8px;
  }

  .date-item b{
    background:#ddd;
    padding:12px 15px;
    border-radius:50%;
    display:inline-block;
  }

  .date-item.active b{
    background:#ff4d00;
    color:white;
  }

  .showtimes{
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:15px;
  margin-left:30px;
  }
  .showtime-poster{
  width:100px;
  aspect-ratio: 2/3;
  object-fit: cover;
  border-radius:10px;
}
  .time-box{
    border:1px solid #ddd;
    padding:12px;
    text-align:center;
    background:white;
    border-radius:6px;
    cursor:pointer;
  }

  .time{
    font-weight:bold;
  }

  .time-box p{
    font-size:13px;
    margin-top:5px;
    color:#555;
  }

  .time-box:hover{
    background:#ffb400;
    color:white;
    transform:translateY(-3px);
  }

  .time-box:hover .time{
    background:#ffb400;
    color:white;
    border-color:white;
  }

  .time-box:hover p{
    color:white;
  }
  .seat-modal{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.8);
    display:flex;
    justify-content:center;
    align-items:center;
    z-index:2000;
    overflow-y: auto;
  padding:20px 0;
  }

  .seat-box{
    width:800px;
    background:white;
    padding:30px;
    border-radius:10px;
  }

  .screen{
    text-align:center;
    background:#ccc;
    padding:10px;
    margin-bottom:30px;
    font-weight:bold;
  }

  .seat-grid{
    display:grid;
    grid-template-columns: repeat(12,1fr);
    gap:10px;
  }

  .seat{
    background:#ddd;
    padding:10px;
    text-align:center;
    border-radius:6px;
    cursor:pointer;
  }
  .seat-footer{
    margin-top:20px;
    font-weight:bold;
  }
 .seat-container{
  width: 90%;
  max-width: 1300px;
  background: white;
  border-radius: 10px;
  padding: 15px;
  display: flex;
  gap: 40px;
  margin: auto;
}

  .seat-left{
    flex:2;
  }

  .screen{
    text-align:center;
    background:#ddd;
    padding:10px;
    margin-bottom:30px;
    font-weight:bold;
    border-radius:5px;
  }

  .seat-row{
    display:flex;
    align-items:center;
    margin-bottom:10px;
  }
  .seat-row:last-child{
  justify-content: center;
}

  .row-name{
    width:25px;
    font-weight:bold;
  }

  .seat{
    width:34px;
    height:34px;
    margin:4px;
    font-size:11px;
    display:flex;
    justify-content:center;
    align-items:center;
    border-radius:4px;
    cursor:pointer;
    background:white;
  }
  .normal{
    border:2px solid black;
    background:white;
  }
  .booked{
    background:#d9d9d9;
    border:2px solid #bfbfbf;
    color:#777;
    cursor:not-allowed;
    position:relative;
  }

  .booked::before,
  .booked::after{
    content:"";
    position:absolute;
    width:100%;
    height:2px;
    background:#666;
    top:50%;
    left:0;
  }

  .booked::before{
    transform:rotate(45deg);
  }

  .booked::after{
    transform:rotate(-45deg);
  }

  .seat.active{
    background:#5cb85c;
    color:white;
  }

  .seat.couple{
    width:70px;
    height:34px;
    border:2px solid #ff4081;
    background:#ffe4ec;
  }

  .seat-right{
    flex:1;
    border-left:1px solid #ddd;
    padding-left:30px;
  }

  .seat-poster{
    width:200px;
    border-radius:8px;
    margin-bottom:20px;
  }
  .seat.active{
    background:#4CAF50;
    color:white;
    border:2px solid #4CAF50;
  }

  .total{
    margin-top:10px;
    font-weight:bold;
  }

  .legend{
    margin-top:25px;
  }

  .legend-item{
    display:flex;
    align-items:center;
    margin-bottom:8px;
  }

  .box{
    width:20px;
    height:20px;
    margin-right:10px;
    border:1px solid #ccc;
  }

  .box.booked{
    background:#ddd;
  }

  .box.selecting{
    background:#5cb85c;
  }

  .box.normal{
    background:white;
    border:2px solid black;
  }

  .box.vip{
    border:2px solid gold;
  }

  .box.couple{
    background:#ff4081;
  }
  .seat.vip{
    border:2px solid gold;
    background:white;
  }

  .seat.vip.active{
    background:#4CAF50;
    color:white;
    border:2px solid #4CAF50;
  }
  .seat-actions{
    display:flex;
    justify-content:flex-end;
    gap:20px;
    margin-top:30px;
  }

  .btn-back,
  .btn-next{
    padding:12px 40px;
    border:none;
    border-radius:6px;
    background:#1e73be;
    color:white;
    font-weight:bold;
    cursor:pointer;
    font-size:14px;
  }

  .btn-back:hover,
  .btn-next:hover{
    background:#155a96;
  }
  .header{
    display:flex;
    justify-content:space-between;
    align-items:center;
  }

  .logo{
    height:40px;
  }

  .lang{
    font-size:14px;
  }

  .title{
    text-align:center;
    margin:20px 0;
  }

  .method{
    border:1px solid #e5e5e5;
    padding:15px;
    margin-bottom:10px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    border-radius:6px;
    cursor:pointer;
    transition:0.2s;
  }

  .method:hover{
    background:#f9fafb;
  }
  .method{
  border:1px solid #e5e5e5;
  padding:15px;
  margin-bottom:10px;
  display:flex;
  justify-content:space-between;
  align-items:center;
  cursor:pointer;
  border-radius:6px;
}

.method:hover{
  background:#f9fafb;
}

.icon{
  width:40px;
}

.cards img{
  width:40px;
  margin-left:5px;
}

.footer{
  margin-top:20px;
  display:flex;
  justify-content:space-between;
  font-size:13px;
  color:#555;
}
.trailer-modal{
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.8);
  display:flex;
  justify-content:center;
  align-items:center;
  z-index:3000;
}

.trailer-box{
  background:white;
  padding:20px;
  border-radius:10px;
  position:relative;
  text-align:center;
}

.trailer-box .close{
  position:absolute;
  top:10px;
  right:15px;
  cursor:pointer;
  font-size:20px;
  font-weight:bold;
}
.coupon-box{
  display:flex;
  gap:10px;
  margin-top:20px;
}

.coupon-input{
  flex:1;
  padding:12px;
  border-radius:8px;
  border:1px solid #ccc;
}

.btn-apply{
  padding:12px 20px;
  background:#ddd;
  border:none;
  border-radius:8px;
  cursor:pointer;
}

.btn-get{
  padding:12px 20px;
  background:#c8e6c9;
  border:none;
  border-radius:8px;
  cursor:pointer;
}

.btn-get:hover{
  background:#a5d6a7;
}

.seat-actions{
  display:flex;
  justify-content:space-between;
  margin-top:30px;
}
.movie-slider{
  display:flex;
  align-items:center;
  gap:15px;
}

.slider-container {
  position: relative;
  width: 100%;
}

.nav-btn {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background: #f5a200;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
  z-index: 10;
}

.nav-left {
  left: 20px;
}

.nav-right {
  right: 20px;
}
.movie-list {
  display: flex;
  justify-content: center;
  gap: 40px;
  width: 100%;
}
.movie-slider {
  position: relative;
  width: 100%;
  margin-top: 20px;
}
.movie-slider .nav {
  top: 45%;
  transform: translateY(-50%);
}

.movie-slider .left { left: 20px; }
.movie-slider .right { right: 20px; }
.movie-slider .nav span,
.movie-slider .nav i,
.movie-slider .nav svg {
  display: flex;
  justify-content: center;
  align-items: center;
}
.contact-box {
  position: fixed;
  bottom: 25px;
  right: 25px;
  z-index: 99999;
}

.contact-btn {
  background: #b30000;
  color: white;
  border: none;
  padding: 12px 18px;
  border-radius: 10px;
  cursor: pointer;
  font-weight: 600;
  font-size: 14px;
}

.popup {
  position: absolute;
  bottom: 60px;
  right: 0;
  width: 200px;
  background: white;
  padding: 14px 12px 16px 12px;
  border-radius: 16px;
  box-shadow: 0 6px 20px rgba(0,0,0,0.18);
}

.popup .close {
  position: absolute;
  top: 8px;
  right: 10px;
  font-size: 16px;
  cursor: pointer;
}

.item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 6px;
  cursor: pointer;
  border-radius: 10px;
  transition: 0.2s;
}

.item:hover {
  background: #f5f5f5;
}

.icon {
  width: 34px;
  height: 34px;
  border-radius: 50%;
  object-fit: cover;
}

.item span {
  font-size: 14px;
  color: #333;
  font-weight: 500;
}
.zalo-modal{
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.65);
  display:flex;
  justify-content:center;
  align-items:center;
  z-index:99999;
  backdrop-filter: blur(5px);
}

.zalo-box{
  width: 750px;
  border-radius:16px;
  overflow:hidden;
  background: #fff;
  box-shadow: 0 20px 60px rgba(0,0,0,0.3);
  animation: zoomIn 0.3s ease;
}

@keyframes zoomIn{
  from{ transform: scale(0.9); opacity:0 }
  to{ transform: scale(1); opacity:1 }
}

.zalo-header{
  display:flex;
  align-items:center;
  justify-content:space-between;
  padding:14px 20px;
  background: linear-gradient(135deg,#0068ff,#00aaff);
  color:white;
}

.zalo-header span{
  font-weight:600;
  font-size:16px;
}

.zalo-logo{
  width:32px;
}

.zalo-header .close{
  cursor:pointer;
  font-size:18px;
  transition:0.2s;
}

.zalo-header .close:hover{
  transform: scale(1.2);
}

.zalo-content{
  display:flex;
  padding:30px;
  gap:30px;
}

.zalo-left{
  flex:1;
}

.brand{
  display:flex;
  align-items:center;
  gap:15px;
}

.logo {
  font-size: 26px;
  font-weight: 900;
  letter-spacing: 3px;
  color: white;
  font-family: 'Arial Black', sans-serif;
}

.logo span {
  color: #ff4d00;
  font-size: 14px;
  letter-spacing: 2px;
  margin-left: 6px;
}

.brand h3{
  margin:0;
  font-size:18px;
  color:#111;
}

.brand p{
  margin:0;
  font-size:13px;
  color:#666;
}

.chat-btn{
  margin-top:25px;
  padding:12px 28px;
  background: linear-gradient(135deg,#0068ff,#00aaff);
  color:white;
  border:none;
  border-radius:30px;
  cursor:pointer;
  font-weight:600;
  transition:0.3s;
  box-shadow:0 6px 15px rgba(0,104,255,0.3);
}

.chat-btn:hover{
  transform: translateY(-2px);
  box-shadow:0 10px 25px rgba(0,104,255,0.5);
}

.desc{
  margin-top:20px;
  color:#777;
  font-size:14px;
  line-height:1.5;
}

.zalo-right{
  text-align:center;
}

.zalo-right img{
  width:220px;
  height:220px;
  border-radius:16px;
  padding:12px;
  background:white;
  box-shadow:0 10px 30px rgba(0,0,0,0.2);
  transition:0.3s;
}

.zalo-right img:hover{
  transform: scale(1.05);
}

.zalo-right p{
  margin-top:12px;
  font-size:14px;
  color:#555;
}
.support-modal {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.4);
  display: flex;
  justify-content: flex-end;
  align-items: flex-end;
  padding: 20px;
  z-index: 99999;
}

.support-box {
  width: 320px;
  border-radius: 16px;
  overflow: hidden;
  background: #fff;
  box-shadow: 0 10px 30px rgba(0,0,0,0.3);
  animation: slideUp 0.3s ease;
}

@keyframes slideUp {
  from {
    transform: translateY(50px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

.support-header {
  background: #e1261c;
  color: white;
  padding: 14px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.support-header .left {
  display: flex;
  gap: 10px;
  align-items: center;
}

.support-header img {
  width: 40px;
  border-radius: 50%;
  background: white;
  padding: 5px;
}

.support-header h4 {
  margin: 0;
  font-size: 14px;
}

.support-header p {
  margin: 0;
  font-size: 12px;
  opacity: 0.9;
}

.support-header .close {
  cursor: pointer;
  font-size: 18px;
}

.support-content {
  padding: 12px;
}
.support-content input {
  width: calc(100% - 70px);
  padding: 10px 14px;
  border-radius: 20px;
  border: 1px solid #ddd;
  outline: none;
  font-size: 13px;
  transition: 0.2s;
}

.support-content input:focus {
  border-color: #e1261c;
  box-shadow: 0 0 5px rgba(225, 38, 28, 0.3);
}

.support-content button {
  width: 50px;
  height: 38px;
  border-radius: 50%;
  border: none;
  background: #e1261c;
  color: white;
  cursor: pointer;
  font-size: 16px;
  transition: 0.2s;
}

.support-content button:hover {
  background: #c91f16;
  transform: scale(1.1);
}

.support-content .input-group {
  display: flex;
  align-items: center;
  gap: 8px;
}
.user-box {
  display: flex;
  gap: 10px;
  background: #f3f4f6;
  padding: 10px;
  border-radius: 10px;
  align-items: center;
  margin-bottom: 10px;
}

.user-box img {
  width: 36px;
}

.info h5 {
  margin: 0;
  font-size: 14px;
}

.info p {
  margin: 0;
  font-size: 12px;
  color: #555;
}

.info small {
  font-size: 11px;
  color: #888;
}

textarea {
  width: 100%;
  height: 80px;
  border-radius: 10px;
  border: 1px solid #ddd;
  padding: 10px;
  resize: none;
  outline: none;
  font-size: 13px;
}

.start-btn {
  width: 100%;
  margin-top: 10px;
  padding: 10px;
  background: #e1261c;
  color: white;
  border: none;
  border-radius: 25px;
  font-weight: 600;
  cursor: pointer;
  transition: 0.2s;
}

.start-btn:hover {
  background: #c91f16;
}
.chat-box {
  max-height: 250px;
  overflow-y: auto;
  margin-bottom: 10px;
}

.msg {
  padding: 8px 12px;
  margin: 6px 0;
  border-radius: 10px;
  max-width: 80%;
}

.user {
  background: #007bff;
  color: white;
  margin-left: auto;
}

.bot {
  background: #eee;
}
</style>
