<template>
<div class="admin-page">

<h2 class="title">Danh sách nhân viên</h2>

<button class="add-btn" @click="addEmployee">
+ Thêm nhân viên
</button>

<table class="employee-table">

<thead>
<tr>
<th>STT</th>
<th>Họ và tên</th>
<th>Ngày sinh</th>
<th>Số điện thoại</th>
<th>Email</th>
<th>Chức vụ</th>
<th>Tình trạng</th>
<th>Thao tác</th>
</tr>
</thead>

<tbody>

<tr v-for="(emp,index) in employees" :key="emp.id">

<td>{{index+1}}</td>
<td>{{emp.name}}</td>
<td>{{emp.birth}}</td>
<td>{{emp.phone}}</td>
<td>{{emp.email}}</td>
<td>{{emp.role}}</td>

<td>
<span 
class="status"
:class="emp.trang_thai === 'hoatdong' ? 'active' : 'lock'"
@click="toggleStatus(emp.id)"
style="cursor:pointer"
>
{{ emp.trang_thai === 'hoatdong' ? 'Hoạt động' : 'Khóa' }}
</span>
</td>

<td class="actions">

<button class="edit-btn" @click="editEmployee(emp)">
✏️ Sửa
</button>

<button class="delete-btn" @click="deleteEmployee(emp.id)">
🗑 Xóa
</button>

</td>

</tr>

</tbody>

</table>

<div v-if="showForm" class="modal">

<div class="modal-box">

<div class="modal-header">
<h3>✏️ {{ isEdit ? "Cập nhật nhân viên" : "Thêm nhân viên" }}</h3>
<span class="close" @click="closeForm">✖</span>
</div>

<div class="form-grid">

<div>
<label>Họ và tên nhân viên</label>
<input v-model="form.name">
</div>

<div>
<label>Ngày sinh</label>
<input type="date" v-model="form.birth">
</div>

<div>
<label>Số điện thoại</label>
<input v-model="form.phone">
</div>

<div>
<label>Email</label>
<input v-model="form.email">
</div>

<div>
<label>Mật khẩu mới (nếu đổi)</label>
<input type="password" v-model="form.password">
</div>

<div>
<label>Ngày bắt đầu làm việc</label>
<input type="date" v-model="form.start_date">
</div>

<div>
<label>Chức vụ</label>
<select v-model="form.role">
<option value="Quản lý">Quản lý</option>
<option value="Nhân viên">Nhân viên</option>
<option value="Kế toán">Kế toán</option>
<option value="Check-in">Check-in</option>
</select>
</div>

</div>

<div class="modal-actions">

<button class="btn-close" @click="closeForm">
Đóng
</button>

<button class="btn-save" @click="saveEmployee">
💾 Lưu thay đổi
</button>

</div>

</div>

</div>

</div>
</template>

<script>
export default{

data(){
return{
employees:[],
showForm:false,
isEdit:false,

form:{
id:null,
name:"",
birth:"",
phone:"",
email:"",
role:"",
password:"",
trang_thai:"hoatdong"
}
}
},

mounted(){
this.getEmployees()
},

methods:{

getEmployees(){
fetch("http://127.0.0.1:8000/api/employees")
.then(res=>res.json())
.then(data=>{
this.employees=data
})
},

toggleStatus(id){
fetch(`http://127.0.0.1:8000/api/employees/${id}/toggle-status`,{
method:"POST"
})
.then(res=>res.json())
.then(()=>{
this.getEmployees()
})
},

addEmployee(){
this.isEdit=false

this.form={
id:null,
name:"",
birth:"",
phone:"",
email:"",
role:"",
password:"",
trang_thai:"hoatdong"
}

this.showForm=true
},

editEmployee(emp){
this.isEdit=true
this.form={...emp, password:""}
this.showForm=true
},

closeForm(){
this.showForm=false
},

saveEmployee(){

let data = { ...this.form }

if(!data.password){
delete data.password
}

if(this.isEdit){

fetch(`http://127.0.0.1:8000/api/employees/${this.form.id}`,{
method:"PUT",
headers:{
"Content-Type":"application/json"
},
body: JSON.stringify(data)
})
.then(()=>{
this.getEmployees()
this.closeForm()
})

}else{

fetch("http://127.0.0.1:8000/api/employees",{
method:"POST",
headers:{
"Content-Type":"application/json"
},
body: JSON.stringify(data)
})
.then(()=>{
this.getEmployees()
this.closeForm()
})

}

},

deleteEmployee(id){

if(!confirm("Bạn có chắc chắn muốn xóa nhân viên này không?")) return

fetch(`http://127.0.0.1:8000/api/employees/${id}`,{
method:"DELETE"
})
.then(res=>res.json())
.then(()=>{
alert("Xóa nhân viên thành công")
this.getEmployees()
})

}

}
}
</script>

<style>

.admin-page{
width:1200px;
margin:auto;
background:white;
padding:20px;
}

.title{
margin-bottom:10px;
}

.add-btn{
background:#007bff;
color:white;
border:none;
padding:8px 15px;
margin-bottom:15px;
cursor:pointer;
}

.employee-table{
width:100%;
border-collapse:collapse;
}

.employee-table th{
background:#f3f3f3;
padding:10px;
border:1px solid #ddd;
}

.employee-table td{
padding:10px;
border:1px solid #ddd;
text-align:center;
}

.status{
padding:4px 10px;
border-radius:4px;
color:white;
font-size:13px;
}

.active{
background:#28a745;
}

.lock{
background:#dc3545;
}

.actions{
display:flex;
justify-content:center;
align-items:center;
gap:10px;
}

.actions button{
width:100px;
height:36px;
border:none;
border-radius:6px;
cursor:pointer;
display:flex;
align-items:center;
justify-content:center;
gap:6px;
font-size:14px;
transition:0.2s;
}

.edit-btn{
background:#f59e0b;
color:white;
}

.edit-btn:hover{
background:#d97706;
transform:scale(1.05);
}

.delete-btn{
background:#ef4444;
color:white;
}

.delete-btn:hover{
background:#dc2626;
transform:scale(1.05);
}

.actions button:active{
transform:scale(0.95);
}

.modal{
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.4);
display:flex;
align-items:center;
justify-content:center;
}

.modal-box{
background:white;
width:650px;
border-radius:6px;
overflow:hidden;
}

.modal-header{
background:#59b0c8;
color:white;
padding:12px 20px;
display:flex;
justify-content:space-between;
align-items:center;
}

.close{
cursor:pointer;
font-size:18px;
}

.form-grid{
display:grid;
grid-template-columns:1fr 1fr;
gap:15px;
padding:20px;
}

.form-grid label{
font-size:14px;
display:block;
margin-bottom:5px;
}

.form-grid input,
.form-grid select{
width:100%;
padding:8px;
border:1px solid #ddd;
border-radius:4px;
}

.modal-actions{
padding:15px;
text-align:right;
border-top:1px solid #eee;
}

.btn-close{
background:#6c757d;
color:white;
border:none;
padding:8px 15px;
margin-right:10px;
cursor:pointer;
}

.btn-save{
background:#5bc0de;
color:white;
border:none;
padding:8px 15px;
cursor:pointer;
}

</style>