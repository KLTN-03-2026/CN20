<template>
  <div class="movie-detail">
    <div class="container">
      <div class="movie-top">
        <div class="poster">
          <img :src="'http://127.0.0.1:8000/storage/movies/' + movie.hinh_anh" :alt="movie.ten_phim">
        </div>

        <div class="info">
          <h1>{{ movie.ten_phim }}</h1>
          <p><b>Đạo diễn:</b> {{ movie.dao_dien }}</p>
          <p><b>Diễn viên:</b> {{ movie.dien_vien }}</p>
          <p><b>Thể loại:</b> {{ movie.the_loai }}</p>
          <p><b>Khởi chiếu:</b> {{ movie.ngay_chieu }}</p>
          <p><b>Thời lượng:</b> {{ movie.thoi_luong }} phút</p>
          <p><b>Ngôn ngữ:</b> {{ movie.ngon_ngu }}</p>
          <p class="rated"><b>Rated:</b> {{ movie.gioi_han_do_tuoi }}</p>
        </div>
      </div>

      <div class="tabs">
        <button :class="{ active: tab === 'detail' }" @click="tab = 'detail'">
          Chi tiết
        </button>
        <button :class="{ active: tab === 'trailer' }" @click="tab = 'trailer'">
          Trailer
        </button>
        <button :class="{ active: tab === 'review' }" @click="tab = 'review'">
          Đánh giá
        </button>
      </div>

      <div class="tab-content">
        <div v-if="tab === 'detail'">
          <p>{{ movie.chi_tiet }}</p>
        </div>

        <div v-if="tab === 'trailer'">
          <iframe
            width="560"
            height="315"
            :src="movie.trailer"
            frameborder="0"
            allowfullscreen
          ></iframe>
        </div>

        <div v-if="tab === 'review'" class="review-section">
  <h2>Đánh giá phim</h2>

  <div class="review-form">
    <div class="stars">
      <span
        v-for="star in 5"
        :key="star"
        @click="rating = star"
        :class="{ active: rating >= star }"
      >
        ★
      </span>
    </div>

    <textarea
      v-model="comment"
      placeholder="Nhập đánh giá của bạn..."
    ></textarea>

    <button @click="submitReview">
      Gửi đánh giá
    </button>
  </div>

  <div class="review-list">
    <div
      class="review-item"
      v-for="review in reviews"
      :key="review.id"
    >
      <h4>{{ review.user_name }}</h4>
      <p>{{ '★'.repeat(review.rating) }}</p>
      <p>{{ review.comment }}</p>
    </div>
  </div>
</div>
</div>
</div>
</div>
</template>

<script>
export default {
  data() {
    return {
      movie: {},
      tab: "detail",
    reviews: [],
    rating: 0,
    comment: ""
    }
  },
  methods: {
  async fetchReviews() {
    if (!this.movie.id) return

    const res = await fetch(
      `http://127.0.0.1:8000/api/reviews/${this.movie.id}`
    )

    this.reviews = await res.json()
  },

  async submitReview() {
    if (!this.rating || !this.comment) {
      alert("Vui lòng nhập đầy đủ đánh giá")
      return
    }

    const user = JSON.parse(localStorage.getItem("currentUser"))

    const res = await fetch(
      "http://127.0.0.1:8000/api/reviews",
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({
          movie_id: this.movie.id,
          user_name: user?.name || "Khách",
          rating: this.rating,
          comment: this.comment
        })
      }
    )

    const data = await res.json()

    this.reviews.unshift(data.review)

    this.rating = 0
    this.comment = ""

    alert("Đánh giá thành công")
  }
},

  mounted() {
  const slug = this.$route.params.slug;

  fetch("http://127.0.0.1:8000/api/movies/" + slug)
    .then(res => res.json())
    .then(data => {
      this.movie = data
      this.fetchReviews()
    })
    .catch(err => console.error(err))
}
}
</script>

<style scoped>
.movie-detail {
  background: #f4f4f4;
  padding: 40px 0;
  min-height: 100vh;
}

.container {
  width: 1100px;
  margin: auto;
}

.movie-top {
  display: flex;
  gap: 40px;
}

.poster {
  width: 250px;
  height: 350px;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
  flex-shrink: 0;
}

.poster img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.info h1 {
  margin-bottom: 20px;
  font-size: 28px;
  color: #333;
}

.info p {
  margin: 10px 0;
  font-size: 16px;
}

.rated {
  color: #e74c3c;
  font-weight: bold;
}

.tabs {
  margin-top: 40px;
  display: flex;
  gap: 15px;
  justify-content: center;
  border-bottom: 1px solid #ddd;
  padding-bottom: 10px;
}

.tabs button {
  padding: 10px 25px;
  border-radius: 25px;
  border: 1px solid #ccc;
  background: white;
  cursor: pointer;
  transition: 0.3s;
}

.tabs .active {
  background: #ff6600;
  color: white;
  border-color: #ff6600;
}

.tab-content {
  margin-top: 20px;
  line-height: 1.8;
  min-height: 200px;
}

.tab-content iframe {
  display: block;
  margin: 20px auto;
  border-radius: 8px;
}

.bottom {
  margin-top: 40px;
  display: flex;
  justify-content: center;
}

.btn-book {
  background: #0c1f33;
  color: white;
  border: none;
  padding: 15px 40px;
  border-radius: 30px;
  font-weight: bold;
  font-size: 18px;
  cursor: pointer;
  transition: transform 0.2s;
}

.btn-book:hover {
  transform: scale(1.05);
  background: #162e4a;
}
.review-section {
  margin-top: 20px;
  background: #ffffff;
  padding: 30px;
  border-radius: 16px;
  box-shadow: 0 8px 30px rgba(0,0,0,0.08);
}

.review-section h2 {
  margin-bottom: 25px;
  font-size: 26px;
  color: #222;
  text-align: center;
  font-weight: 700;
}

.review-form {
  background: #f8fafc;
  padding: 25px;
  border-radius: 14px;
  border: 1px solid #e5e7eb;
  margin-bottom: 30px;
}

.stars {
  display: flex;
  gap: 8px;
  margin-bottom: 15px;
}

.stars span {
  font-size: 32px;
  cursor: pointer;
  color: #ccc;
  border: none;
  outline: none;
  background: none;
  box-shadow: none;
  user-select: none;
  transition: 0.2s;
}

.stars span.active {
  color: gold;       
}

.stars span:hover {
  transform: scale(1.1);
}
.review-form textarea {
  width: 100%;
  min-height: 120px;
  border: 1px solid #d1d5db;
  border-radius: 12px;
  padding: 15px;
  font-size: 15px;
  resize: none;
  outline: none;
  transition: 0.3s;
  background: white;
  box-sizing: border-box;
}

.review-form textarea:focus {
  border-color: #ff6600;
  box-shadow: 0 0 0 4px rgba(255,102,0,0.08);
}

.review-form button {
  margin-top: 18px;
  width: 100%;
  padding: 14px;
  border: none;
  border-radius: 12px;
  background: linear-gradient(135deg, #ff6600, #ff8533);
  color: white;
  font-size: 16px;
  font-weight: 700;
  cursor: pointer;
  transition: 0.3s;
}

.review-form button:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(255,102,0,0.25);
}

.review-list {
  margin-top: 20px;
}

.review-item {
  background: #ffffff;
  border: 1px solid #eeeeee;
  border-radius: 14px;
  padding: 20px;
  margin-bottom: 18px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.04);
  transition: 0.2s;
}

.review-item:hover {
  transform: translateY(-2px);
}

.review-item h4 {
  margin: 0 0 10px;
  font-size: 17px;
  color: #111827;
  font-weight: 700;
}

.review-item p {
  margin: 6px 0;
  color: #4b5563;
  line-height: 1.6;
}

.review-item p:nth-child(2) {
  color: #f59e0b;
  font-size: 18px;
}
</style>
