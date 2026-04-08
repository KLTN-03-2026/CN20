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

        <div v-if="tab === 'review'">
          <p>Chưa có đánh giá nào cho phim này.</p>
        </div>
      </div>

      <div class="bottom">
        <button class="btn-book">ĐẶT VÉ</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      movie: {},
      tab: "detail"
    }
  },

  mounted() {
    const slug = this.$route.params.slug;
    fetch("http://127.0.0.1:8000/api/movies/" + slug)
      .then(res => res.json())
      .then(data => {
        this.movie = data;
      })
      .catch(err => console.error("Lỗi khi tải dữ liệu:", err));
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
</style>
