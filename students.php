<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DMPCS Dashboard - Students</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" charset="utf-8"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/e2809407eb.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
</head>
<body class="bg-light">
  <div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="#">Students</a>
    <a href="faculty.html">Faculty</a>
    <a href="admin.html">Admin</a>
  </div>
    <nav class="navbar maroon p-4">
        <a href="/#"><img src="images/header.png" style="max-height: 30px;"></a>
    </nav>
    <div class="m-4">
    <main class="p-5">
        <section>
            <a><i class="fas fa-bars" onclick="openNav()" style="cursor:pointer">&nbsp;</i>Analytics > <strong>Students</strong></a>
        </section>
        <hr>
        <div class="d-flex w-100 form-inline align-items-center">
          <label for="degree-program">Deg. Prog.</label>
          <select id="degree-program" class="ml-2">
            <option value="option1">All</option>
            <option value="option2">BSCS</option>
            <option value="option3">BSAM</option>
            <option value="option4">BSDS</option>
          </select>
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
    </main>
      <div class="card-columns m-4">
          <div class="p-3 chart-card m-2 card">
            <div class="card-header">Total Number of Enrollees per Degree Program</div>
            <div class="card-body">
              <canvas id="enrolleesCourseChart" class="w-100"></canvas>
            </div>
        </div>
          <div class="p-3 chart-card m-2 card">
            <div class="card-header">Population of Enrollees per Year</div>
            <div class="card-body">
              <canvas id="enrolleesYearChart" class="w-100"></canvas>
            </div>
          </div>
          <div class="p-3 chart-card m-2 card">
            <div class="card-header">Students per Year Level</div>
            <div class="card-body">
              <canvas id="studentsPerYear" class="w-100"></canvas>
            </div>
          </div>
          <div class="p-3 chart-card m-2 card">
            <div class="card-header">Population of Semestral Achievers per Semester</div>
            <div class="card-body">
              <canvas id="scholarsChart" class="w-100"></canvas>
            </div>
          </div>
          <div class="p-3 chart-card m-2 card">
            <div class="card-header">Ratio of University Scholars between Degree Programs</div>
            <div class="card-body">
              <canvas id="USperDegProg" class="w-100"></canvas>
            </div>
          </div>
          <div class="p-3 chart-card m-2 card">
            <div class="card-header">Ratio of College Scholars between Degree Programs</div>
            <div class="card-body">
              <canvas id="CSperDegProg" class="w-100"></canvas>
            </div>
          </div>
            <div class="p-3 chart-card m-2 card">
              <div class="card-header">Population of Graduates with Distinctions </div>
              <div class="card-body"> 
                <canvas id="PopulationLaudes" class="w-100"></canvas>
              </div>
            </div>
            <div class="p-3 chart-card m-2 card">
              <div class="card-header">Enrollment Data</div>
              <div class="card-body">
                <canvas id="enrollmentData" class="w-100"></canvas>
              </div>
            </div>
            <div class="p-3 chart-card m-2 card">
              <div class="card-header">Student Participation in Events</div>
              <div class="card-body">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Event</th>
                      <th>Participation Count</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Event 1</td>
                      <td>10</td>
                    </tr>
                    <tr>
                      <td>Event 2</td>
                      <td>15</td>
                    </tr>
                    <tr>
                      <td>Event 3</td>
                      <td>8</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
      </div>
    </div>
      <footer class="maroon p-4">
          <p class="text-center text-white" style="font-family: 'Avenir';">© 2024 DMPCS</p>
      </footer>    
</body>
<script src="script.js"></script>
<script src="students_script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
</html>
