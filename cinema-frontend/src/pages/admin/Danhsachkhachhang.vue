<template>

<div>

<h2>Quản lý khách hàng</h2>

<table class="user-table">

<thead>
<tr>
<th>STT</th>
<th>Tên</th>
<th>Email</th>
<th>Số điện thoại</th>
<th>Ngày sinh</th>
<th>Role</th>
<th>Trạng thái</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<tr v-for="(user,index) in filteredUsers" :key="user.id">

<td>{{ index + 1 }}</td>
<td>{{ user.name }}</td>
<td>{{ user.email }}</td>
<td>{{ user.phone }}</td>
<td>{{ user.birth }}</td>
<td>{{ user.role }}</td>

<td>

<button
:class="user.trang_thai === 'hoatdong' ? 'active-btn' : 'lock-btn'"
@click="toggleStatus(user.id)"
>
{{ user.trang_thai === "hoatdong" ? "Hoạt động" : "Khóa" }}
</button>

</td>

<td class="actions">
<button class="delete-btn" @click="deleteUser(user.id)">
Xóa
</button>
</td>

</tr>

</tbody>

</table>

</div>

</template>

<script>

import axios from "axios"

export default {

data(){
return{
users:[]
}
},

computed:{
filteredUsers(){
return this.users.filter(u => u.role === 'user')
}
},

mounted(){
this.getUsers()
},

methods:{

deleteUser(id){

if(confirm("Bạn có chắc muốn xóa người dùng này không?")){

axios.delete("http://127.0.0.1:8000/api/users/" + id)

.then(()=>{
alert("Xóa thành công!")
this.getUsers()
})

.catch(error=>{
console.log(error)
alert("Xóa thất bại!")
})

}

},

getUsers(){

axios.get("http://127.0.0.1:8000/api/users")

.then(res=>{
this.users = res.data
})

.catch(error=>{
console.log(error)
})

},

toggleStatus(id){

axios.post("http://127.0.0.1:8000/api/users/"+id+"/toggle-status")

.then(()=>{
this.getUsers()
})

.catch(error=>{
console.log(error)
})

}

}

}

</script>

<style scoped>

.user-table{
width:100%;
border-collapse: collapse;
margin-top:20px;
}

.user-table th,
.user-table td{
border:1px solid #ccc;
padding:10px;
text-align:center;
vertical-align: middle;
}

.user-table th{
background:#f5f5f5;
font-weight:bold;
}

.active-btn{
background:#28a745;
color:white;
border:none;
width:90px;
height:32px;
border-radius:6px;
cursor:pointer;
}

.lock-btn{
background:#dc3545;
color:white;
border:none;
width:90px;
height:32px;
border-radius:6px;
cursor:pointer;
}

.actions{
display:flex;
justify-content:center;
align-items:center;
gap:10px;
}

.delete-btn{
background:#ef4444;
color:white;
border:none;
width:80px;
height:32px;
border-radius:6px;
font-weight:bold;
cursor:pointer;
display:flex;
align-items:center;
justify-content:center;
transition:0.2s;
}

.delete-btn:hover{
background:#dc2626;
transform:scale(1.05);
}

.delete-btn:active{
transform:scale(0.95);
}

</style>