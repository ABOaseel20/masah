<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>قصر الماسة | لوحة التحكم</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap RTL -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;800&display=swap" rel="stylesheet">

<style>
body{
    font-family:'Cairo',sans-serif;
    background:#0d0d0d;
    overflow-x:hidden;
    transition:.3s;
}

/* ================= LOADING ================= */
#loader{
    position:fixed;
    width:100%;
    height:100%;
    background:#000;
    display:flex;
    align-items:center;
    justify-content:center;
    flex-direction:column;
    z-index:9999;
}

.diamond{
    font-size:80px;
    color:gold;
    animation:rotate 2s linear infinite,
              glow 1.5s ease-in-out infinite alternate;
}

.loading-text{
    color:gold;
    margin-top:15px;
    letter-spacing:3px;
    font-weight:bold;
}

@keyframes rotate{
    from{transform:rotateY(0deg);}
    to{transform:rotateY(360deg);}
}

@keyframes glow{
    from{text-shadow:0 0 10px gold;}
    to{text-shadow:0 0 40px gold,0 0 70px orange;}
}

/* ================= SIDEBAR ================= */
.sidebar{
    width:260px;
    min-height:100vh;
    background:linear-gradient(180deg,#111,#000);
    transition:.3s;
    position:relative;
    z-index:1000;
}

.sidebar.collapsed{
    margin-right:-260px;
}

.sidebar .nav-link{
    color:#ccc;
    padding:12px;
    margin:6px 0;
    border-radius:12px;
    transition:.3s;
}

.sidebar .nav-link:hover,
.sidebar .nav-link.active{
    background:gold;
    color:#000;
}

/* ================= MOBILE OVERLAY ================= */
.overlay{
    position:fixed;
    width:100%;
    height:100%;
    background:rgba(0,0,0,.6);
    z-index:900;
    display:none;
}

.overlay.active{
    display:block;
}

/* ================= TOPBAR ================= */
.topbar{
    background:#1a1a1a;
    border-bottom:1px solid gold;
}

/* ================= PAGE ANIMATION ================= */
.page-content{
    animation:fadeIn .6s ease;
}

@keyframes fadeIn{
    from{opacity:0; transform:translateY(10px);}
    to{opacity:1; transform:translateY(0);}
}

/* ================= LIGHT MODE ================= */
body.light-mode{
    background:#f5f5f5;
}

body.light-mode .sidebar{
    background:#fff;
}

body.light-mode .nav-link{
    color:#333;
}

body.light-mode .topbar{
    background:#fff;
}

.content-wrapper{
    width:100%;
    transition:.3s;
}

/* Responsive */
@media(max-width:992px){
    .sidebar{
        position:fixed;
        right:0;
        margin-right:-260px;
    }
    .sidebar.show{
        margin-right:0;
    }
}
</style>
</head>

<body>

<!-- LOADING -->
<div id="loader">
    <div class="diamond">
        <i class="bi bi-gem"></i>
    </div>
    <div class="loading-text">قصر الماسة</div>
</div>

<div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

<div class="d-flex">

    <!-- SIDEBAR -->
    <div id="sidebar" class="sidebar p-3">

        <h4 class="text-center text-warning mb-4">
            <i class="bi bi-gem"></i> قصر الماسة
        </h4>

        <ul class="nav flex-column">

            <li>
                <a class="nav-link {{ request()->routeIs('dashboard')?'active':'' }}"
                   href="{{ route('dashboard') }}">
                   <i class="bi bi-speedometer2"></i> لوحة التحكم
                </a>
            </li>

            <li>
                <a class="nav-link {{ request()->routeIs('halls.*')?'active':'' }}"
                   href="{{ route('halls.index') }}">
                   <i class="bi bi-building"></i> القاعات
                </a>
            </li>

            <li>
                <a class="nav-link {{ request()->routeIs('bookings.*')?'active':'' }}"
                   href="{{ route('bookings.index') }}">
                   <i class="bi bi-calendar-event"></i> الحجوزات
                </a>
            </li>

            <li>
                <a class="nav-link {{ request()->routeIs('clients.*')?'active':'' }}"
                   href="{{ route('clients.index') }}">
                   <i class="bi bi-people"></i> العملاء
                </a>
            </li>

            <li>
                <a class="nav-link {{ request()->routeIs('reports.*')?'active':'' }}"
                   href="{{ route('reports.index') }}">
                   <i class="bi bi-bar-chart-line"></i> التقارير
                </a>
            </li>

        </ul>
    </div>

    <!-- MAIN -->
    <div class="content-wrapper flex-fill">

        <nav class="navbar topbar px-4 py-3 d-flex justify-content-between">

            <div class="d-flex align-items-center gap-3">

                <button class="btn btn-outline-warning"
                        onclick="toggleSidebar()">
                    <i class="bi bi-list"></i>
                </button>

                <span class="text-warning h5 mb-0">
                    لوحة التحكم
                </span>

            </div>

            <button onclick="toggleMode()" class="btn btn-sm btn-outline-warning">
                🌓
            </button>

        </nav>

        <div class="container-fluid mt-4 px-4 page-content">
            @yield('content')
        </div>

    </div>

</div>

<script>
function toggleSidebar(){
    let sidebar=document.getElementById('sidebar');
    let overlay=document.getElementById('overlay');

    if(window.innerWidth<992){
        sidebar.classList.toggle('show');
        overlay.classList.toggle('active');
    }else{
        sidebar.classList.toggle('collapsed');
    }
}

function toggleMode(){
    document.body.classList.toggle('light-mode');
    localStorage.setItem('mode',
        document.body.classList.contains('light-mode')?'light':'dark'
    );
}

if(localStorage.getItem('mode')==='light'){
    document.body.classList.add('light-mode');
}

window.addEventListener("load",function(){
    const loader=document.getElementById("loader");
    loader.style.opacity="0";
    setTimeout(()=>loader.style.display="none",500);
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>