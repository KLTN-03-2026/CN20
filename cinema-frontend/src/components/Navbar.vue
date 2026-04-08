<template>
  <div>

    <div class="top-bar">
      HOTLINE: 0905434110 | GIỜ MỞ CỬA: 9:00 - 22:00
    </div>

    <div class="navbar">

      <router-link to="/" class="logo">RIO CINEMA</router-link>

      <div class="menu">

        <div class="dropdown">
          <button class="drop-btn" @click="toggleDropdown">
            PHIM
          </button>

          <div class="dropdown-content" v-if="showDropdown">
            <router-link to="/phimdangchieu">Phim đang chiếu</router-link>
            <router-link to="/phimsapchieu">Phim sắp chiếu</router-link>
          </div>
        </div>

        <router-link to="/magiamgia" >
          MÃ GIẢM GIÁ
        </router-link>

        <router-link to="/tintuc">
          TIN TỨC PHIM
        </router-link>

      </div>

      <div class="login">

        <div v-if="!user">
          <router-link to="/login">ĐĂNG NHẬP</router-link>
          /
          <router-link to="/register">ĐĂNG KÝ</router-link>
        </div>

        <div v-else>
          <router-link to="/profile" class="profile-link">
            <b>{{ user.name }}</b>
          </router-link>

          <button class="logout-btn" @click="logout">
            Đăng xuất
          </button>
        </div>

      </div>

    </div>

  </div>
</template>

<script>
export default {

  data(){
    return{
      user: null,
      showDropdown: false
    }
  },

  mounted(){
    const u = localStorage.getItem("currentUser")
    if(u){
      this.user = JSON.parse(u)
    }
  },

  methods:{

    logout(){
      localStorage.removeItem("currentUser")
      this.user = null
      this.$router.push("/login")
    },

    toggleDropdown(){
      this.showDropdown = !this.showDropdown
    }

  }

}
</script>

<style>

.top-bar{
  background:#111827;
  color:#ccc;
  text-align:right;
  padding:8px 50px;
  font-size:14px;
}

.navbar{
  background:#0f172a;
  display:flex;
  justify-content:space-between;
  align-items:center;
  padding:15px 50px;
  border-bottom:1px solid #1f2937;
  position:sticky;
  top:0;
  z-index:1000;
}

.logo{
  text-decoration:none;
  font-weight:bold;
  font-size:20px;
  color:orange;
}

.menu{
  display:flex;
  gap:25px;
}

.menu a{
  color:#ddd;
  text-decoration:none;
  font-weight:bold;
}

.menu a:hover{
  color:orange;
}

.login a{
  color:orange;
  text-decoration:none;
  font-weight:bold;
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

.dropdown{
  position:relative;
}

.drop-btn{
  background:none;
  border:none;
  color:#ddd;
  font-weight:bold;
  text-decoration:none;
  cursor:pointer;
  font-size:16px;
  padding:0;
  margin:0;
  display:flex;
  align-items:center;
  height:100%;
}

.drop-btn:hover{
  color:orange;
}

.dropdown-content{
  position:absolute;
  top:30px;
  left:0;
  background:#1f2937;
  padding:10px 0;
  border-radius:6px;
  min-width:200px;
  display:flex;
  flex-direction:column;
  box-shadow:0 4px 10px rgba(0,0,0,0.3);
  z-index:999;
}

.dropdown-content a{
  padding:10px 15px;
  text-decoration:none;
  color:#ddd;
  font-weight:bold;
  display:block;
}

.dropdown-content a:hover{
  background:#374151;
  color:orange;
}

</style>