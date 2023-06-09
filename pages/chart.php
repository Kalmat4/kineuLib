<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .container{
            width: 50%;
            margin: 0 auto;
        }
        h1{
            text-align: center;
        }
        .divider{
          width: 100%;
          border-bottom: 10px solid black;
          margin: 10rem 0;
        }
    </style>
</head>
<body>
<div class="container">
  <h1>Количество студентов по факультетам</h1>
  <canvas responsive="true" id="myChart"></canvas>
  
  <div class="divider"></div>
  <h1>Количество студентов по кафедрам</h1>
  <canvas responsive="true" id="myChartDepartment"></canvas>
  
  <div class="divider"></div>
  <h1>Количество студентов по специальностям</h1>
  <canvas responsive="true" id="myChartSpec"></canvas>
  
  <div class="divider"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php
// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "chartData";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

// SQL-запрос для получения данных из полей "title" и "students_count" таблицы "faculty"
$sqlFaculty = "SELECT title, students_count FROM faculty";
$resultFaculty = $conn->query($sqlFaculty);

$titlesFaculty = array(); // Массив для хранения значений поля "title" из таблицы "faculty"
$studentsCountsFaculty = array(); // Массив для хранения значений поля "students_count" из таблицы "faculty"

if ($resultFaculty->num_rows > 0) {
    while ($row = $resultFaculty->fetch_assoc()) {
        $titlesFaculty[] = $row['title'];
        $studentsCountsFaculty[] = $row['students_count'];
    }
}


json_encode($titlesFaculty);
json_encode($studentsCountsFaculty);

// SQL-запрос для получения данных из полей "title" и "students_count" таблицы "department"
$sqlDepartment = "SELECT title, students_count FROM department";
$resultDepartment = $conn->query($sqlDepartment);

$titlesDepartment = array(); // Массив для хранения значений поля "title" из таблицы "department"
$studentsCountsDepartment = array(); // Массив для хранения значений поля "students_count" из таблицы "department"

if ($resultDepartment->num_rows > 0) {
    while ($row = $resultDepartment->fetch_assoc()) {
        $titlesDepartment[] = $row['title'];
        $studentsCountsDepartment[] = $row['students_count'];
    }
}


json_encode($titlesDepartment);
json_encode($studentsCountsDepartment);



$sqlSpec = "SELECT title, students_count FROM spec";
$resultSpec = $conn->query($sqlSpec);

$titlesSpec = array(); 
$studentsCountsSpec = array(); 

if ($resultSpec->num_rows > 0) {
    while ($row = $resultSpec->fetch_assoc()) {
        $titlesSpec[] = $row['title'];
        $studentsCountsSpec[] = $row['students_count'];
    }
}


json_encode($titlesSpec);
json_encode($studentsCountsSpec);



$conn->close();

?>
<script>
  const dough = document.getElementById('myChart');
  const myChartDepartment = document.getElementById('myChartDepartment');
  const myChartSpec = document.getElementById('myChartSpec');

  const facultyTitles = <?= json_encode($titlesFaculty) ?>;
  const studentsCounts = <?= json_encode($studentsCountsFaculty) ?>;

  new Chart(dough, {
    type: 'doughnut',
    data: {
      labels: facultyTitles,
      datasets: [{
        label: 'Факультеты',
        data: studentsCounts,
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    },
  });


  
  const departmentTitles = <?= json_encode($titlesDepartment) ?>;
  const departmentStudentsCounts = <?= json_encode($studentsCountsDepartment) ?>;

  
  new Chart(myChartDepartment, {
    type: 'bar',
    data: {
      labels: departmentTitles,
      datasets: [{
        label: 'Кафедры',
        data: departmentStudentsCounts,
        borderWidth: 1,
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)',
          'rgba(255, 159, 64, 0.2)',
          'rgba(255, 205, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(201, 203, 207, 0.2)'
        ],
        borderColor: [
          'rgb(255, 99, 132)',
          'rgb(255, 159, 64)',
          'rgb(255, 205, 86)',
          'rgb(75, 192, 192)',
          'rgb(54, 162, 235)',
          'rgb(153, 102, 255)',
          'rgb(201, 203, 207)'
        ]
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    },
  });


  
  const titlesSpec = <?= json_encode($titlesSpec) ?>;
  const studentsCountsSpec = <?= json_encode($studentsCountsSpec) ?>;

  new Chart(myChartSpec, {
    type: 'polarArea',
    data: {
      labels: titlesSpec,
      datasets: [{
        label: 'Специальности',
        data: studentsCountsSpec,
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    },
  });

</script>
</body>
</html>