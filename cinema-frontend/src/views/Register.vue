<template>
<div class="register-page">

<div class="tabs">
<router-link to="/login" class="tab">ĐĂNG NHẬP</router-link>
<div class="tab active">ĐĂNG KÝ</div>
</div>

<form class="register-form" @submit.prevent="register">

<div class="form-grid">

<div class="form-group">
<label>Họ Tên</label>
<input v-model="form.name" placeholder="Nhập Họ Tên">
</div>

<div class="form-group">
<label>Giới Tính</label>
<div class="radio">
<label><input type="radio" value="Nam" v-model="form.gender"> Nam</label>
<label><input type="radio" value="Nữ" v-model="form.gender"> Nữ</label>
</div>
</div>

<div class="form-group">
<label>Ngày Sinh</label>
<input type="date" v-model="form.birth">
</div>

<div class="form-group">
<label>Số CMND</label>
<input v-model="form.cmnd" placeholder="Nhập CMND">
</div>

<div class="form-group">
<label>Số Điện Thoại</label>
<input v-model="form.phone" placeholder="Nhập số điện thoại">
</div>

<div class="form-group">
<label>Email</label>
<input v-model="form.email" placeholder="Nhập email">
</div>

<div class="form-group">
<label>Mật khẩu</label>
<input type="password" v-model="form.password" placeholder="Nhập mật khẩu">
</div>

<div class="form-group">
<label>Xác nhận mật khẩu</label>
<input type="password" v-model="form.password_confirmation" placeholder="Nhập lại mật khẩu">
</div>

<div class="form-group">
<label>Thành Phố</label>
<select v-model="form.city">
<option value="">Chọn thành phố</option>
<option>Đà Nẵng</option>
<option>Hà Nội</option>
<option>Hồ Chí Minh</option>
</select>
</div>

<div class="form-group">
<label>Quận/Huyện</label>
<select v-model="form.district">
<option value="">Chọn quận</option>
<option>Hải Châu</option>
<option>Sơn Trà</option>
<option>Thanh Khê</option>
<option>Liên Chiểu</option>
</select>
</div>

</div>

<button type="submit" class="btn-register">
ĐĂNG KÝ
</button>

</form>

</div>
</template>

<script>
export default {

data(){
return{
form:{
name:"",
gender:"",
birth:"",
cmnd:"",
phone:"",
email:"",
password:"",
password_confirmation:"",
city:"",
district:""
}
}
},

methods:{
async register(){

if(this.form.password !== this.form.password_confirmation){
alert("Mật khẩu không khớp")
return
}

try{

const res = await fetch("http://127.0.0.1:8000/api/register",{
method:"POST",
headers:{
"Content-Type":"application/json",
"Accept":"application/json"
},
body:JSON.stringify({
name:this.form.name,
email:this.form.email,
password:this.form.password,
password_confirmation:this.form.password_confirmation,
gender:this.form.gender,
birth:this.form.birth,
phone:this.form.phone,
cmnd:this.form.cmnd,
city:this.form.city,
district:this.form.district,
address:this.form.address
})
})

const data = await res.json()

if(!res.ok){
alert(data.message || "Đăng ký thất bại")
return
}

alert("Đăng ký thành công")

this.$router.push("/login")

}catch(error){

console.log(error)
alert("Không kết nối được server")

}

}
}
}
</script>

<style>

.register-page{
width:800px;
margin:auto;
padding:40px;
background:white; 
 box-shadow:0 0 15px rgba(0,0,0,0.2);
}

.tabs{
display:flex;
gap:20px;
margin-bottom:20px;
}

.tab{
padding:10px 20px;
border:1px solid #ccc;
cursor:pointer;
}

.active{
background:#e71a0f;
color:white;
}

.form-grid{
display:grid;
grid-template-columns:1fr 1fr;
gap:20px;
}

.form-group{
display:flex;
flex-direction:column;
}

input,select{
padding:8px;
border:1px solid #ccc;
}

.radio{
display:flex;
gap:10px;
}

.btn-register{
margin-top:20px;
padding:12px;
background:#e71a0f;
color:white;
border:none;
cursor:pointer;
}

</style>