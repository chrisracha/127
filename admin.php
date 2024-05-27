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
                        <label for="degreeCode">Academic Year (Format: 23-24):</label>
                        <input type="text" class="form-control" id="acadYear" name="degreeCode"
                            placeholder="XX-XX"></div>
                    <div class="form-group">
                        <label for="degreeCode">Semester:</label>
                        <select class="form-control" id="degree">
                            <option value="sem1">1st Semester</option>
                            <option value="sem2">2nd Semester</option>
                            <option value="sem3">Both Semesters</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary green border-0" name="add_acadYear">Add</button>
                    <br />
                    <br />
                    <div class="form-group">
                        <select class="form-control" id="degree">
                            <option value="sem1">Current</option>
                            <option value="sem2">2023-2024</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary maroon border-0" name="delete_acadYear">Delete</button>
                </form>
            </div>
        </div>
        
        <div class="p-3 chart-card m-2 card">
            <div class="card-header">Update Degree Program</div>
            <div class="card-body">
                <form action="admin_op.php" method="post">
                    <div class="form-group">
                        <label for="degreeCode">Degree Program Code:</label>
                        <input type="text" class="form-control" id="degreeCode" name="degreeCode"
                            placeholder="Enter degree program code">
                        <br />
                        <label for="degreeName">Degree Program Name:</label>
                        <input type="text" class="form-control" id="degreeName" name="degreeName"
                            placeholder="Enter degree program name">
                    </div>
                    <button type="submit" class="btn btn-primary green border-0" name="add_degree">Add</button>
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
                <form>
                    <div class="form-group">
                        <label for="degree">Degree Program:</label>
                        <select class="form-control" id="degree">
                            <option value="program1">BSAM</option>
                            <option value="program2">BSCS</option>
                            <option value="program3">BSDS</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="year">Year:</label>
                        <select class="form-control" id="degree">
                            <option value="sem1">Current</option>
                            <option value="sem2">2023-2024</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="degree">Semester:</label>
                        <select class="form-control" id="degree">
                            <option value="sem1">1st Semester</option>
                            <option value="sem2">2nd Semester</option>
                            <option value="sem3">Both Semesters</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="population">Population:</label>
                        <input type="text" class="form-control" id="population" placeholder="Enter population number">
                    </div>
                    <button type="submit" class="btn btn-primary green border-0">Update</button>
                </form>
            </div>
        </div>
        <div class="p-3 chart-card m-2 card">
            <div class="card-header">Update Achievements</div>
            <div class="card-body">
                <form>
                    <div class="form-group" id="degree">
                        <label for="degree">Achievement:</label>
                        <select class="form-control" id="degree">
                            <option value="cs">College Scholar</option>
                            <option value="us">University Scholar</option>
                            <option value="cl">Cum Laude</option>
                            <option value="ml">Magna Cum Laude</option>
                            <option value="sl">Summa Cum Laude</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="year">Year:</label>
                        <select class="form-control" id="degree">
                            <option value="sem1">Current</option>
                            <option value="sem2">2023-2024</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="degree">Semester:</label>
                        <select class="form-control" id="degree">
                            <option value="sem1">1st Semester</option>
                            <option value="sem2">2nd Semester</option>
                            <option value="sem3">Both Semesters</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="population">Population:</label>
                        <input type="text" class="form-control" id="population" placeholder="Enter population number">
                    </div>
                    <button type="submit" class="btn btn-primary green border-0">Update</button>
                </form>
            </div>
            </div>
        <div class="p-3 chart-card m-2 card">
            <div class="card-header">Update Events</div>
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label for="population">EVENT NAME:</label>
                        <input type="text" class="form-control" id="population" placeholder="Enter population number">
                    </div>
                    <div class="form-group">
                        <label for="year">Year:</label>
                        <select class="form-control" id="degree">
                            <option value="sem1">Current</option>
                            <option value="sem2">2023-2024</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="degree">Semester:</label>
                        <select class="form-control" id="degree">
                            <option value="sem1">1st Semester</option>
                            <option value="sem2">2nd Semester</option>
                            <option value="sem3">Both Semesters</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="population">PARTICIPANTS:</label>
                        <input type="text" class="form-control" id="population" placeholder="Enter population number">
                    </div>
                    <button type="submit" class="btn btn-primary green border-0">Update</button>
                </form>
            </div>
        </div>
        </div>
        <h6 class="admin_header m-5">Admin > Faculty Data</h6>
        <div class="card-columns m-4">
        <div class="p-3 chart-card m-2 card">
            <div class="card-header">Update Research/Publications</div>
            <div class="card-body">
                <form action="your_php_file.php" method="post">
                    <div class="form-group">
                        <label for="researchName">Research Name:</label>
                        <input type="text" class="form-control" id="researchName" name="researchName" placeholder="Enter Research Name">
                    </div>
                    <div class="form-group">
                        <label for="year">Year:</label>
                        <select class="form-control" id="year" name="year">
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="semester">Semester:</label>
                        <select class="form-control" id="semester" name="semester">
                            <option value="1st Semester">1st Semester</option>
                            <option value="2nd Semester">2nd Semester</option>
                            <option value="Both Semesters">Both Semesters</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="participants">PARTICIPANTS:</label>
                        <input type="number" class="form-control" id="participants" name="participants" placeholder="Enter Number of Participants">
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
                <form>
                    <div class="form-group" id="degree">
                        <label for="degree">RANK:</label>
                        <select class="form-control" id="degree">
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
                        <label for="year">Year:</label>
                        <select class="form-control" id="degree">
                            <option value="sem1">Current</option>
                            <option value="sem2">2023-2024</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="degree">Semester:</label>
                        <select class="form-control" id="degree">
                            <option value="sem1">1st Semester</option>
                            <option value="sem2">2nd Semester</option>
                            <option value="sem3">Both Semesters</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="population">Population:</label>
                        <input type="text" class="form-control" id="population" placeholder="Enter population number">
                    </div>
                    <button type="submit" class="btn btn-primary green border-0">Update</button>
                </form>
            </div>
        </div>
        <div class="p-3 chart-card m-2 card">
            <div class="card-header">Update Faculty Information by Educational Attainment</div>
            <div class="card-body">
                <form>
                    <div class="form-group" id="degree">
                        <label for="degree">Educ. Attainment:</label>
                        <select class="form-control" id="degree">
                            <option value="phd">Ph.D.</option>
                            <option value="msc">M.Sc.</option>
                            <option value="mm">M.M.</option>
                            <option value="mscs">MSCS</option>
                            <option value="mict">MICT</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="year">Year:</label>
                        <select class="form-control" id="degree">
                            <option value="sem1">Current</option>
                            <option value="sem2">2023-2024</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="degree">Semester:</label>
                        <select class="form-control" id="degree">
                            <option value="sem1">1st Semester</option>
                            <option value="sem2">2nd Semester</option>
                            <option value="sem3">Both Semesters</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="population">Population:</label>
                        <input type="text" class="form-control" id="population" placeholder="Enter population number">
                    </div>
                    <button type="submit" class="btn btn-primary green border-0">Update</button>
                </form>
            </div>
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
