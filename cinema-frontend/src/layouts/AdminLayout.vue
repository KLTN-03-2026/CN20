<template>
  <div class="admin-container">

    <div class="header">
      <div class="logo">RIO CINEMA</div>

      <div class="admin-info">
        <img src="https://i.pravatar.cc/40" class="avatar">
        <span>Admin</span>
        <button class="logout-btn" @click="logout">Đăng xuất</button>
      </div>
    </div>

    <div class="menu">

      <router-link to="/admin/dashboard">Thống kê</router-link>
      <router-link to="/admin/movies">Quản lý phim</router-link>

      <div class="dropdown">
        <span class="dropbtn" @click="toggleMenu('lichchieu')">
          Lịch chiếu ▾
        </span>

        <div class="dropdown-content" v-if="activeMenu === 'lichchieu'">
          <router-link to="/admin/seats">Ghế</router-link>
          <router-link to="/admin/rooms">Phòng</router-link>
          <router-link to="/admin/showtimes">Suất chiếu</router-link>
        </div>
      </div>

      <router-link to="/admin/vouchers">Mã giảm giá</router-link>

      <div class="dropdown">
        <span class="dropbtn" @click="toggleMenu('user')">
          Người dùng ▾
        </span>

        <div class="dropdown-content" v-if="activeMenu === 'user'">
          <router-link to="/admin/customers">Khách hàng</router-link>
          <router-link to="/admin/employees">Nhân viên</router-link>
        </div>
      </div>

      <router-link to="/admin/payments">Quản lý thanh toán</router-link>
      <router-link to="/admin/chatbot">Chatbot AI</router-link>

    </div>

    <div class="content">
      <router-view />
    </div>

  </div>
</template>

<script>
export default {

  data(){
    return{
      activeMenu:null
    }
  },

  methods:{

    toggleMenu(name){
      this.activeMenu = this.activeMenu === name ? null : name
    },

    logout(){
      localStorage.removeItem("admin")
      this.$router.push("/login")
    }

  }

}
</script>

<style scoped>

.admin-container{
  font-family: Arial;
}

.header{
  background:#162a63;
  color:white;
  padding:15px;
  display:flex;
  justify-content:space-between;
  align-items:center;
}

.logo{
  font-size:20px;
  font-weight:bold;
}

.admin-info{
  display:flex;
  align-items:center;
  gap:10px;
}

.avatar{
  border-radius:50%;
}

.menu{
  background:#f5f5f5;
  padding:10px 20px;
  display:flex;
  align-items:center;
  gap:25px;
}

.menu a{
  text-decoration:none;
  color:black;
  font-weight:500;
}

.dropdown{
  position:relative;
}

.dropbtn{
  cursor:pointer;
  font-weight:500;
}

.dropdown-content{
  position:absolute;
  top:100%;
  left:0;
  background:white;
  min-width:160px;
  border:1px solid #ddd;
  box-shadow:0 2px 10px rgba(0,0,0,0.15);
  z-index:100;
}

.dropdown-content a{
  display:block;
  padding:10px;
  color:black;
  text-decoration:none;
}

.dropdown-content a:hover{
  background:#f0f0f0;
}

.content{
  padding:20px;
}

</style>