<?php include 'fetch.php'; ?>
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
    <h6 class="admin_header m-5 indicator">Admin > Time Data</h6>
    <div class="card-columns m-4">
        <div class="p-3 chart-card m-2 card">
            <div class="card-header">Update Academic Year & Semester</div>
            <div class="card-body">
            <form action="admin_op.php" method="post">
                <div class="form-group">
                    <label for="SchoolYear">Academic Year (Format: 2023-2024):</label>
                    <input type="text" class="form-control" id="newSchoolYear" name="newSchoolYear" placeholder="XXXX-XXXX">
                </div>
                <div class="form-group">
                    <label for="semester">Semester:</label>
                    <select class="form-control" id="semester" name="semester">
                        <?php
                        foreach ($semesters as $semester) {
                            echo "<option value='$semester'>$semester</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary green border-0" name="add_acad">Add</button>
                <br /><br />
                <div class="form-group">
                    <label for="SchoolYear">Existing Academic Year:</label>
                    <select class="form-control" id="oldSchoolYear" name="oldSchoolYear">
                        <?php
                        foreach ($academic_years as $year) {
                            echo "<option value='$year'>$year</option>";
                        }
                        ?>
                    </select>
                    <input type="hidden" id="timeID" name="timeID" value="">
                </div>
                <button type="submit" class="btn btn-primary maroon border-0" name="delete_acad">Delete</button>
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
            <div class="card-header">Update Achievements</div>
            <div class="card-body">
                <form action="admin_op.php" method="post">
                <div class="form-group">
                    <label for="awardType">Achievement:</label>
                    <select class="form-control" id="awardType" name="awardType">
                        <?php
                        foreach ($awardtypes as $awardType) {
                            echo "<option value='$awardType'>$awardType</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="degprogID">Degree Program:</label>
                    <select class="form-control" id="degprogID" name="degprogID">
                        <?php
                        foreach ($degree_programs as $degprogID => $name) {
                            echo "<option value='$degprogID'>$name</option>";
                        }
                        ?>
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
    <div class="card-header">Update Degree Program Information</div>
    <div class="card-body">
        <form action="admin_op.php" method="post">
            <input type="hidden" id="degID" name="degID" value="<?php echo isset($degID) ? $degID : ''; ?>">
            <div class="form-group">
                <label for="degprogID">Degree Program:</label>
                <select class="form-control" id="degprogID" name="degprogID">
                    <?php
                    foreach ($degree_programs as $degprogID => $name) {
                        echo "<option value='$degprogID'>$name</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="yearLevel">Year Level:</label>
                <select class="form-control" id="yearLevel" name="yearLevel">
                    <?php
                    foreach ($year_level as $yearLevel => $yearlevel) {
                        echo "<option value='$yearLevel'>$yearlevel</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="SchoolYear">Year:</label>
                <select class="form-control" id="SchoolYear" name="SchoolYear">
                    <?php
                    foreach ($academic_years as $year) {
                        echo "<option value='$year'>$year</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="semester">Semester:</label>
                <select class="form-control" id="semester" name="semester">
                    <?php
                    foreach ($semesters as $semester) {
                        echo "<option value='$semester'>$semester</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="count">Population:</label>
                <input type="text" class="form-control" id="count" name="count" placeholder="Enter population number">
            </div>
            <button type="submit" class="btn btn-primary green border-0" name="action" value="add_deginfo">Add</button>
            <button type="submit" class="btn btn-primary green border-0" name="action" value="update_deginfo">Update</button>
            <button type="submit" class="btn btn-primary maroon border-0" name="action" value="delete_deginfo">Delete</button>
        </form>
    </div>
</div>


<div class="p-3 chart-card m-2 card">
    <div class="card-header">Update Events</div>
    <div class="card-body">
        <form action="admin_op.php" method="post">
            <div class="form-group">
                <label for="eventName">Event:</label>
                <input type="text" class="form-control" id="eventName" name="eventName" placeholder="Enter event name">
            </div>
            <div class="form-group">
                <label for="SchoolYear">Year:</label>
                <select class="form-control" id="SchoolYear" name="SchoolYear">
                    <?php
                    foreach ($academic_years as $year) {
                        echo "<option value='$year'>$year</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="semester">Semester:</label>
                <select class="form-control" id="semester" name="semester">
                    <?php
                    foreach ($semesters as $semester) {
                        echo "<option value='$semester'>$semester</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="count">Population:</label>
                <input type="text" class="form-control" id="count" name="count" placeholder="Enter population number">
            </div>
            <button type="submit" class="btn btn-primary green border-0" name="action" value="add_event">Add</button>
            <button type="submit" class="btn btn-primary green border-0" name="action" value="update_event">Update</button>
            <button type="submit" class="btn btn-primary maroon border-0" name="action" value="delete_event">Delete</button>
        </form>
    </div>
</div>

        </div>
        <h6 class="admin_header m-5">Admin > Faculty Data</h6>
    <div class="card-columns m-4">
    <div class="p-3 chart-card m-2 card">
    <div class="card-header">Update Research/Publications</div>
    <div class="card-body">
        <form id="researchForm" action="admin_op.php" method="post">
            <div class="form-group">
                <label for="title">Research Name:</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter Research Name">
            </div>
            <div class="form-group">
                <label for="SchoolYear">Year:</label>
                <select class="form-control" id="SchoolYear" name="SchoolYear">
                    <?php
                    foreach ($academic_years as $year) {
                        echo "<option value='$year'>$year</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="semester">Semester:</label>
                <select class="form-control" id="semester" name="semester">
                    <?php
                    foreach ($semesters as $semester) {
                        echo "<option value='$semester'>$semester</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="count">PARTICIPANTS:</label>
                <input type="number" class="form-control" id="count" name="count" placeholder="Enter Number of Participants">
            </div>
            <button type="submit" class="btn btn-primary green border-0" name="publication_action" value="add_publication">Add</button>
            <button type="submit" class="btn btn-primary green border-0" name="publication_action" value="update_publication">Update</button>
            <button type="submit" class="btn btn-primary maroon border-0" name="publication_action" value="delete_publication">Delete</button>
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
                        <?php
                        foreach ($ranks as $rankID => $title) {
                            echo "<option value='$rankID'>$title</option>";
                        }
                        ?>
                    </select>
                    </div>
                    <div class="form-group">
                    <label for="SchoolYear">Year:</label>
                    <select class="form-control" id="SchoolYear" name="SchoolYear">
                        <?php
                        foreach ($academic_years as $year) {
                            echo "<option value='$year'>$year</option>";
                        }
                        ?>
                    </select>
                    </div>
                    <div class="form-group">
                    <label for="semester">Semester:</label>
                    <select class="form-control" id="semester" name="semester">
                        <?php
                        foreach ($semesters as $semester) {
                            echo "<option value='$semester'>$semester</option>";
                        }
                        ?>
                    </select>
                    </div>
                    <div class="form-group">
                        <label for="count">Population:</label>
                        <input type="number" class="form-control" id="count" name="count" placeholder="Enter Population Number">
                    </div>
                    <button type="submit" class="btn btn-primary green border-0" name="">Add</button>
                    <button type="submit" class="btn btn-primary green border-0" name="">Update</button>
                    <button type="submit" class="btn btn-primary maroon border-0" name="">Delete</button>
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
                    <label for="SchoolYear">Year:</label>
                    <select class="form-control" id="SchoolYear" name="SchoolYear">
                        <?php
                        foreach ($academic_years as $year) {
                            echo "<option value='$year'>$year</option>";
                        }
                        ?>
                    </select>
                    </div>
                    <div class="form-group">
                    <label for="semester">Semester:</label>
                    <select class="form-control" id="semester" name="semester">
                        <?php
                        foreach ($semesters as $semester) {
                            echo "<option value='$semester'>$semester</option>";
                        }
                        ?>
                    </select>
                    </div>
                    <div class="form-group">
                        <label for="count">Population:</label>
                        <input type="number" class="form-control" id="count" name="count" placeholder="Enter Population Number">
                    </div>
                    <button type="submit" class="btn btn-primary green border-0" name="">Add</button>
                    <button type="submit" class="btn btn-primary green border-0" name="">Update</button>
                    <button type="submit" class="btn btn-primary maroon border-0" name="">Delete</button>
                </form>
            </div>
        </div>
    </div>
    <footer class="maroon p-4">
        <p class="text-center text-white" style="font-family: 'Avenir Black';">© 2024 DMPCS</p>
    </footer>
</body>
<script>
    document.getElementById('existingAcadYear').addEventListener('change', function() {
        document.getElementById('timeID').value = this.value;
    });
</script>
<script src="script.js"></script>
<script src="students_script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

</html>
