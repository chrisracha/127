document.addEventListener("DOMContentLoaded", function () {
  fetchChartData("getchartdata.php", renderCharts);
});

function fetchChartData(url, callback) {
  fetch(url)
    .then((response) => response.json())
    .then((data) => callback(data))
    .catch((error) => console.error("Error fetching data:", error));
}

function renderCharts(data) {
  renderEnrolleesCourseChart(data.enrolleesCourseChart);
  renderEnrolleesYearChart(data.enrolleesYearChart);
  renderstudentsPerYear(data.studentsPerYear);
  renderScholarsChart(data.scholarsChart);
  renderUSperDegProg(data.USperDegProg);
  renderCSperDegProg(data.CSperDegProg);
  renderPopulationLaudes(data.PopulationLaudes);
  renderenrollmentDatat(data.enrollmentData);
}

function renderEnrolleesCourseChart(chartData) {
  var labels = chartData.map((item) => item.degprogID);
  var counts = chartData.map((item) => item.totalEnrollees);

  var ctx = document.getElementById("enrolleesCourseChart").getContext("2d");
  var myChart = new Chart(ctx, {
    type: "doughnut",
    data: {
      labels: labels,
      datasets: [
        {
          label: "Number of Enrollees",
          data: counts,
          backgroundColor: ["#8E1537", "#FFB81D", "#005740"],
          borderWidth: 5,
        },
      ],
    },
    options: {
      responsive: true,
    },
  });
}

function renderEnrolleesYearChart(chartData) {
  var labels = chartData.map((item) => item.SchoolYear);
  var counts = chartData.map((item) => item.totalEnrollees);

  var ctx = document.getElementById("enrolleesYearChart").getContext("2d");
  var myChart = new Chart(ctx, {
    type: "line",
    data: {
      labels: labels,
      datasets: [
        {
          label: "NUMBER OF ENROLLEES",
          data: counts,
          backgroundColor: ["#8E1537"],
          borderColor: ["#8E1537"],
          borderWidth: 1,
        },
      ],
    },
    options: {
      responsive: true,
    },
  });
}

function renderstudentsPerYear(chartData) {
  var yearLevels = chartData.map((item) => item.yearLevel);
  var degreePrograms = chartData.map((item) => item.totalStudents);

  var colors = {
    BSDS: "#8E1537",
    BSAM: "#FFB81D",
    BSCS: "#005740",
  };

  var dataPerProgram = degreePrograms.map((degprogID) => {
    return {
      label: degprogID,
      backgroundColor: colors[degprogID] || "#FFFFFF",
      data: yearLevels.map((yearLevel) => {
        var item = chartData.find(
          (item) => item.yearLevel === yearLevel && item.degprogID === degprogID
        );
        return item ? item.count : 0;
      }),
    };
  });

  var ctx = document.getElementById("studentsPerYear").getContext("2d");
  new Chart(ctx, {
    type: "bar",
    data: {
      labels: yearLevels,
      datasets: dataPerProgram,
    },
    options: {
      barValueSpacing: 20,
      responsive: true,
    },
  });
}

function renderScholarsChart(chartData) {
  // Extracting data for labels, college scholars, and university scholars
  var labels = chartData.map((item) => item.SchoolYear + " - " + item.semester);
  var collegeScholarsData = chartData
    .filter((item) => item.awardType === "CS")
    .map((item) => item.totalScholars);
  var universityScholarsData = chartData
    .filter((item) => item.awardType === "US")
    .map((item) => item.totalScholars);

  var ctx = document.getElementById("scholarsChart").getContext("2d");
  var myChart = new Chart(ctx, {
    type: "line",
    data: {
      labels: labels,
      datasets: [
        {
          label: "NUMBER OF COLLEGE SCHOLARS",
          data: collegeScholarsData,
          backgroundColor: "#8E1537",
          borderColor: "#8E1537",
          borderWidth: 1,
        },
        {
          label: "NUMBER OF UNIVERSITY SCHOLARS",
          data: universityScholarsData,
          backgroundColor: "#FFB81D",
          borderColor: "#FFB81D",
          borderWidth: 1,
        },
      ],
    },
    options: {
      responsive: true,
    },
  });
}

function renderUSperDegProg(chartData) {
  var labels = chartData.map((item) => item.name);
  var universityScholarsData = chartData.map((item) => item.UniversityScholars);
  var totalStudentsData = chartData.map((item) => item.totalStudents);
  var percentageUSData = chartData.map((item) => item.PercentageUS);

  var ctx = document.getElementById("USperDegProg").getContext("2d");
  var myChart = new Chart(ctx, {
    type: "doughnut",
    data: {
      labels: labels,
      datasets: [
        {
          label: "University Scholars",
          data: universityScholarsData,
          backgroundColor: ["#8E1537", "#FFB81D", "#005740"],
          borderColor: ["#8E1537", "#FFB81D", "#005740"],
          borderWidth: 5,
        },
        {
          label: "Total Students",
          data: totalStudentsData,
          backgroundColor: "rgba(255, 99, 132, 0.2)",
          borderColor: "rgba(255, 99, 132, 1)",
          borderWidth: 5,
        },
        {
          label: "Percentage of University Scholars",
          data: percentageUSData,
          backgroundColor: "rgba(54, 162, 235, 0.2)",
          borderColor: "rgba(54, 162, 235, 1)",
          borderWidth: 5,
        },
      ],
    },
    options: {
      //cutoutPercentage: 40,
      responsive: true,
    },
  });
}

function renderCSperDegProg(chartData) {
  var labels = chartData.map((item) => item.name);
  var collegeScholarsData = chartData.map((item) => item.CollegeScholars);
  var totalStudentsData = chartData.map((item) => item.totalStudents);
  var percentageCSData = chartData.map((item) => item.PercentageCS);

  var ctx = document.getElementById("CSperDegProg").getContext("2d");
  var myChart = new Chart(ctx, {
    type: "doughnut",
    data: {
      labels: labels,
      datasets: [
        {
          label: "College Scholars",
          data: collegeScholarsData,
          backgroundColor: "rgba(255, 99, 132, 0.2)",
          borderColor: "rgba(255, 99, 132, 1)",
          borderWidth: 5,
        },
        {
          label: "Total Students",
          data: totalStudentsData,
          backgroundColor: "rgba(54, 162, 235, 0.2)",
          borderColor: "rgba(54, 162, 235, 1)",
          borderWidth: 5,
        },
        {
          label: "Percentage of College Scholars",
          data: percentageCSData,
          backgroundColor: "rgba(75, 192, 192, 0.2)",
          borderColor: "rgba(75, 192, 192, 1)",
          borderWidth: 5,
        },
      ],
    },
    options: {
      //cutoutPercentage: 40,
      responsive: true,
    },
  });
}

function renderPopulationLaudes(chartData) {
  var labels = chartData.map((item) => item.awardType);
  var totalRecipients = chartData.map((item) => item.totalRecipients);

  var ctx = document.getElementById("PopulationLaudes").getContext("2d");
  var myChart = new Chart(ctx, {
    type: "line",
    data: {
      labels: labels,
      datasets: [
        {
          label: "NUMBER OF CUM LAUDE",
          data: totalRecipients,
          backgroundColor: [
            '#8E1537',
          ],
          borderColor: [
            '#8E1537'
          ],
          borderWidth: 1,
        }, {
            label: 'NUMBER OF MAGNA CUM LAUDE',
            data: totalRecipients,
            backgroundColor: [
              '#FFB81D',
            ],
            borderColor: [
              '#FFB81D'
            ],
            borderWidth: 1
          },{
            label: 'NUMBER OF SUMMA CUM LAUDE',
            data: totalRecipients,
            backgroundColor: [
              '#005740',
            ],
            borderColor: [
              '#005740'
            ],
            borderWidth: 1
          }
      ],
    },
    options: {
        responsive: true,
    },
  });
}
