<template>
  <div class="dashboard">
    <h2 class="title">Thống Kê Doanh Thu</h2>

    <!-- Thống kê -->
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
          <h3>{{ totalOrders }} đơn</h3>
        </div>
      </div>
    </div>

    <!-- Bộ lọc -->
    <div class="filter">
      <label>Chọn ngày</label>
      <input type="date" v-model="date">
    </div>

    <!-- Biểu đồ -->
    <div class="chart-box">
      <canvas id="revenueChart"></canvas>
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
      totalOrders: 0,
      date: "",
      chart: null
    }
  },

  mounted() {
    this.getStats()
    this.createChart()

    setInterval(() => {
      this.getStats()
      this.createChart()
    }, 5000)
  },

  watch: {
    date() {
      this.createChart()
    }
  },

  methods: {
    async getStats() {
      const res = await axios.get("http://127.0.0.1:8000/api/admin/stats")
      this.totalRevenue = res.data.revenue
      this.totalOrders = res.data.orders
    },

    async createChart() {
      const res = await axios.get("http://127.0.0.1:8000/api/revenue-chart")

      const labels = []
      const totals = new Array(24).fill(0)

      for (let i = 0; i < 24; i++) {
        labels.push(i + ":00")
      }

      res.data.forEach(item => {
        totals[item.hour] = item.total
      })

      if (!this.chart) {
        const ctx = document.getElementById("revenueChart")

        this.chart = new Chart(ctx, {
          type: "bar",
          data: {
            labels: labels,
            datasets: [
              {
                label: "Doanh thu",
                data: totals,
                backgroundColor: "#4A90E2"
              }
            ]
          }
        })
      } else {
        this.chart.data.datasets[0].data = totals
        this.chart.update()
      }

      setInterval(() => {
        this.createChart()
      }, 3000)
    }
  }
}
</script>

<style scoped>
.dashboard {
  padding: 30px;
  background: #f5f6fa;
}

.title {
  text-align: center;
  margin-bottom: 30px;
}

.stats {
  display: flex;
  gap: 30px;
  margin-bottom: 30px;
}

.card {
  flex: 1;
  display: flex;
  align-items: center;
  gap: 15px;
  padding: 20px;
  border-radius: 10px;
  color: white;
}

.revenue {
  background: linear-gradient(90deg, #4CAF50, #2196F3);
}

.orders {
  background: linear-gradient(90deg, #4CAF50, #2196F3);
}

.icon {
  font-size: 30px;
}

.filter {
  margin-bottom: 20px;
}

.chart-box {
  background: white;
  padding: 20px;
  border-radius: 10px;
}
</style>
