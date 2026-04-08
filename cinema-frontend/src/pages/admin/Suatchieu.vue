<template>
<div class="showtime-container">

  <div class="top-bar">
    <button class="create-btn" @click="showForm = true">
      + Tạo Mới Suất Chiếu
    </button>
  </div>

  <div v-if="showForm" class="modal">
    <div class="modal-box">

      <h3>Tạo Suất Chiếu</h3>

      <input v-model="newShow.movie" placeholder="Tên phim" />
      <input type="date" v-model="newShow.date" />
      <input v-model="newShow.room" placeholder="Phòng" />
      <input v-model="newShow.start" placeholder="Giờ bắt đầu" />
      <input v-model="newShow.end" placeholder="Giờ kết thúc" />
      <input v-model="newShow.format" placeholder="Định dạng" />
      <input v-model="newShow.price" placeholder="Giá vé" />

      <div class="modal-actions">
        <button class="save-btn" @click="saveShowtime">Lưu</button>
        <button class="cancel-btn" @click="showForm=false">Hủy</button>
      </div>

    </div>
  </div>

  <div class="room-tabs">
    <button
      v-for="room in rooms"
      :key="room"
      @click="selectRoom(room)"
      :class="{active:selectedRoom===room}"
    >
      {{ room }}
    </button>
  </div>

  <div class="header-row">

    <h3>Danh Sách Suất Chiếu</h3>

    <div class="date-box">
      <button @click="prevDate">‹</button>
      <span>{{ formatDate(selectedDate) }}</span>
      <button @click="nextDate">›</button>
    </div>

    <button
      v-for="show in movieShowtimes"
      :key="show.id"
      class="time-btn"
      @click="selectShow(show)"
    >
      {{ show.start }}
    </button>

  </div>

  <table class="showtime-table">

    <thead>
      <tr>
        <th>#</th>
        <th>Phim</th>
        <th>Phòng</th>
        <th>Giờ Bắt Đầu</th>
        <th>Giờ Kết Thúc</th>
        <th>Định Dạng</th>
        <th>Giá Vé</th>
        <th>Ghế Trống</th>
        <th>Trạng Thái</th>
        <th>Action</th>
      </tr>
    </thead>

    <tbody>
      <tr v-for="(show,index) in filteredShowtimes" :key="show.id">
        <td>{{ index+1 }}</td>
        <td>{{ show.movie }}</td>
        <td>{{ show.room }}</td>
        <td>{{ show.start }}</td>
        <td>{{ show.end }}</td>
        <td>{{ show.format }}</td>
        <td>{{ show.price }} đ</td>

        <td>
          <button class="check-btn">Kiểm tra</button>
        </td>

        <td>
          <span class="status">{{ show.status }}</span>
        </td>

        <td class="action-box">
          <button class="edit-btn" @click="editShow(show)">Sửa</button>
          <button class="delete-btn" @click="deleteShow(show.id)">Xóa</button>
        </td>

      </tr>
    </tbody>

  </table>

</div>
</template>

<script>
export default {

data(){
  return{
    editingId:null,
    showForm:false,
    movie:null,
    newShow:{
      movie:"",
      room:"",
      start:"",
      end:"",
      format:"",
      price:""
    },
    rooms:[
      "Tất cả",
      "Phòng 1",
      "Phòng 2",
      "Phòng 3",
      "Phòng 4",
      "Phòng 5"
    ],
    selectedRoom:"Tất cả",
    selectedDate:new Date(),
    showtimes:[]
  }
},

mounted(){
  const data = localStorage.getItem("showtimes")
  if(data){
    this.showtimes = JSON.parse(data)
  }
},

computed:{

  movieShowtimes(){
    if(!this.movie) return []
    return this.showtimes.filter(
      s => s.movie === this.movie.ten_phim
    )
  },

  filteredShowtimes(){

    const date = this.selectedDate.toISOString().split("T")[0]

    let shows = this.showtimes.filter(
      s => s.date === date
    )

    if(this.selectedRoom !== "Tất cả"){
      shows = shows.filter(
        s => s.room === this.selectedRoom
      )
    }

    return shows
  }

},

methods:{

  editShow(show){
    this.showForm = true
    this.editingId = show.id

    this.newShow = {
      movie: show.movie,
      room: show.room,
      start: show.start,
      end: show.end,
      format: show.format,
      price: show.price
    }
  },

  selectShow(show){
    localStorage.setItem("selectedShow", JSON.stringify(show))
    this.$router.push("/seat")
  },

  selectRoom(room){
    this.selectedRoom = room
  },

  saveShowtime(){

    const date = this.selectedDate.toISOString().split("T")[0]

    if(this.editingId){

      const index = this.showtimes.findIndex(s => s.id === this.editingId)

      this.showtimes[index] = {
        id: this.editingId,
        movie: this.newShow.movie,
        date: date,
        room: this.newShow.room,
        start: this.newShow.start,
        end: this.newShow.end,
        format: this.newShow.format,
        price: this.newShow.price,
        status: "dangchieu"
      }

      this.editingId = null

    }else{

      const show = {
        id: Date.now(),
        movie: this.newShow.movie,
        date: date,
        room: this.newShow.room,
        start: this.newShow.start,
        end: this.newShow.end,
        format: this.newShow.format,
        price: this.newShow.price,
        status: "dangchieu"
      }

      this.showtimes.push(show)

    }

    localStorage.setItem("showtimes", JSON.stringify(this.showtimes))

    this.showForm = false

    this.newShow = {
      movie:"",
      room:"",
      start:"",
      end:"",
      format:"",
      price:""
    }

  },

  deleteShow(id){
    const isConfirm = confirm("Bạn có chắc chắn muốn xóa không?")
    if(!isConfirm) return

    this.showtimes = this.showtimes.filter(s => s.id !== id)

    localStorage.setItem("showtimes", JSON.stringify(this.showtimes))
  },

  formatDate(date){

    const days = [
      "Chủ Nhật","Thứ Hai","Thứ Ba","Thứ Tư",
      "Thứ Năm","Thứ Sáu","Thứ Bảy"
    ]

    const dayName = days[date.getDay()]
    const day = date.getDate()
    const month = date.getMonth() + 1
    const year = date.getFullYear()

    return `${dayName}, ${day} tháng ${month}, ${year}`

  },

  prevDate(){
    this.selectedDate.setDate(this.selectedDate.getDate() - 1)
    this.selectedDate = new Date(this.selectedDate)
  },

  nextDate(){
    this.selectedDate.setDate(this.selectedDate.getDate() + 1)
    this.selectedDate = new Date(this.selectedDate)
  }

}
}
</script>

<style scoped>

.showtime-container {
  background: white;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.top-bar {
  margin-bottom: 15px;
  background: transparent;
}

.create-btn {
  background: #3b82f6;
  color: white;
  border: none;
  padding: 10px 16px;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 500;
}

.room-tabs {
  display: flex;
  gap: 10px;
  margin-bottom: 15px;
}

.room-tabs button {
  border: none;
  background: #e5e7eb;
  padding: 6px 12px;
  border-radius: 6px;
  cursor: pointer;
  color: #111;
  font-weight: 500;
}

.room-tabs button.active {
  background: #3b82f6;
  color: white;
}

.header-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}

.date-box {
  display: flex;
  align-items: center;
  gap: 10px;
}

.date-box button {
  border: none;
  background: #e5e7eb;
  padding: 5px 10px;
  border-radius: 4px;
  cursor: pointer;
  color: #111;
  font-weight: bold;
}

.showtime-table {
  width: 100%;
  border-collapse: collapse;
}

.showtime-table th,
.showtime-table td {
  border: 1px solid #eee;
  padding: 10px;
  text-align: center;
}

.showtime-table th {
  background: #f9fafb;
}

.status {
  background: #38bdf8;
  color: white;
  padding: 4px 8px;
  border-radius: 4px;
  font-size: 12px;
}

.check-btn {
  background: #3b82f6;
  color: white;
  border: none;
  padding: 4px 10px;
  border-radius: 4px;
  cursor: pointer;
}

.modal {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0,0,0,0.4);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-box {
  background: white;
  padding: 20px;
  border-radius: 8px;
  width: 300px;
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.modal-box input {
  padding: 8px;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.modal-actions {
  display: flex;
  gap: 10px;
}

.modal-actions button {
  flex: 1;
  height: 42px;
  text-align: center;
  color: white;
  border: none;
  padding: 6px 12px;
  border-radius: 4px;
  cursor: pointer;
}

.save-btn {
  background: #22c55e;
}

.cancel-btn {
  margin-top: 20px;
  background: #ef4444;
}

.showtime-table .action-box {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 8px;
}

.showtime-table .action-box button {
  width: 80px;
  height: 36px;
  border-radius: 6px;
  font-size: 14px;
  cursor: pointer;
  transition: all 0.3s;
}

.showtime-table .action-box .edit-btn {
  background: #f59e0b;
  color: white;
  border: none;
}

.showtime-table .action-box .edit-btn:hover {
  background: #d97706;
  transform: scale(1.05);
  box-shadow: 0 4px 10px rgba(0,0,0,0.3);
}

.showtime-table .action-box .delete-btn {
  background: #ef4444;
  color: white;
  border: 2px solid #ef4444;
}

.showtime-table .action-box .delete-btn:hover {
  background: #dc2626;
  border-color: #dc2626;
  transform: scale(1.05);
  box-shadow: 0 4px 10px rgba(0,0,0,0.3);
}

</style>