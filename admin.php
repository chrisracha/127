<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DMPCS Dashboard - Admin Page</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" charset="utf-8"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/e2809407eb.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script src="chartjs-plugin-doughnutlabel.min.js"></script>
</head>
<body class="bg-light">
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="students.php">Students</a>
        <a href="faculty.php">Faculty</a>
        <a href="#">Admin</a>
    </div>
    <nav class="navbar maroon p-4">
        <a href="/#"><img src="images/header.png" style="max-height: 30px;"></a>
    </nav>
    <div class="m-4">
        <main class="p-5">
            <section>
                <a><i class="fas fa-bars" onclick="openNav()" style="cursor:pointer">&nbsp;</i>Analytics >
                    <strong>ADMIN</strong></a>
            </section>
            <hr>
    </div>
    </main>
    <h6 class="admin_header m-5">Admin > Time Data</h6>
    <div class="card-columns m-4">
        <div class="p-3 chart-card m-2 card">
            <div class="card-header">Update Academic Year & Semester</div>
            <div class="card-body">
                <form action="admin_op.php" method="post">
                    <div class="form-group">
                        <label for="SchoolYear">Academic Year (Format: 23-24):</label>
                        <input type="text" class="form-control" id="SchoolYear" name="SchoolYear" placeholder="XX-XX">
                    </div>
                    <div class="form-group">
                        <label for="semester">Semester:</label>
                        <select class="form-control" id="semester" name="semester">
                            <option value="sem1">1st Semester</option>
                            <option value="sem2">2nd Semester</option>
                            <option value="sem3">Both Semesters</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary green border-0" name="add_acadYear">Add</button>
                    <br /><br />
                    <div class="form-group">
                        <select class="form-control" id="existingAcadYear" name="existingAcadYear">
                            <option value="current">Current</option>
                            <option value="2023-2024">2023-2024</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary green border-0" name="update_acadYear">Update</button>
                    <button type="submit" class="btn btn-primary maroon border-0" name="delete_acadYear">Delete</button>
                </form>
            </div>
        </div>
        <div class="p-3 chart-card m-2 card">
            <div class="card-header">Update Degree Program</div>
            <div class="card-body">
                <form action="admin_op.php" method="post">
                    <div class="form-group">
                        <label for="degprogID">Degree Program Code:</label>
                        <input type="text" class="form-control" id="degprogID" name="degprogID" placeholder="Enter degree program code">
                        <br />
                        <label for="name">Degree Program Name:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter degree program name">
                    </div>
                    <button type="submit" class="btn btn-primary green border-0" name="add_degree">Add</button>
                    <button type="submit" class="btn btn-primary green border-0" name="update_degree">Update</button>
                    <button type="submit" class="btn btn-primary maroon border-0" name="delete_degree">Delete</button>
                </form>
            </div>
        </div>
        
        </div>
        <h6 class="admin_header m-5">Admin > Student Data</h6>
    <div class="card-columns m-4">
        <div class="p-3 chart-card m-2 card">
            <div class="card-header">Update Degree Program Information</div>
            <div class="card-body">
                <form action="admin_op.php" method="post">
                    <div class="form-group">
                        <label for="degID">Degree Program:</label>
                        <select class="form-control" id="degID" name="degID">
                            <option value="BSAM">BSAM</option>
                            <option value="BSCS">BSCS</option>
                            <option value="BSDS">BSDS</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="timeID">Year:</label>
                        <select class="form-control" id="timeID" name="timeID">
                            <option value="2023-2024">2023-2024</option>
                            <option value="current">Current</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="semester">Semester:</label>
                        <select class="form-control" id="semester" name="semester">
                            <option value="sem1">1st Semester</option>
                            <option value="sem2">2nd Semester</option>
                            <option value="sem3">Both Semesters</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="count">Population:</label>
                        <input type="text" class="form-control" id="count" name="count" placeholder="Enter population number">
                    </div>
                    <button type="submit" class="btn btn-primary green border-0" name="add_student_data">Add</button>
                    <button type="submit" class="btn btn-primary green border-0" name="update_student_data">Update</button>
                    <button type="submit" class="btn btn-primary maroon border-0" name="delete_student_data">Delete</button>
                </form>
            </div>
        </div>
        <div class="p-3 chart-card m-2 card">
            <div class="card-header">Update Achievements</div>
            <div class="card-body">
                <form action="admin_op.php" method="post">
                    <div class="form-group">
                        <label for="awardTypeID">Achievement:</label>
                        <select class="form-control" id="awardTypeID" name="awardTypeID">
                            <option value="cs">College Scholar</option>
                            <option value="us">University Scholar</option>
                            <option value="cl">Cum Laude</option>
                            <option value="ml">Magna Cum Laude</option>
                            <option value="sl">Summa Cum Laude</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="timeID">Year:</label>
                        <select class="form-control" id="timeID" name="timeID">
                            <option value="2023-2024">2023-2024</option>
                            <option value="current">Current</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="semester">Semester:</label>
                        <select class="form-control" id="semester" name="semester">
                            <option value="sem1">1st Semester</option>
                            <option value="sem2">2nd Semester</option>
                            <option value="sem3">Both Semesters</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="count">Population:</label>
                        <input type="text" class="form-control" id="count" name="count" placeholder="Enter population number">
                    </div>
                    <button type="submit" class="btn btn-primary green border-0" name="add_achievement">Add</button>
                    <button type="submit" class="btn btn-primary green border-0" name="update_achievement">Update</button>
                    <button type="submit" class="btn btn-primary maroon border-0" name="delete_achievement">Delete</button>
                </form>
            </div>
        </div>
        <div class="p-3 chart-card m-2 card">
            <div class="card-header">Update Events</div>
            <div class="card-body">
                <form action="admin_op.php" method="post">
                    <div class="form-group">
                        <label for="eventName">Event:</label>
                        <input type="text" class="form-control" id="eventName" name="eventName" placeholder="Enter event">
                    </div>
                    <div class="form-group">
                        <label for="timeID">Year:</label>
                        <select class="form-control" id="timeID" name="timeID">
                            <option value="2023-2024">2023-2024</option>
                            <option value="current">Current</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="semester">Semester:</label>
                        <select class="form-control" id="semester" name="semester">
                            <option value="sem1">1st Semester</option>
                            <option value="sem2">2nd Semester</option>
                            <option value="sem3">Both Semesters</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="count">Population:</label>
                        <input type="text" class="form-control" id="count" name="count" placeholder="Enter population number">
                    </div>
                    <button type="submit" class="btn btn-primary green border-0" name="add_event">Add</button>
                    <button type="submit" class="btn btn-primary green border-0" name="update_event">Update</button>
                    <button type="submit" class="btn btn-primary maroon border-0" name="delete_event">Delete</button>
                </form>
            </div>
        </div>

        </div>
        <h6 class="admin_header m-5">Admin > Faculty Data</h6>
    <div class="card-columns m-4">
        <div class="p-3 chart-card m-2 card">
            <div class="card-header">Update Research/Publications</div>
            <div class="card-body">
                <form action="admin_op.php" method="post">
                    <div class="form-group">
                        <label for="title">Research Name:</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter Research Name">
                    </div>
                    <div class="form-group">
                        <label for="timeID">Year-Semester:</label>
                        <select class="form-control" id="timeID" name="timeID">
                            <option value="2023-1">2023-1st Semester</option>
                            <option value="2023-2">2023-2nd Semester</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="count">PARTICIPANTS:</label>
                        <input type="number" class="form-control" id="count" name="count" placeholder="Enter Number of Participants">
                    </div>
                    <button type="submit" class="btn btn-primary green border-0" name="add_publication">Add</button>
                    <button type="submit" class="btn btn-primary green border-0" name="update_publication">Update</button>
                    <button type="submit" class="btn btn-primary maroon border-0" name="delete_publication">Delete</button>
                </form>
            </div>
        </div>
        <div class="p-3 chart-card m-2 card">
            <div class="card-header">Update Faculty Information by Rank</div>
            <div class="card-body">
                <form action="admin_op.php" method="post">
                    <div class="form-group">
                        <label for="rankID">Rank:</label>
                        <select class="form-control" id="rankID" name="rankID">
                            <option value="prof1">Professor 1</option>
                            <option value="prof2">Professor 2</option>
                            <option value="prof3">Professor 3</option>
                            <option value="prof4">Professor 4</option>
                            <option value="prof5">Professor 5</option>
                            <option value="prof6">Professor 6</option>
                            <option value="assocProf1">Associate Professor 1</option>
                            <option value="assocProf2">Associate Professor 2</option>
                            <option value="assocProf3">Associate Professor 3</option>
                            <option value="assocProf4">Associate Professor 4</option>
                            <option value="assocProf5">Associate Professor 5</option>
                            <option value="asstProf1">Assistant Professor 1</option>
                            <option value="asstProf2">Assistant Professor 2</option>
                            <option value="asstProf3">Assistant Professor 3</option>
                            <option value="asstProf4">Assistant Professor 4</option>
                            <option value="asstProf5">Assistant Professor 5</option>
                            <option value="asstProf6">Assistant Professor 6</option>
                            <option value="instr1">Instructor 1</option>
                            <option value="instr2">Instructor 2</option>
                            <option value="instr3">Instructor 3</option>
                            <option value="lect">Lecturer</option>
                            <option value="senLect">Senior Lecturer</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="timeID">Year-Semester:</label>
                        <select class="form-control" id="timeID" name="timeID">
                            <option value="2023-1">2023-1st Semester</option>
                            <option value="2023-2">2023-2nd Semester</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="count">Population:</label>
                        <input type="number" class="form-control" id="count" name="count" placeholder="Enter Population Number">
                    </div>
                    <button type="submit" class="btn btn-primary green border-0" name="add_faculty_rank">Add</button>
                    <button type="submit" class="btn btn-primary green border-0" name="update_faculty_rank">Update</button>
                    <button type="submit" class="btn btn-primary maroon border-0" name="delete_faculty_rank">Delete</button>
                </form>
            </div>
        </div>
        <div class="p-3 chart-card m-2 card">
            <div class="card-header">Update Faculty Information by Educational Attainment</div>
            <div class="card-body">
                <form action="admin_op.php" method="post">
                    <div class="form-group">
                        <label for="educAttainmentID">Educational Attainment:</label>
                        <select class="form-control" id="educAttainmentID" name="educAttainmentID">
                            <option value="phd">Ph.D.</option>
                            <option value="msc">M.Sc.</option>
                            <option value="mm">M.M.</option>
                            <option value="mscs">MSCS</option>
                            <option value="mict">MICT</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="timeID">Year-Semester:</label>
                        <select class="form-control" id="timeID" name="timeID">
                            <option value="2023-1">2023-1st Semester</option>
                            <option value="2023-2">2023-2nd Semester</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="count">Population:</label>
                        <input type="number" class="form-control" id="count" name="count" placeholder="Enter Population Number">
                    </div>
                    <button type="submit" class="btn btn-primary green border-0" name="add_faculty_educattainment">Add</button>
                    <button type="submit" class="btn btn-primary green border-0" name="update_faculty_educattainment">Update</button>
                    <button type="submit" class="btn btn-primary maroon border-0" name="delete_faculty_educattainment">Delete</button>
                </form>
            </div>
        </div>
    </div>
    <footer class="maroon p-4">
        <p class="text-center text-white" style="font-family: 'Avenir Black';">© 2024 DMPCS</p>
    </footer>
</body>
<script src="script.js"></script>
<script src="students_script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

</html>
