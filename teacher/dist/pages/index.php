<?php
session_start();
require_once 'partials/header.php';
require_once 'partials/navbar.php';
require_once 'partials/sidebar.php';
?>

<main class="app-main">
<?php
// Database queries as before...
$total_students_result = $conn->query("SELECT COUNT(*) AS total_students FROM users WHERE user_type = 'student'");
if (!$total_students_result) {
  die("Query failed: " . $conn->error);
}
$total_students = $total_students_result->fetch_assoc()['total_students'];

$total_notices_result = $conn->query("SELECT COUNT(*) AS total_notices FROM announcements");
if (!$total_notices_result) {
  die("Query failed: " . $conn->error);
}
$total_notices = $total_notices_result->fetch_assoc()['total_notices'];

$total_class_schedules_result = $conn->query("SELECT COUNT(*) AS total_class_schedules FROM class_schedule");
if (!$total_class_schedules_result) {
  die("Query failed: " . $conn->error);
}
$total_class_schedules = $total_class_schedules_result->fetch_assoc()['total_class_schedules'];

$total_grade_reports_result = $conn->query("SELECT COUNT(*) AS total_grade_reports FROM grade_reports");
if (!$total_grade_reports_result) {
  die("Query failed: " . $conn->error);
}
$total_grade_reports = $total_grade_reports_result->fetch_assoc()['total_grade_reports'];

$conn->close();
?>

<div class="dashboard">
  <div class="dashboard-item" id="students-card">
    <h3>Total Students</h3>
    <p><?php echo $total_students; ?></p>
  </div>
  <div class="dashboard-item" id="notices-card">
    <h3>Total Notices</h3>
    <p><?php echo $total_notices; ?></p>
  </div>
  <div class="dashboard-item" id="class-schedules-card">
    <h3>Total Class Schedules</h3>
    <p><?php echo $total_class_schedules; ?></p>
  </div>
  <div class="dashboard-item" id="grade-reports-card">
    <h3>Total Grade Reports</h3>
    <p><?php echo $total_grade_reports; ?></p>
  </div>
</div>

<!-- Adding Chart.js CDN for chart support -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Chart Container -->
<div class="chart-container">
  <div class="chart-box">
    <canvas id="dataBarChart"></canvas>
  </div>
  <div class="chart-box">
    <canvas id="dataPieChart"></canvas>
  </div>
</div>

<style>
.dashboard {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-around;
  padding: 40px 20px;
  gap: 20px;
}

.dashboard-item {
  background: linear-gradient(135deg, #3b82f6, #9333ea);
  color: #fff;
  padding: 30px;
  border-radius: 10px;
  text-align: center;
  width: 220px;
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.dashboard-item:hover {
  transform: translateY(-10px);
  box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.3);
}

.dashboard-item h3 {
  font-size: 1.5em;
  margin-bottom: 10px;
}

.dashboard-item p {
  font-size: 2em;
  margin: 0;
  animation: fadeIn 0.6s ease forwards;
  opacity: 0;
}

.chart-container {
  display: flex;
  justify-content: space-around;
  padding: 40px 20px;
  gap: 40px;
}

.chart-box {
  width: 45%;
  max-width: 500px;
}

@keyframes fadeIn {
  0% { opacity: 0; transform: translateY(20px); }
  100% { opacity: 1; transform: translateY(0); }
}
</style>

<script>
// Data for Charts
const labels = ['Students', 'Notices', 'Class Schedules', 'Grade Reports'];
const data = [<?php echo $total_students; ?>, <?php echo $total_notices; ?>, <?php echo $total_class_schedules; ?>, <?php echo $total_grade_reports; ?>];

// Bar Chart
const ctxBar = document.getElementById('dataBarChart').getContext('2d');
new Chart(ctxBar, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Count',
            data: data,
            backgroundColor: [
                '#3b82f6', '#9333ea', '#f97316', '#10b981'
            ],
            borderColor: [
                '#2563eb', '#7c3aed', '#ea580c', '#059669'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            },
            title: {
                display: true,
                text: 'Dashboard Overview'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    }
});

// Pie Chart
const ctxPie = document.getElementById('dataPieChart').getContext('2d');
new Chart(ctxPie, {
    type: 'pie',
    data: {
        labels: labels,
        datasets: [{
            data: data,
            backgroundColor: [
                '#3b82f6', '#9333ea', '#f97316', '#10b981'
            ],
            hoverOffset: 4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'right',
            },
            title: {
                display: true,
                text: 'Data Distribution'
            }
        }
    }
});

// Update dashboard item colors based on chart colors
const colors = ['#3b82f6', '#9333ea', '#f97316', '#10b981'];
document.getElementById('students-card').style.background = colors[0];
document.getElementById('notices-card').style.background = colors[1];
document.getElementById('class-schedules-card').style.background = colors[2];
document.getElementById('grade-reports-card').style.background = colors[3];
</script>
</main>

<?php require_once 'partials/footer.php'; ?>
