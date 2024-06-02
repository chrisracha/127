document.addEventListener("DOMContentLoaded", function () {
  fetchChartData("getchartdata.php", renderCharts);
  fetchChartData("getevent.php", renderEvents);
});

function fetchChartData(localhost, callback) {
  fetch(localhost)
    .then((response) => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    })
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
  renderenrollmentData(data.enrollmentChartData);
}

let enrolleesCourseChart;

function renderEnrolleesCourseChart(chartData) {
  var ctx = document.getElementById("enrolleesCourseChart").getContext("2d");

  var datasets = chartData.map((item, index) => {
    return {
      label: item.degprogName,
      data: [item.totalEnrollees],
      backgroundColor: ["#8E1537", "#FFB81D", "#005740"][index % 3],
    };
  });

  enrolleesCourseChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: ['Enrollees'],
      datasets: datasets,
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'bottom'
        }
      }
    },
  });
}

let enrolleesYearChart;

function renderEnrolleesYearChart(chartData) {
  var labels = chartData.map((item) => item.SchoolYear);
  var counts = chartData.map((item) => item.totalEnrollees);

  var ctx = document.getElementById("enrolleesYearChart").getContext("2d");
  enrolleesYearChart = new Chart(ctx, {
    type: "line",
    data: {
      labels: labels,
      datasets: [
        {
          label: "Number of Enrollees",
          data: counts,
          backgroundColor: ["#8E1537"],
          borderColor: ["#8E1537"],
          borderWidth: 1,
        },
      ],
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'bottom'
        }
      }
    },
  });
}

let studentsPerYear;

function renderstudentsPerYear(chartData) {
  // Extract unique year levels and degree programs from the chartData
  var yearLevels = [...new Set(chartData.map((item) => item.yearLevel))];
  var degreePrograms = [...new Set(chartData.map((item) => item.degprogName))];

  // Define colors for each degree program with full names
  var colors = {
    "Bachelor of Science in Data Science": "#8E1537",
    "Bachelor of Science in  Applied Mathematics": "#FFB81D",
    "Bachelor of Science in Computer Science": "#005740",
  };

  // Create datasets for each degree program
  var datasets = degreePrograms.map((degprogName) => {
    return {
      label: degprogName,
      backgroundColor: colors[degprogName] || "#FFFFFF",
      data: yearLevels.map((yearLevel) => {
        var item = chartData.find(
          (item) => item.yearLevel === yearLevel && item.degprogName === degprogName
        );
        console.log(`Year: ${yearLevel}, Program: ${degprogName}, Students: ${item ? item.totalStudents : 0}`);
        return item ? item.totalStudents : 0;
      }),
      options: {
        plugins: {
          legend: {
            position: 'bottom'
          }
        }
      }
    };
  });

  // Log the datasets to debug
  console.log(datasets);

  // Create the chart
  var ctx = document.getElementById("studentsPerYear").getContext("2d");
  studentsPerYear = new Chart(ctx, {
    type: "bar",
    data: {
      labels: yearLevels,
      datasets: datasets,
    },
    options: {
      barValueSpacing: 20,
      responsive: true,
      plugins: {
        legend: {
          position: 'bottom'
        }
      }
    },
  });
}

let scholarsChart;

function renderScholarsChart(chartData) {

  console.log("Scholars Chart Data:", chartData);

  // Extract unique labels (SchoolYear - semester) from the chartData
  var labels = [...new Set(chartData.map((item) => item.SchoolYear + " - " + item.semester))];

  // Initialize arrays to hold the data points
  var collegeScholarsData = new Array(labels.length).fill(0);
  var universityScholarsData = new Array(labels.length).fill(0);

  // Fill the data arrays with the corresponding values
  chartData.forEach((item) => {
    var label = item.SchoolYear + " - " + item.semester;
    var index = labels.indexOf(label);
    if (index !== -1) {
      if (item.awardType == "College Scholar") {
        collegeScholarsData[index] = Number(item.totalScholars);
      } else if (item.awardType == "University Scholar") {
        universityScholarsData[index] = Number(item.totalScholars);
      }
    }
  });

  // Logging the processed data to debug
  console.log("Labels:", labels);
  console.log("College Scholars Data:", collegeScholarsData);
  console.log("University Scholars Data:", universityScholarsData);

  var ctx = document.getElementById("scholarsChart").getContext("2d");
  scholarsChart = new Chart(ctx, {
    type: "line",
    data: {
      labels: labels,
      datasets: [
        {
          label: "Number of College Scholars",
          data: collegeScholarsData,
          backgroundColor: "#8E1537",
          borderColor: "#8E1537",
          borderWidth: 1,
          fill: false,
        },
        {
          label: "Number of University Scholars",
          data: universityScholarsData,
          backgroundColor: "#FFB81D",
          borderColor: "#FFB81D",
          borderWidth: 1,
          fill: false,
        },
      ],
    },
    options: {
      plugins: {
        legend: {
          position: 'bottom'
        }
      },
      responsive: true,
      scales: {
        x: {
          title: {
            display: true,
            text: 'School Year - Semester',
          },
        },
        y: {
          title: {
            display: true,
          },
          beginAtZero: true,
        },
      },
    },
  });
}

let USperDegProg;

function renderUSperDegProg(chartData) {
  // Define colors for each program
  var colors = {
    "Bachelor of Science in Computer Science": "#8E1537",
    "Bachelor of Science in Data Science": "#FFB81D",
    "Bachelor of Science in  Applied Mathematics": "#005740"
  };

  // Get unique degree programs
  var degreePrograms = [...new Set(chartData.map((item) => item.name))];

  // Create a dataset for each degree program
  var datasets = degreePrograms.map((program) => {
    var data = chartData.reduce((total, item) => {
      if (item.name === program) {
        total += item.UniversityScholars;
      }
      return total;
    }, 0);
    return {
      label: program,
      data: [data], // Wrap data in an array because Chart.js expects an array
      backgroundColor: colors[program] || "#000000",
      borderColor: "#ffffff",
      borderWidth: 5,
    };
  });

  var ctx = document.getElementById("USperDegProg").getContext("2d");
  USperDegProg = new Chart(ctx, {
    type: "bar",
    data: {
      labels: ['University Scholars'], // Use a static label because there's only one data point per dataset
      datasets: datasets,
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'bottom'
        }
      },
      scales: {
        x: {
          beginAtZero: true,
        },
        y: {
          beginAtZero: true
        }
      }
    },
  });
}
let CSperDegProg;

function renderCSperDegProg(chartData) {
  // Define colors for each program
  var colors = {
    "Bachelor of Science in Computer Science": "#8E1537",
    "Bachelor of Science in Data Science": "#FFB81D",
    "Bachelor of Science in  Applied Mathematics": "#005740"
  };

  // Get unique degree programs
  var degreePrograms = [...new Set(chartData.map((item) => item.name))];

  // Create a dataset for each degree program
  var datasets = degreePrograms.map((program) => {
    var data = chartData.reduce((total, item) => {
      if (item.name === program) {
        total += item.CollegeScholars;
      }
      return total;
    }, 0);
    return {
      label: program,
      data: [data], // Wrap data in an array because Chart.js expects an array
      backgroundColor: colors[program] || "#000000",
      borderColor: "#ffffff",
      borderWidth: 5,
    };
  });

  var ctx = document.getElementById("CSperDegProg").getContext("2d");
  CSperDegProg = new Chart(ctx, {
    type: "bar",
    data: {
      labels: ['College Scholars'], // Use a static label because there's only one data point per dataset
      datasets: datasets,
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'bottom'
        }
      },
      scales: {
        x: {
          beginAtZero: true,
        },
        y: {
          beginAtZero: true
        }
      }
    },
  });
}

let PopulationLaudes;

function renderPopulationLaudes(chartData) {
  var labels = [...new Set(chartData.map((item) => item.SchoolYear))];

  var datasets = labels.map((label) => {
    var dataForLabel = chartData.filter((item) => item.SchoolYear === label);
    return {
      label: label,
      cumLaude: dataForLabel.find((item) => item.awardType === "Cum Laude")?.totalRecipients || 0,
      magnaCumLaude: dataForLabel.find((item) => item.awardType === "Magna cum Laude")?.totalRecipients || 0,
      summaCumLaude: dataForLabel.find((item) => item.awardType === "Summa cum Laude")?.totalRecipients || 0,
    };
  });

  var cumLaudeCounts = datasets.map((item) => item.cumLaude);
  var magnaCumLaudeCounts = datasets.map((item) => item.magnaCumLaude);
  var summaCumLaudeCounts = datasets.map((item) => item.summaCumLaude);

  var ctx = document.getElementById("PopulationLaudes").getContext("2d");
  PopulationLaudes = new Chart(ctx, {
    type: "line",
    data: {
      labels: labels,
      datasets: [
        {
          label: "Cum Laude",
          data: cumLaudeCounts,
          borderColor: '#8E1537',
          backgroundColor: '#8E1537',
          fill: false,
          borderWidth: 2
        },
        {
          label: "Magna Cum Laude",
          data: magnaCumLaudeCounts,
          borderColor: '#FFB81D',
          backgroundColor: '#FFB81D',
          fill: false,
          borderWidth: 2
        },
        {
          label: "Summa Cum Laude",
          data: summaCumLaudeCounts,
          borderColor: '#005740',
          backgroundColor: '#005740',
          fill: false,
          borderWidth: 2
        }
      ]
    },
    options: {
      plugins: {
        legend: {
          position: 'bottom'
        }
      },
      responsive: true,
      scales: {
        x: {
          title: {
            display: true,
            text: 'School Year'
          }
        },
        y: {
          title: {
            display: true,
            text: 'Count'
          }
        }
      }
    }
  });
}

let enrollmentChartData;

function renderenrollmentData(enrollmentData) {
  const degreePrograms = [...new Set(enrollmentData.map(item => item.DegreeProgram))];
  const labels = [...new Set(enrollmentData.map(item => 'School Year ' + item.SchoolYear + ', Semester ' + item.semester))];

  const datasets = degreePrograms.map(program => {
    const programData = enrollmentData.filter(item => item.DegreeProgram === program);
    const data = labels.map(label => {
      const item = programData.find(d => 'School Year ' + d.SchoolYear + ', Semester ' + d.semester === label);
      return item ? item.totalEnrollees : null;
    });
    const backgroundColor = getBackgroundColor(program); // Define color dynamically
    return {
      label: program,
      backgroundColor: backgroundColor,
      data: data
    };
  });

  var ctx = document.getElementById('enrollmentData').getContext('2d');
  enrollmentChartData = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: datasets
    },
    options: {
      barValueSpacing: 20,
      responsive: true,
      plugins: {
        legend: {
          position: 'bottom'
        }
      } 
    }
  });
}

function renderEvents(data) {
  var tableBody = '';
  data.events.forEach(function(event) {
    tableBody += '<tr><td>' + event.eventName + '</td><td>' + event.count + '</td></tr>';
  });

  $('#eventTable tbody').html(tableBody);
}

// Helper function to dynamically assign background color based on degree program
function getBackgroundColor(program) {
  switch (program) {
    case "Bachelor of Science in Data Science":
      return "#8E1537";
    case "Bachelor of Science in  Applied Mathematics":
      return "#FFB81D";
    case "Bachelor of Science in Computer Science":
      return "#005740";
    default:
      return "#000000"; // Default color if program not matched
  }
}

$(document).ready(function() {
  $('#filterButton').on('submit', function(e) {
      e.preventDefault();

      var fromYear = $('#fromYear').val();
      var toYear = $('#toYear').val();
      var fromSemester = $('#fromSemester').val();
      var toSemester = $('#toSemester').val();

      console.log("Inputted in Form", fromYear, toYear, fromSemester, toSemester);

      $.ajax({
          url: 'getchartdata.php',
          method: 'POST',
          data: {
              fromYear: fromYear,
              toYear: toYear,
              fromSemester: fromSemester,
              toSemester: toSemester
          },
          success: function(response) {
              var data = JSON.parse(response);
              rerenderCharts(data);
          }
      });

      $.ajax({
        url: 'getevent.php',
        method: 'POST',
        data: {
            fromYear: fromYear,
            toYear: toYear,
            fromSemester: fromSemester,
            toSemester: toSemester
        },
        success: function(data) {
            var data = JSON.parse(data);
            console.log(data);

            var tableBody = '';
            data.events.forEach(function(event) {
            tableBody += '<tr><td>' + event.eventName + '</td><td>' + event.count + '</td></tr>';
            });

            $('#eventTable tbody').html(tableBody);
        }
      })
});

function destroyCharts() {
  enrolleesCourseChart.destroy();
  enrolleesYearChart.destroy();
  studentsPerYear.destroy();
  scholarsChart.destroy();
  USperDegProg.destroy();
  CSperDegProg.destroy();
  PopulationLaudes.destroy();
  enrollmentChartData.destroy();
}

function rerenderCharts(data) {
  destroyCharts();
  renderCharts(data);
}});