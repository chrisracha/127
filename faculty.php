<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DMPCS Dashboard - Faculty</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" charset="utf-8"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/e2809407eb.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
</head>
<body class="bg-light">
  <div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="students.php">Students</a>
    <a href="#">Faculty</a>
    <a href="admin.php">Admin</a>
  </div>
    <nav class="navbar maroon p-4">
        <a href="/#"><img src="images/header.png" style="max-height: 30px;"></a>
    </nav>
    <div class="m-4">
    <main class="p-5">
        <section>
            <a><i class="fas fa-bars" onclick="openNav()" style="cursor:pointer">&nbsp;</i>Analytics > <strong>Faculty</strong></a>
        </section>
        <hr>
        <div class="d-flex w-100 form-inline align-items-center">
            <label class="indicator mr-2">From:</label>
            <label for="year">Year</label>
            <select id="year" class="ml-2">
              <option value="option1">Current</option>
              <option value="option2">2022-2023</option>
            </select>
            <label for="semester">Semester</label>
            <select id="semester" class="ml-2">
              <option value="option">Current</option>
              <option value="option1">1st Semester</option>
              <option value="option2">2nd Semester</option>
            </select>
          </div>
        <div class="d-flex w-100 form-inline align-items-center">
          <label class="indicator mr-2">To:</label>
          <label for="year">Year</label>
          <select id="year" class="ml-2">
            <option value="option1">Current</option>
            <option value="option2">2022-2023</option>
          </select>
          <label for="semester">Semester</label>
          <select id="semester" class="ml-2">
            <option value="option">Current</option>
            <option value="option1">1st Semester</option>
            <option value="option2">2nd Semester</option>
          </select>
        </div>
        <button class="btn btn-primary border-0 mt-2 ml-2 maroon">Filter</button>
    </main>
      <div class="card-columns m-4">
      <div class="p-3 chart-card m-2 card">
          <div class="card-header">Population of Faculty per Semester by Rank</div>
          <div class="card-body">
            <canvas id="facultySembyRank" class="w-100"></canvas>
          </div>
        </div>
          <div class="p-3 chart-card m-2 card">
            <div class="card-header">Ratio of Faculty by Rank</div>
            <div class="card-body">
              <canvas id="ratioByRank" class="w-100"></canvas>
            </div>
        </div>
        <div class="p-3 chart-card m-2 card">
          <div class="card-header">Population of Faculty per Semester by Educational Attainment</div>
          <div class="card-body">
            <canvas id="facultyByEducAttainment" class="w-100"></canvas>
          </div>
        </div>
        <div class="p-3 chart-card m-2 card">
          <div class="card-header">Ratio of Faculty by Educational Attainment</div>
          <div class="card-body">
            <canvas id="ratioByEduc" class="w-100"></canvas>
          </div>
        </div>
        <div class="p-3 chart-card m-2 card">
          <div class="card-header">Number of Total Faculty</div>
          <div class="card-body">
            <canvas id="numberOfTotalFaculty" class="w-100"></canvas>
          </div>
        </div>
        <div class="p-3 chart-card m-2 card">
          <div class="card-header">Number of Publications</div>
          <div class="card-body">
            <canvas id="numberOfPublications" class="w-100"></canvas>
          </div>
        </div>
        <div class="p-3 chart-card m-2 card">
          <div class="card-header">Research Involvement</div>
          <div class="card-body">
            <canvas id="researchInvolvement" class="w-100"></canvas>
          </div>
     </div>
    </div>
    </div>
      <footer class="maroon p-4">
          <p class="text-center text-white" style="font-family: 'Avenir Black';">© 2024 DMPCS</p>
      </footer>
</body>
<script src="script.js"></script>
<script src="faculty_script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
</html>
