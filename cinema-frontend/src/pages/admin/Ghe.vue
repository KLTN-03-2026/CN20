<template>
<div class="seat-page">

<div class="seat-tabs">
<button :class="{active:tab=='list'}" @click="tab='list'">
Danh sách ghế
</button>

<button :class="{active:tab=='map'}" @click="tab='map'">
Sơ đồ ghế
</button>
</div>

<div v-if="tab=='list'">

<div class="seat-header">
<h3>Danh Sách Ghế</h3>

<div class="seat-filter">

<select v-model="selectedRoom">
<option value="">Tất cả phòng</option>
<option v-for="room in rooms" :key="room.id" :value="room.id">
Phòng {{room.name}}
</option>
</select>

<input
v-model="search"
placeholder="Tìm kiếm theo tên ghế..."
/>

<button class="search-btn" @click="searchSeat">Tìm Kiếm</button>

</div>
</div>

<table class="seat-table">

<thead>
<tr>
<th>#</th>
<th>Tên ghế</th>
<th>Phòng</th>
<th>Hàng/Cột</th>
<th>Loại ghế</th>
<th>Tình Trạng</th>
</tr>
</thead>

<tbody>

<tr v-for="(seat,index) in filteredSeats" :key="seat.id">

<td>{{index+1}}</td>
<td>{{seat.name}}</td>
<td>{{seat.room}}</td>
<td>{{seat.position}}</td>

<td>
<span 
class="seat-type"
:class="{
vip: seat.type=='VIP',
couple: seat.type=='Couple'
}"
>
{{seat.type}}
</span>
</td>

<td>
<button
@click="toggleStatus(seat)"
:class="seat.status=='active' ? 'status-active' : 'status-maintain'"
>
{{ seat.status=='active' ? 'Hoạt Động' : 'Bảo Trì' }}
</button>
</td>

</tr>

</tbody>
</table>

</div>

<div v-if="tab=='map'" class="seat-map">

<h3>Sơ đồ ghế</h3>

<div class="screen">
MÀN HÌNH
</div>

<div class="seat-map-wrapper">

<div 
v-for="row in rows" 
:key="row"
class="seat-row"
:class="{coupleRow: row=='H'}"
>

<span class="row-label">{{row}}</span>

<div class="seat-row-seats">

<div
v-for="seat in getSeatsByRow(row)"
:key="seat.id"
class="seat-box"
:class="{
normal: seat.type=='Thường',
vip: seat.type=='VIP',
couple: seat.type=='Couple',
maintenance: seat.status=='maintenance'
}"
>
{{seat.name}}
</div>

</div>

</div>
</div>

</div>
</div>
</template>

<script>
export default {

data(){
return{

tab:'list',

search:'',
selectedRoom:1,

rooms:[
{id:1,name:1},
{id:2,name:2},
{id:3,name:3},
{id:4,name:4},
{id:5,name:5}
],

rows:['A','B','C','D','E','F','G','H'],

seats:[],
filteredSeats:[]

}
},

methods:{

getSeatsByRow(row){
return this.seats.filter(seat =>
seat.name.startsWith(row) &&
seat.room == this.selectedRoom
)
},

toggleStatus(seat){
seat.status = seat.status == 'active' ? 'maintenance' : 'active'
},

searchSeat(){

this.filteredSeats = this.seats.filter(seat => {

const matchRoom =
!this.selectedRoom || seat.room == this.selectedRoom

const matchName =
!this.search || seat.name.toLowerCase().includes(this.search.toLowerCase())

return matchRoom && matchName

})

}

},

mounted(){

this.seats = []
let id = 1

for(let room=1; room<=5; room++){

this.rows.forEach(row=>{

let total = row === 'H' ? 5 : 12

for(let col=1; col<=total; col++){

let type = 'Thường'

if(['D','E','F','G'].includes(row)){
type = 'VIP'
}

if(row === 'H'){
type = 'Couple'
}

this.seats.push({

id:id++,
name:row+col,
room:room,
position:`Hàng ${row}, Cột ${col}`,
type:type,
status:'active'

})

}

})

}

this.filteredSeats = this.seats

}

}
</script>

<style scoped>

.seat-page{
background:white;
padding:20px;
}

.seat-tabs{
margin-bottom:20px;
}

.seat-tabs button{
padding:8px 20px;
border:none;
background:#eee;
margin-right:10px;
cursor:pointer;
}

.seat-tabs .active{
background:#2d4eff;
color:white;
}

.seat-header{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:15px;
}

.seat-filter{
display:flex;
gap:10px;
}

.seat-filter select,
.seat-filter input{
padding:6px;
border:1px solid #ddd;
}

.search-btn{
background:#2d8cf0;
color:white;
border:none;
padding:7px 15px;
cursor:pointer;
}

.seat-table{
width:100%;
border-collapse:collapse;
}

.seat-table th,
.seat-table td{
border:1px solid #eee;
padding:10px;
text-align:center;
}

.seat-type{
background:#777;
color:white;
padding:3px 10px;
border-radius:4px;
font-size:13px;
}

.seat-type.vip{
background:#ffd700;
color:#000;
}

.seat-type.couple{
background:#ff4da6;
color:white;
}

.status-active{
background:#2ecc71;
border:none;
color:white;
padding:5px 10px;
border-radius:4px;
cursor:pointer;
}

.status-maintain{
background:#e74c3c;
border:none;
color:white;
padding:5px 10px;
border-radius:4px;
cursor:pointer;
}

.screen{
background:#ddd;
padding:10px;
text-align:center;
margin-bottom:20px;
}

.seat-map-wrapper{
display:flex;
flex-direction:column;
gap:12px;
align-items:center;
margin-top:30px;
}

.seat-row{
display:flex;
align-items:center;
gap:10px;
}

.row-label{
width:20px;
font-weight:bold;
}

.seat-row-seats{
display:grid;
grid-template-columns:repeat(12,60px);
gap:10px;
}

.coupleRow .seat-row-seats{
display:flex;
justify-content:center;
gap:12px;
}

.seat-box{
width:38px;
height:30px;
border:1px solid #bbb;
display:flex;
align-items:center;
justify-content:center;
font-size:12px;
background:#eee;
color:#333;
font-weight:500;
}

.seat-box.normal{
background:#eaeaea;
border:1px solid #bbb;
}

.seat-box.vip{
background:#fff3cd;
border:2px solid #ffc107;
}

.seat-box.couple{
width:70px;
background:#ffe3f1;
border:2px solid #ff2d8f;
}

.seat-box.maintenance{
background:#ccc;
color:#888;
}

</style>