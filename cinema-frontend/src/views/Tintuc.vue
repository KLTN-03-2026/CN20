<template>
  <div class="news-wrapper">
    <div class="news-container">
      <h1 class="title">TIN TỨC PHIM</h1>
      <div class="news-grid">
        <div v-for="item in sortedNews" :key="item.id" class="news-card">
          <img :src="item.image" class="news-img" />
          <h3 @click="goDetail(item.slug)" class="news-title">
            {{ item.title }}
            </h3>
          <p>{{ item.desc }}</p>
          <span class="read-more">Xem thêm →</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import hinh1 from '@/assets/hinh1.jpg'
import hinh2 from '@/assets/hinh2.jpg'
import hinh3 from '@/assets/hinh3.jpg'
export default {
  data() {
    return {
      sort: 'new',
      news: [
        {
        slug: 'phim-hot-thang-4',
          id: 1,
          title: 'DANH SÁCH NHỮNG BỘ PHIM HOT THÁNG 4',
          desc: 'Tháng 4 này, màn ảnh rộng bùng nổ với loạt phim bom tấn đủ mọi thể loại, từ hành động mãn nhãn, kinh dị rùng rợn đến hài hước sảng khoái. Nếu bạn đang tìm ki...',
          image: hinh1
        },
        {
        slug: 'nhung-chi-tiet-an-tuong-conan-movie-27-ngoi-sao-5-canh-1-trieu-do',
          id: 2,
          title: 'Những Chi Tiết Ấn Tượng Của Conan Movie 27: Ngôi Sao 5 Cánh 1 Triệu Đô',
          desc: 'Thám Tử Lừng Danh Conan Movie 27: Ngôi Sao 5 Cánh 1 Triệu Đô chính là một trong những bộ phim đang được săn đón nhất tại các rạp phim trong tháng 8 này.',
          image: hinh2
        },
        {
        slug: 'con-cam-2024-bung-no',
          id: 3,
          title: 'CON CÁM 2024 BÙNG NỔ',
          desc: 'Tấm cám vốn là một câu chuyện dân gian của Việt Nam được đưa vào khá nhiều các dự án điện ảnh..',
          image: hinh3
        }
      ]
    }
  },
  methods: {
  goDetail(slug) {
    this.$router.push(`/tintuc/${slug}`)
  }
},
  computed: {
    sortedNews() {
      if (this.sort === 'view') {
        return [...this.news].sort((a, b) => b.views - a.views)
      }
      return this.news
    }
}
}
</script>

<style scoped>
.news-wrapper {
  background: #f2f2f2;
  padding: 40px 0;
  display: flex;
  justify-content: center;
}

.news-container {
  background: #fff;
  width: 1200px;
  padding: 30px;
  border-radius: 12px;
}

.title {
  text-align: center;
  margin-bottom: 25px;
}
.news-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 25px;
}
.news-img {
  width: 100%;
  height: 240px;
  object-fit: cover;
}

.read-more {
  color: #007bff;
  cursor: pointer;
}
</style>