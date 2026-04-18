<template>
<div>

<h1>Quản lí phim</h1>

<div class="action-bar">
  <button class="btn-add" @click="openAdd">Thêm mới</button>

  <select v-model="filterStatus" class="filter-select">
    <option value="all">Tất cả</option>
    <option value="dangchieu">Đang chiếu</option>
    <option value="sapchieu">Sắp chiếu</option>
  </select>
</div>

<div class="table-container">
<table class="movie-table">

<tr>
<th>ID</th>
<th>Tên phim</th>
<th>Slug</th>
<th>Diễn viên</th>
<th>Ngày chiếu</th>
<th>Thời lượng</th>
<th>Đạo diễn</th>
<th>Thể loại</th>
<th>Giới hạn tuổi</th>
<th>Hình ảnh</th>
<th>Trailer</th>
<th>Ngôn ngữ</th>
<th>Tình trạng</th>
</tr>

<tr v-for="movie in filteredMovies" :key="movie.id">
<td>{{movie.id}}</td>
<td>{{movie.ten_phim}}</td>
<td>{{movie.slug}}</td>
<td>{{movie.dien_vien}}</td>
<td>{{ new Date(movie.ngay_chieu).toLocaleDateString('vi-VN') }}</td>
<td>{{movie.thoi_luong}}</td>
<td>{{movie.dao_dien}}</td>
<td>{{movie.the_loai}}</td>
<td>{{movie.gioi_han_do_tuoi}}</td>

<td>
<img :src="'http://127.0.0.1:8000/image/' + movie.hinh_anh" class="poster">
</td>

<td>
<iframe
class="trailer"
:src="getYoutube(movie.trailer)"
frameborder="0"
allowfullscreen>
</iframe>
</td>

<td>{{movie.ngon_ngu}}</td>

<td>
  <span v-if="movie.tinh_trang==='dangchieu'" class="status on">
    Đang chiếu
  </span>
  <span v-else class="status coming">
    Sắp chiếu
  </span>
</td>

<td class="action-cell">
<span class="active-number">{{movie.active}}</span>

<button class="btn-update" @click="openEdit(movie)">Cập nhật</button>
<button class="btn-delete" @click="deleteMovie(movie.id)">Xóa</button>
</td>

</tr>

</table>
</div>

<div v-if="showForm" class="modal-overlay">

<div class="modal-box">

<div class="modal-header">
<h2>{{isEdit ? "Cập nhật phim" : "Thêm phim mới"}}</h2>
<button class="close-btn" @click="closeForm">X</button>
</div>

<div class="modal-body">

<div class="form-grid">

<div>
<label>Tên phim</label>
<input v-model="movie.ten_phim">
</div>

<div>
<label>Slug</label>
<input v-model="movie.slug">
</div>

<div>
<label>Diễn viên</label>
<input v-model="movie.dien_vien">
</div>

<div>
<label>Ngày chiếu</label>
<input type="date" v-model="movie.ngay_chieu">
</div>

<div>
<label>Thời lượng</label>
<input v-model="movie.thoi_luong">
</div>

<div>
<label>Đạo diễn</label>
<input v-model="movie.dao_dien">
</div>

<div>
<label>Thể loại</label>
<input v-model="movie.the_loai">
</div>

<div>
<label>Giới hạn tuổi</label>
<input v-model="movie.gioi_han_do_tuoi">
</div>

<div>
<label>Hình ảnh</label>
<input v-model="movie.hinh_anh">
</div>

<div>
<label>Trailer</label>
<input v-model="movie.trailer">
</div>

<div>
<label>Ngôn ngữ</label>
<input v-model="movie.ngon_ngu">
</div>

<div>
<label>Tình trạng</label>
<select v-model="movie.tinh_trang">
  <option value="dangchieu">Đang chiếu</option>
  <option value="sapchieu">Sắp chiếu</option>
</select>
</div>

<div>
<label>Active</label>
<input v-model="movie.active">
</div>

<div class="full">
<label>Chi tiết</label>
<textarea v-model="movie.chi_tiet"></textarea>
</div>

</div>

</div>

<div class="modal-footer">
<button class="btn-save" @click="saveMovie">
{{isEdit ? "Cập nhật" : "Thêm mới"}}
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
movies:[],
showForm:false,
isEdit:false,
filterStatus: 'all',

movie:{
ten_phim:'',
slug:'',
dien_vien:'',
ngay_chieu:'',
thoi_luong:'',
dao_dien:'',
nha_san_xuat:'',
the_loai:'',
gioi_han_do_tuoi:'',
hinh_anh:'',
trailer:'',
ngon_ngu:'',
chi_tiet:'',
tinh_trang:'',
active:1,
}
}
},

mounted(){
this.loadMovies()
},

methods:{

getYoutube(url){
if(!url) return ""

let videoId=""

if(url.includes("watch?v=")){
videoId=url.split("watch?v=")[1]
}
else if(url.includes("youtu.be/")){
videoId=url.split("youtu.be/")[1]
}
else if(url.includes("embed/")){
videoId=url.split("embed/")[1]
}

if(videoId.includes("&")){
videoId=videoId.split("&")[0]
}

return "https://www.youtube.com/embed/"+videoId
},

loadMovies(){
fetch("http://127.0.0.1:8000/api/admin/movies")
.then(res=>res.json())
.then(data=>{
this.movies=data
})
},

openAdd(){
this.isEdit=false

this.movie={
ten_phim:'',
slug:'',
dien_vien:'',
ngay_chieu:'',
thoi_luong:'',
dao_dien:'',
nha_san_xuat:'',
the_loai:'',
gioi_han_do_tuoi:'',
hinh_anh:'',
trailer:'',
ngon_ngu:'',
chi_tiet:'',
tinh_trang:'',
active:1
}

this.showForm=true
},

openEdit(movie){
this.isEdit=true
this.movie={...movie}
this.showForm=true
},

closeForm(){
this.showForm=false
},

saveMovie(){

if(this.isEdit){

fetch("http://127.0.0.1:8000/api/admin/movies/"+this.movie.id,{
method:"PUT",
headers:{
"Content-Type":"application/json"
},
body:JSON.stringify(this.movie)
})
.then(()=>{
alert("Cập nhật thành công")
this.loadMovies()
this.showForm=false
})

}else{

fetch("http://127.0.0.1:8000/api/admin/movies",{
method:"POST",
headers:{
"Content-Type":"application/json"
},
body:JSON.stringify(this.movie)
})
.then(()=>{
alert("Thêm phim thành công")
this.loadMovies()
this.showForm=false
})

}

},

deleteMovie(id){

if(confirm("Bạn có chắc muốn xóa?")){

fetch("http://127.0.0.1:8000/api/admin/movies/"+id,{
method:"DELETE"
})
.then(()=>{
alert("Đã xóa")
this.loadMovies()
})

}

}

},

computed:{
filteredMovies(){
if(this.filterStatus === 'all'){
return this.movies
}
return this.movies.filter(m => m.tinh_trang === this.filterStatus)
}
}

}
</script>

<style>
.table-container{
overflow-x:auto;
margin-top:20px;
}

.movie-table{
border-collapse:collapse;
width:100%;
background:white;
}

.movie-table th,
.movie-table td{
border:1px solid #ddd;
padding:10px;
text-align:center;
white-space:nowrap;
}

.movie-table th{
background:#f2f2f2;
}

.poster{
width:80px;
height:100px;
object-fit:contain;
}

.trailer{
width:250px;
height:140px;
border-radius:8px;
}

.btn-add{
background:#dc3545;
color:white;
border:none;
padding:8px 16px;
border-radius:6px;
cursor:pointer;
}

.btn-update{
background:#007bff;
color:white;
border:none;
padding:6px 10px;
border-radius:5px;
cursor:pointer;
margin-right:8px;
}

.btn-delete{
background:#dc3545;
color:white;
border:none;
padding:6px 10px;
border-radius:5px;
cursor:pointer;
}

.modal-overlay{
position:fixed;
top:0;
left:0;
width:100%;
height:100vh;
background:rgba(0,0,0,0.5);
display:flex;
justify-content:center;
overflow-y:auto;
padding:40px;
}

.modal-box{
background:white;
width:700px;
border-radius:8px;
padding:20px;
}

.modal-header{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:10px;
}

.close-btn{
background:red;
color:white;
border:none;
padding:5px 10px;
cursor:pointer;
}

.modal-body input,
.modal-body textarea{
display:block;
width:100%;
margin-bottom:10px;
padding:8px;
border:1px solid #ccc;
}

.modal-footer{
text-align:right;
}

.btn-save{
background:#dc3545;
color:white;
border:none;
padding:8px 15px;
border-radius:5px;
cursor:pointer;
}

.form-grid{
display:grid;
grid-template-columns:1fr 1fr;
column-gap:30px;
row-gap:12px;
}

.modal-body{
max-height:60vh;
overflow-y:auto;
}

.status{
padding:4px 10px;
border-radius:20px;
font-size:12px;
font-weight:bold;
}

.status.on{
background:#d1fae5;
color:#065f46;
}

.status.coming{
background:#fef3c7;
color:#92400e;
}

.movie-table tr:hover{
background:#f9fafb;
}

.action-bar{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:15px;
}

.filter-select{
width:180px;
padding:6px 10px;
border-radius:5px;
border:1px solid #ccc;
}
</style>
