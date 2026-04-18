<template>
  <div class="login-page">

    <h2>Đăng nhập</h2>

    <form @submit.prevent="login">

      <input
        v-model="username"
        type="text"
        placeholder="Email"
        required
      />

      <input
        v-model="password"
        type="password"
        placeholder="Mật khẩu"
        required
      />

      <button type="submit">Đăng nhập</button>

    </form>
    <p class="register-link">
  Bạn chưa có tài khoản ?
  <span @click="$router.push('/register')">Đăng ký</span>
</p>

  </div>
</template>

<script>
import axios from "axios"

export default {

  data(){
    return{
      username:"",
      password:""
    }
  },

  methods:{

    async login(){

      if(!this.username || !this.password){
        alert("Vui lòng nhập đầy đủ thông tin")
        return
      }

      try{

        const response = await axios.post(
          "http://127.0.0.1:8000/api/login",
          {
            email: this.username,
            password: this.password
          }
        )

       const user = response.data.user


        localStorage.setItem("currentUser", JSON.stringify(user))


        localStorage.setItem("memberCard", JSON.stringify(user.member))

        console.log("member:", user.member)

        alert("Đăng nhập thành công")

        if(user.role === "admin"){
          this.$router.push("/admin/dashboard")
        }else{
          this.$router.push("/")
        }

      }catch(error){

        if(error.response && error.response.data.message){
          alert(error.response.data.message)
        }else{
          alert("Sai tài khoản hoặc mật khẩu")
        }

      }

    }

  }

}
</script>

<style>

.login-page{
  width:350px;
  margin:100px auto;
  padding:30px;
  background:#111827;
  border-radius:10px;
  text-align:center;
}

.login-page h2{
  color:white;
  margin-bottom:20px;
}
.login-page input{
  width:100%;
  padding:10px;
  margin:10px 0;
  border:none;
  border-radius:5px;
}

.login-page button{
  width:100%;
  padding:10px;
  background:orange;
  border:none;
  border-radius:5px;
  font-weight:bold;
  cursor:pointer;
}
.register-link{
  margin-top:15px;
  color:#ccc;
}

.register-link span{
  color:orange;
  cursor:pointer;
  font-weight:bold;
}

.register-link span:hover{
  text-decoration:underline;
}
</style>
