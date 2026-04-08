<template>
<div>

<router-link to="/admin/vouchers" class="menu-link">Mã giảm giá</router-link>

<div class="card">

<div class="card-header">
<div class="search-box">
<input v-model="search" placeholder="Tìm kiếm theo mã giảm giá" />
<span class="icon">🔍</span>
</div>

<button class="add-btn" @click="openForm()">+ Thêm mới</button>
</div>

<table class="table">
<thead>
<tr>
<th>STT</th>
<th>Mã giảm giá</th>
<th>Loại chiết khấu</th>
<th>Giá trị chiết khấu</th>
<th>Ngày bắt đầu</th>
<th>Ngày kết thúc</th>
<th>Hành động</th>
</tr>
</thead>

<tbody>
<tr v-for="(v,i) in filteredVouchers" :key="v.id">
<td>{{ i+1 }}</td>
<td>{{ v.code }}</td>
<td>Giá tiền cố định</td>
<td>{{ formatPrice(v.value) }}</td>
<td>{{ v.start }}</td>
<td>{{ v.end }}</td>

<td>
<span class="edit" @click="edit(v)">✏️</span>
<span class="delete" @click="remove(v.id)">🗑️</span>
</td>

</tr>
</tbody>
</table>

</div>

<div v-if="showForm" class="modal">

<div class="form-container">

<div class="form-header">
<h3>{{ editingId ? 'Cập nhật mã' : 'Thêm mã giảm giá' }}</h3>
<span class="close" @click="showForm=false">×</span>
</div>

<div class="form-body">

<div class="form-group">
<label>Mã giảm giá</label>
<input v-model="form.code" placeholder="VD: LVMT2004" />
</div>

<div class="form-group">
<label>Loại chiết khấu</label>
<input value="Giá tiền cố định" disabled />
</div>

<div class="form-group">
<label>Giá trị chiết khấu</label>
<input type="number" v-model="form.value" />
</div>

<div class="form-group-inline">

<div>
<label>Ngày bắt đầu</label>
<input type="date" v-model="form.start" />
</div>

<div>
<label>Ngày kết thúc</label>
<input type="date" v-model="form.end" />
</div>

</div>

</div>

<div class="form-footer">
<button class="btn-save" @click="save">Lưu</button>
<button class="btn-cancel" @click="showForm=false">Hủy</button>
</div>

</div>

</div>

</div>
</template>

<script>
export default {

data(){
return{
vouchers: [],
showForm:false,
editingId:null,
search:"",

form:{
code:"",
value: "",
start:"",
end:""
}
}
},

computed:{
filteredVouchers(){
return this.vouchers.filter(v =>
v.code.toLowerCase().includes(this.search.toLowerCase())
)
}
},

async mounted(){
let res = await fetch("http://localhost:8000/api/vouchers")
this.vouchers = await res.json()
},

methods:{

formatPrice(value){
return Number(value).toLocaleString() + " đ"
},

openForm(){
this.showForm = true
this.editingId = null
this.form = {
code:"",
type:"fixed",
value: "",
start:"",
end:""
}
},

edit(v){
this.showForm = true
this.editingId = v.id
this.form = {...v}
},

async save(){

if(!this.form.code || !this.form.value || !this.form.start || !this.form.end){
alert("Nhập đầy đủ thông tin")
return
}

let res = await fetch("http://localhost:8000/api/vouchers", {
method:"POST",
headers:{
"Content-Type":"application/json"
},
body: JSON.stringify(this.form)
})

let data = await res.json()

this.vouchers.push(data)
this.showForm = false
},

async remove(id){

if(confirm("Bạn có chắc chắn xóa?")){

await fetch(`http://localhost:8000/api/vouchers/${id}`, {
method:"DELETE"
})

this.vouchers = this.vouchers.filter(v => v.id !== id)

}

}

}

}
</script>

<style scoped>

.menu-link{
text-decoration:none;
color:#111;
font-weight:500;
padding:6px 10px;
border-radius:6px;
transition:0.2s;
}

.menu-link:hover{
background:#e5e7eb;
}

.router-link-active{
background:#3b82f6;
color:#fff !important;
}

.card{
background:#fff;
border-radius:10px;
padding:20px;
box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

.card-header{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:15px;
}

.search-box{
position:relative;
width:260px;
}

.search-box input{
width:100%;
height:36px;
padding:0 35px 0 12px;
border:1px solid #ddd;
border-radius:8px;
font-size:14px;
box-sizing:border-box;
background:#fff;
}

.search-box .icon{
position:absolute;
right:8px;
top:0;
height:100%;
display:flex;
align-items:center;
justify-content:center;
color:#888;
font-size:14px;
pointer-events:none;
background:none;
}

.add-btn{
border:1px solid #3b82f6;
background:#fff;
color:#3b82f6;
padding:8px 14px;
border-radius:8px;
cursor:pointer;
font-weight:500;
}

.add-btn:hover{
background:#3b82f6;
color:#fff;
}

.table{
width:100%;
border-collapse:collapse;
}

.table th{
text-align:left;
padding:10px;
font-size:13px;
color:#555;
border-bottom:1px solid #eee;
}

.table td{
padding:12px 10px;
border-bottom:1px solid #f0f0f0;
font-size:14px;
}

.table tbody tr:hover{
background:#fafafa;
}

.edit{
color:#22c55e;
margin-right:10px;
cursor:pointer;
}

.delete{
color:#ef4444;
cursor:pointer;
}

.modal{
position:fixed;
top:0;
left:0;
right:0;
bottom:0;
background:rgba(0,0,0,0.4);
display:flex;
justify-content:center;
align-items:center;
z-index:1000;
}

.form-container{
width:400px;
background:#fff;
border-radius:12px;
overflow:hidden;
box-shadow:0 10px 30px rgba(0,0,0,0.2);
animation:fadeIn 0.2s ease;
}

.form-header{
display:flex;
justify-content:space-between;
align-items:center;
padding:15px 20px;
border-bottom:1px solid #eee;
}

.form-header h3{
font-size:16px;
}

.close{
cursor:pointer;
font-size:20px;
}

.form-body{
padding:20px;
display:flex;
flex-direction:column;
gap:15px;
}

.form-group{
display:flex;
flex-direction:column;
gap:5px;
}

.form-group label{
font-size:13px;
color:#555;
}

.form-group input,
.form-group select{
padding:10px;
border:1px solid #ddd;
border-radius:8px;
outline:none;
}

.form-group input:focus,
.form-group select:focus{
border-color:#3b82f6;
}

.form-group-inline{
display:flex;
gap:10px;
}

.form-group-inline div{
flex:1;
}

.form-footer{
display:flex;
justify-content:flex-end;
gap:10px;
padding:15px 20px;
border-top:1px solid #eee;
}

.btn-save{
background:#3b82f6;
color:#fff;
border:none;
padding:8px 16px;
border-radius:8px;
cursor:pointer;
}

.btn-cancel{
background:#eee;
border:none;
padding:8px 16px;
border-radius:8px;
cursor:pointer;
}

@keyframes fadeIn{
from{
opacity:0;
transform:translateY(-10px);
}
to{
opacity:1;
transform:translateY(0);
}
}

</style>