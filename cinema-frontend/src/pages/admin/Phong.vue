<template>
<div class="room-page">

<div class="room-header">
<h2>Danh Sách Phòng</h2>

<button class="add-btn" @click="openAdd">
+ Thêm Phòng
</button>
</div>

<table class="room-table">

<thead>
<tr>
<th>#</th>
<th>Tên Phòng</th>
<th>Số Ghế</th>
<th>Tình Trạng</th>
<th>Hành Động</th>
</tr>
</thead>

<tbody>

<tr v-for="(room,index) in rooms" :key="room.id">

<td>{{index+1}}</td>
<td>{{room.name}}</td>
<td>{{room.seats}}</td>

<td>
<span 
class="status"
:class="room.status=='active' ? 'active' : 'maintain'"
@click="toggleStatus(index)"
>
{{room.status=='active' ? 'Hoạt động' : 'Bảo trì'}}
</span>
</td>

<td class="actions">

<button class="edit-btn" @click="editRoom(index)">
Sửa
</button>

<button class="delete-btn" @click="deleteRoom(index)">
Xóa
</button>

</td>

</tr>

</tbody>

</table>


<!-- FORM THÊM / SỬA -->
<div v-if="showForm" class="form-popup">

<h3>{{isEdit ? 'Sửa Phòng' : 'Thêm Phòng'}}</h3>

<input v-model="form.name" placeholder="Tên phòng">

<input v-model.number="form.seats" placeholder="Số ghế">

<div class="form-actions">
<button @click="saveRoom">Lưu</button>
<button @click="closeForm">Hủy</button>
</div>

</div>

</div>
</template>


<script>
export default {

data(){
return{

rooms:[
{id:1,name:"Phòng 1",seats:89,status:"active"},
{id:2,name:"Phòng 2",seats:89,status:"active"},
{id:3,name:"Phòng 3",seats:89,status:"active"},
{id:4,name:"Phòng 4",seats:89,status:"active"},
{id:5,name:"Phòng 5",seats:89,status:"active"}
],

showForm:false,
isEdit:false,
editIndex:null,

form:{
name:'',
seats:''
}

}
},

methods:{

toggleStatus(index){
this.rooms[index].status =
this.rooms[index].status === 'active' ? 'maintain' : 'active'
},

openAdd(){
this.isEdit=false
this.form={name:'',seats:''}
this.showForm=true
},

editRoom(index){
this.isEdit=true
this.editIndex=index
this.form={
name:this.rooms[index].name,
seats:this.rooms[index].seats
}
this.showForm=true
},

saveRoom(){

if(this.isEdit){

this.rooms[this.editIndex].name=this.form.name
this.rooms[this.editIndex].seats=this.form.seats

}else{

this.rooms.push({
id:Date.now(),
name:this.form.name,
seats:this.form.seats,
status:"active"
})

}

this.closeForm()

},

deleteRoom(index){

if(confirm("Bạn có chắc muốn xóa phòng này?")){
this.rooms.splice(index,1)
}

},

closeForm(){
this.showForm=false
}

}

}
</script>


<style scoped>

.room-page{
background:white;
padding:20px;
border-radius:6px;
box-shadow:0 2px 10px rgba(0,0,0,0.1);
}

.room-header{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:20px;
}

.add-btn{
background:#2d8cf0;
color:white;
border:none;
padding:8px 15px;
border-radius:4px;
cursor:pointer;
}

.room-table{
width:100%;
border-collapse:collapse;
}

.room-table th,
.room-table td{
border:1px solid #eee;
padding:12px;
text-align:center;
}

.room-table th{
background:#f5f5f5;
}

.status{
padding:4px 10px;
border-radius:4px;
color:white;
font-size:13px;
cursor:pointer;
}

.status.active{
background:#2ecc71;
}

.status.maintain{
background:#e74c3c;
}

.actions button{
margin:0 5px;
padding:5px 10px;
border:none;
border-radius:4px;
cursor:pointer;
}

.edit-btn{
background:#f39c12;
color:white;
}

.delete-btn{
background:#e74c3c;
color:white;
}

.status:hover{
opacity:0.8;
}

.form-popup{
margin-top:20px;
padding:20px;
border:1px solid #eee;
border-radius:6px;
background:#fafafa;
}

.form-popup input{
display:block;
width:100%;
margin:10px 0;
padding:8px;
}

.form-actions button{
margin-right:10px;
padding:8px 15px;
border:none;
border-radius:4px;
cursor:pointer;
background:#2d8cf0;
color:white;
}
.actions{
  display:flex;
  justify-content:center;
  align-items:center;
  gap:10px;
}
.actions button{
  width:80px;       /* cùng chiều rộng */
  height:35px;      /* cùng chiều cao */
  border:none;
  border-radius:4px;
  cursor:pointer;
}
</style>