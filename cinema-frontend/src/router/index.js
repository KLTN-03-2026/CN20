import { createRouter, createWebHistory } from "vue-router"

// USER PAGES
import Home from "../views/Home.vue"
import Login from "../views/Login.vue"
import Register from "../views/Register.vue"
import Profile from "../views/Profile.vue"
import MovieDetail from "../views/MovieDetail.vue"
import PaymentSuccess from "../views/PaymentSuccess.vue"
import Magiamgia from '../views/Magiamgia.vue'
import UserLayout from "../layouts/UserLayout.vue"
import Phimdangchieu from '../views/phimdangchieu.vue'
import Phimsapchieu from '../views/phimsapchieu.vue'
import Tintuc from '../views/Tintuc.vue'
import Tintucphim from '../views/Tintucphim.vue'
// ADMIN LAYOUT
import AdminLayout from "../layouts/AdminLayout.vue"

// ADMIN PAGES
import Dashboard from "../pages/admin/Thongke.vue"
import Movies from "../pages/admin/Phim.vue"
import Showtimes from "../pages/admin/Suatchieu.vue"
import Rooms from "../pages/admin/Phong.vue"
import Seats from "../pages/admin/Ghe.vue"
import Payments from "../pages/admin/Thanhtoan.vue"
import Users from "../pages/admin/Danhsachkhachhang.vue"
import Chatbot from "../pages/admin/Chatbot.vue"
import Employees from "../pages/admin/Danhsachnhanvien.vue"
import Vouchers from "../pages/admin/Magiamgia.vue"

const routes = [

{
  path: "/",
  component: UserLayout,
  children: [
    { path: "", name:"home", component: Home },
    { path: "magiamgia", component: Magiamgia },
    { path: "profile", component: Profile, meta: { requiresAuth: true } },
    { path: "movie/:slug", component: MovieDetail },
    {
    path:"phimdangchieu",
    name:"phimdangchieu",
    component:Phimdangchieu
    },
    {
    path:"phimsapchieu",
    name:"phimsapchieu",
    component:Phimsapchieu

},
 {
    path:"Tintuc",
    name:"Tintuc",
    component:Tintuc
    },
    {
    path:"Tintuc/:slug",
    name:"Tintucphim",
    component:Tintucphim
    },
  ]

},

{
path:"/login",
name:"login",
component:Login
},

{
path:"/register",
name:"register",
component:Register
},

{
path:"/profile",
name:"profile",
component:Profile
},

{
path: "/payment-success",
component: PaymentSuccess
},

{
path:"/movie/:slug",
name:"movie-detail",
component:MovieDetail
},

{
  path: '/magiamgia',
  component: Magiamgia
},

{
path:"/admin",
component:AdminLayout,
redirect:"/admin/dashboard",

children:[

{ path:"dashboard", name:"admin-dashboard", component:Dashboard },
{ path:"movies", name:"admin-movies", component:Movies },
{ path:"showtimes", name:"admin-showtimes", component:Showtimes },
{ path:"rooms", name:"admin-rooms", component:Rooms },
{ path:"seats", name:"admin-seats", component:Seats },
{ path:"payments", name:"admin-payments", component:Payments },

{ path:"users", name:"admin-users", component:Users },
{ path:"employees", name:"admin-employees", component:Employees },

{ path:"customers", component:Users },
{ path:"staff", component:Users },
{
  path:"vouchers",name:"admin-vouchers",component: Vouchers
},
{ path:"chatbot", name:"admin-chatbot", component:Chatbot }

]
}

]

const router = createRouter({
history: createWebHistory(),
routes
})
router.beforeEach((to, from, next) => {
  const user = localStorage.getItem("currentUser")

  if (to.meta.requiresAuth && !user) {
    return next('/login')
  }

  if (to.path === '/login' && user) {
    return next('/')
  }

  next()
})
export default router
