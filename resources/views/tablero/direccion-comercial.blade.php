

<style type="text/css">

.dashboard-stats {
    margin-left: -10px;
    margin-right: -10px;
}

.dashboard-stats > div {
    padding-left: 10px;
    padding-right: 10px;
}


/* CARD */

.stat-card {
    position: relative;
    height: 90px;
    margin-bottom: 20px;
    padding: 17px 18px;
    border-radius: 3px;
    color: #fff;
    overflow: hidden;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.10);
    transition: all 0.25s ease;
}


/* HOVER */

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
}


/* CONTENT */

.stat-content {
    position: relative;
    z-index: 2;
}

.stat-value {
    font-size: 22px;
    font-weight: 600;
    line-height: 24px;
    margin-bottom: 3px;
}

.stat-label {
    font-size: 14px;
    font-weight: 500;
    opacity: 0.95;
}


/* ICON */

.stat-icon {
    position: absolute;
    right: 18px;
    top: 18px;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.90);
    color: #777;
    font-size: 18px;
    z-index: 2;
}


/* THREE DOTS */

.stat-menu {
    position: absolute;
    top: 5px;
    right: 8px;
    font-size: 8px;
    color: rgba(255, 255, 255, 0.85);
    z-index: 3;
}


/* =========================================
   COLORS
   ========================================= */

/* Blue */

.stat-blue {
    background: linear-gradient(
        135deg,
        #669933 0%,
        #F2F522  100%
    );
}


/* Cyan */

.stat-cyan {
    background: linear-gradient(
        135deg,
        #09a9c9 0%,
        #05bfd0 100%
    );
}


/* Gold */

.stat-gold {
    background: linear-gradient(
        135deg,
        #c9a95a 0%,
        #e2c879 100%
    );
}


/* Red */

.stat-red {
    background: linear-gradient(
        135deg,
        #dc6259 0%,
        #ee766a 100%
    );
}


/* =========================================
   RESPONSIVE
   ========================================= */

@media (max-width: 767px) {

    .stat-card {
        height: 85px;
    }

    .stat-value {
        font-size: 20px;
    }

    .stat-icon {
        width: 44px;
        height: 44px;

        right: 15px;
        top: 18px;
    }
}
</style>

<div class="row dashboard-stats">

    <!-- Store Traffic -->
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card stat-blue">

            <div class="stat-content">
                <div class="stat-value">{{ count($concursos) }}</div>
                <div class="stat-label">No. Concursos</div>
            </div>

            <div class="stat-icon">
                <i class="fas fa-chart-bar"></i>
            </div>

        </div>
    </div>


    <!-- User Likes -->
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card stat-cyan">

            <div class="stat-content">
                <div class="stat-value">489</div>
                <div class="stat-label">User Likes</div>
            </div>

            <div class="stat-icon">
                <i class="fas fa-thumbs-up"></i>
            </div>

        </div>
    </div>


    <!-- Total Revenue -->
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card stat-gold">

            <div class="stat-content">
                <div class="stat-value">$68,125</div>
                <div class="stat-label">Total Revenue</div>
            </div>

            <div class="stat-icon">
                <i class="fas fa-wallet"></i>
            </div>

        </div>
    </div>


    <!-- Join Members -->
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card stat-red">

            <div class="stat-content">
                <div class="stat-value">{{ count($pendiente_no_finalizado) }}</div>
                <div class="stat-label">Pendientes</div>
            </div>

            <div class="stat-icon">
                <i class="fas fa-user"></i>
            </div>

        </div>
    </div>




</div>
