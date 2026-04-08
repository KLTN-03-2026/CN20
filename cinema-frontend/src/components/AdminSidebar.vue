<template>
<div class="sidebar">

<h2>RIO ADMIN</h2>

<ul>
<li><router-link to="/admin/dashboard">Dashboard</router-link></li>
<li><router-link to="/admin/movies">Movies</router-link></li>
<li><router-link to="/admin/users">Users</router-link></li>
<li><router-link to="/admin/showtimes">Showtimes</router-link></li>
<li><router-link to="/admin/rooms">Rooms</router-link></li>
</ul>

</div>
</template>

<style>
.sidebar{
width:220px;
height:100vh;
background:#111;
color:white;
padding:20px;
}

.sidebar ul{
list-style:none;
padding:0;
}

.sidebar li{
margin:15px 0;
}

.sidebar a{
color:white;
text-decoration:none;
}
</style>