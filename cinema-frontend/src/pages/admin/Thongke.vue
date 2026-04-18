<template>
  <div class="dashboard">
    <h2 class="title">Thống Kê Doanh Thu</h2>

    <div class="stats">
      <div class="card revenue">
        <div class="icon">💰</div>
        <div>
          <p>Tổng doanh thu</p>
          <h3>{{ totalRevenue }} VNĐ</h3>
        </div>
      </div>

      <div class="card orders">
        <div class="icon">🛒</div>
        <div>
          <p>Tổng số vé</p>
          <h3>{{ totalTickets }} đơn</h3>
        </div>
      </div>
    </div>

    <div class="filter">
      <label>Chọn ngày</label>
      <input type="date" v-model="date" @change="fetchDashboard">
    </div>

    <div class="charts">
      <canvas id="revenueChart"></canvas>
      <canvas id="movieChart"></canvas>
      <canvas id="hourChart"></canvas>
    </div>
    <div class="monthly-chart-box">
  <h3>Doanh Thu Theo Tháng</h3>
  <canvas id="monthlyChart"></canvas>
</div>
    <div class="room-stats">
      <h3>Tỷ lệ lấp đầy ghế</h3>

      <table>
        <thead>
          <tr>
            <th>Phim</th>
            <th>Phòng</th>
            <th>Ghế bán</th>
            <th>Tổng ghế</th>
            <th>Tỷ lệ</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="room in roomStats" :key="room.room">
            <td>{{ room.movie }}</td>
            <td>{{ room.room }}</td>
            <td>{{ room.soldSeats }}</td>
            <td>{{ room.totalSeats }}</td>
            <td>{{ room.fillRate }}%</td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>
</template>

<script>
import Chart from "chart.js/auto"
import axios from "axios"

export default {
  data() {
    return {
      totalRevenue: 0,
      totalTickets: 0,
      date: "",
      revenueChart: null,
      movieChart: null,
      hourChart: null,
      interval: null,
      roomStats: [],
      monthlyChart: null
    }
  },

  mounted() {
    this.fetchDashboard()
  },

  beforeUnmount() {
    clearInterval(this.interval)
  },

  methods: {
    async fetchDashboard() {
  try {
    const res = await axios.get("http://127.0.0.1:8000/api/admin/dashboard", {
      params: { date: this.date }
    })

    console.log(res.data)

    this.totalRevenue = res.data.totalRevenue
    this.totalTickets = res.data.totalTickets
    this.roomStats = res.data.roomStats
    this.renderMonthlyChart(res.data.monthlyChart)
    this.renderRevenueChart(res.data.revenueByDay)
    this.renderMovieChart(res.data.topMovies)
    this.renderHourChart(res.data.peakHours)

  } catch (e) {
    console.log("API lỗi", e)
  }
},
renderMonthlyChart(data) {
  if (!data) return

  const months = Array.from({ length: 12 }, (_, i) => `Tháng ${i + 1}`)
  const totals = Array(12).fill(0)

  data.forEach(item => {
    totals[item.month - 1] = item.total
  })

  if (this.monthlyChart) this.monthlyChart.destroy()

  this.$nextTick(() => {
    const ctx = document.getElementById("monthlyChart")

    if (!ctx) return

    this.monthlyChart = new Chart(ctx, {
      type: "bar",
      data: {
        labels: months,
        datasets: [{
          label: "Doanh thu tháng",
          data: totals,
          backgroundColor: "#9C27B0"
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false
      }
    })
  })
},

    renderRevenueChart(data) {
      const labels = data.map(i => i.date)
      const totals = data.map(i => i.total)

      if (this.revenueChart) this.revenueChart.destroy()

      this.$nextTick(() => {
        const ctx = document.getElementById("revenueChart")

        this.revenueChart = new Chart(ctx, {
          type: "line",
          data: {
            labels,
            datasets: [{
              label: "Doanh thu 7 ngày",
              data: totals
            }]
          }
        })
      })
    },

    renderMovieChart(data) {
      const labels = data.map(i => i.name)
      const totals = data.map(i => i.revenue)

      if (this.movieChart) this.movieChart.destroy()

      this.$nextTick(() => {
        const ctx = document.getElementById("movieChart")

        this.movieChart = new Chart(ctx, {
          type: "bar",
          data: {
            labels,
            datasets: [{
              label: "Top phim",
              data: totals
            }]
          }
        })
      })
    },

    renderHourChart(data) {
      const labels = data.map(i => i.hour)
      const totals = data.map(i => i.total)

      if (this.hourChart) this.hourChart.destroy()

      this.$nextTick(() => {
        const ctx = document.getElementById("hourChart")

        this.hourChart = new Chart(ctx, {
          type: "bar",
          data: {
            labels,
            datasets: [{
              label: "Giờ đông khách",
              data: totals,
              backgroundColor: "#36A2EB"
            }]
          },
          options: {
            responsive: true,
            scales: {
              y: {
                beginAtZero: true,
                ticks: {
                  stepSize: 1,
                  precision: 0
                }
              }
            }
          }
        })
      })
    }
  }
}
</script>

<style scoped>
.dashboard{
  padding:30px;
  background:linear-gradient(135deg,#eef2f7,#f8fbff);
  min-height:100vh;
}

.title{
  text-align:center;
  margin-bottom:35px;
  font-size:32px;
  font-weight:700;
  color:#1e293b;
  letter-spacing:1px;
}

.stats{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
  gap:25px;
  margin-bottom:35px;
}

.card{
  display:flex;
  align-items:center;
  gap:18px;
  padding:25px;
  border-radius:20px;
  color:white;
  box-shadow:0 10px 25px rgba(0,0,0,0.08);
  transition:all .3s ease;
  cursor:pointer;
}

.card:hover{
  transform:translateY(-6px) scale(1.02);
  box-shadow:0 18px 30px rgba(0,0,0,0.15);
}

.card h3{
  font-size:24px;
  margin-top:5px;
}

.card p{
  font-size:14px;
  opacity:0.9;
}

.revenue{
  background:linear-gradient(135deg,#00c6ff,#0072ff);
}

.orders{
  background:linear-gradient(135deg,#ff9966,#ff5e62);
}

.icon{
  font-size:38px;
  background:rgba(255,255,255,0.2);
  padding:15px;
  border-radius:15px;
}

.filter{
  margin-bottom:25px;
}

.filter label{
  font-weight:600;
  margin-right:10px;
  color:#334155;
}

.filter input{
  padding:10px 15px;
  border-radius:10px;
  border:none;
  background:white;
  box-shadow:0 4px 10px rgba(0,0,0,0.05);
}

.charts{
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:25px;
}

.charts canvas{
  background:white;
  padding:20px;
  border-radius:20px;
  box-shadow:0 8px 20px rgba(0,0,0,0.06);
  height:220px !important;
  width:100% !important;
}

.monthly-chart-box{
  margin-top:35px;
  background:white;
  padding:25px;
  border-radius:20px;
  box-shadow:0 8px 20px rgba(0,0,0,0.06);
}

.monthly-chart-box h3{
  margin-bottom:20px;
  color:#1e293b;
}

.monthly-chart-box canvas{
  width:100% !important;
  height:400px !important;
}

.room-stats{
  margin-top:35px;
  background:white;
  padding:25px;
  border-radius:20px;
  box-shadow:0 8px 20px rgba(0,0,0,0.06);
}

.room-stats h3{
  margin-bottom:20px;
  color:#1e293b;
}

.room-stats table{
  width:100%;
  border-collapse:collapse;
  overflow:hidden;
  border-radius:15px;
}

.room-stats th{
  background:#2563eb;
  color:white;
  padding:15px;
  font-weight:600;
}

.room-stats td{
  padding:15px;
  text-align:center;
  border-bottom:1px solid #eee;
}

.room-stats tbody tr:nth-child(even){
  background:#f8fafc;
}

.room-stats tbody tr:hover{
  background:#e0f2fe;
  transition:0.3s;
}

@media(max-width:992px){
  .charts{
    grid-template-columns:1fr;
  }

  .stats{
    grid-template-columns:1fr;
  }
}
</style>
