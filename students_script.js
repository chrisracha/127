document.addEventListener("DOMContentLoaded", function () {
  fetchChartData("getchartdata.php", renderCharts);
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
  renderenrollmentData(data.enrollmentData);
}

function renderEnrolleesCourseChart(chartData) {
  var labels = chartData.map((item) => item.degprogName);
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
      plugins: {
        legend: {
          position: 'bottom'
        }
      }
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
  new Chart(ctx, {
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
  new Chart(ctx, {
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


function renderUSperDegProg(chartData) {
  // Define colors for each program
  var colors = {
    "Bachelor of Science in Computer Science": "#8E1537",
    "Bachelor of Science in Data Science": "#FFB81D",
    "Bachelor of Science in  Applied Mathematics": "#005740"
  };

  // Extract the data from chartData
  var labels = chartData.map((item) => item.name);
  var universityScholarsData = chartData.map((item) => item.UniversityScholars);
  var totalStudentsData = chartData.map((item) => item.totalStudents);

  // Assign colors based on the labels
  var backgroundColors = labels.map(label => colors[label] || "#000000"); 

  var ctx = document.getElementById("USperDegProg").getContext("2d");
  var myChart = new Chart(ctx, {
    type: "doughnut",
    data: {
      labels: labels,
      datasets: [
        {
          label: "University Scholars",
          data: universityScholarsData,
          backgroundColor: backgroundColors,
          borderColor: "#ffffff",
          borderWidth: 5,
        },
        {
          label: "Total Students",
          data: totalStudentsData,
          backgroundColor: backgroundColors.map(color => color + "80"), 
          borderColor: "#ffffff",
          borderWidth: 2,
          hidden: true 
        }
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


function renderCSperDegProg(chartData) {
  // Define colors for each program
  var colors = {
    "Bachelor of Science in Computer Science": "#8E1537",
    "Bachelor of Science in Data Science": "#FFB81D",
    "Bachelor of Science in  Applied Mathematics": "#005740"
  };

  var labels = chartData.map((item) => item.name);
  var collegeScholarsData = chartData.map((item) => item.CollegeScholars);
  var totalStudentsData = chartData.map((item) => item.totalStudents);

  var backgroundColors = labels.map(label => colors[label] || "#000000"); // Default to black if label not found
  
  var ctx = document.getElementById("CSperDegProg").getContext("2d");
  var myChart = new Chart(ctx, {
    type: "doughnut",
    data: {
      labels: labels,
      datasets: [
        {
          label: "College Scholars",
          data: collegeScholarsData,
          backgroundColor: backgroundColors,
          borderColor: "#ffffff",
          borderWidth: 5,
        },
        {
          label: "Total Students",
          data: totalStudentsData,
          backgroundColor: backgroundColors.map(color => color + "80"), // Adding alpha channel for transparency
          borderColor: "#ffffff",
          borderWidth: 2,
          hidden: true // Hide the total students data initially
        }
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


function renderPopulationLaudes(chartData) {
  var labels = chartData.map((item) => item.SchoolYear);
  var cumLaudeCounts = chartData.filter((item) => item.awardType === "Cum Laude").map((item) => item.totalRecipients);
  var magnaCumLaudeCounts = chartData.filter((item) => item.awardType === "Magna cum Laude").map((item) => item.totalRecipients);
  var summaCumLaudeCounts = chartData.filter((item) => item.awardType === "Summa cum Laude").map((item) => item.totalRecipients);

  var ctx = document.getElementById("PopulationLaudes").getContext("2d");
  var myChart = new Chart(ctx, {
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

function renderenrollmentData(enrollmentData) {
  // Extract degree programs and their respective data
  const degreePrograms = enrollmentData.reduce((programs, item) => {
    if (!programs.includes(item.DegreeProgram)) {
      programs.push(item.DegreeProgram);
    }
    return programs;
  }, []);

  const labels = ["1st Semester", "2nd Semester"];
  const datasets = degreePrograms.map(program => {
    const data = enrollmentData
      .filter(item => item.DegreeProgram === program)
      .map(item => item.totalEnrollees);
    const backgroundColor = getBackgroundColor(program); // Define color dynamically
    return {
      label: program,
      backgroundColor: backgroundColor,
      data: data
    };
  });

  var ctx = document.getElementById('enrollmentData').getContext('2d');
  var myChart = new Chart(ctx, {
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
