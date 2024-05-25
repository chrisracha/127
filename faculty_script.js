document.addEventListener("DOMContentLoaded", function () {
  fetchChartData("getchart_faculty.php", renderCharts);
});

function fetchChartData(localhost, callback) {
  fetch(localhost)
    .then((response) => response.json())
    .then((data) => callback(data))
    .catch((error) => console.error("Error fetching data:", error));
}

function renderCharts(data) {
  renderratioByRank(data.ratioByRankChart);
  renderratioByEduc(data.ratioByEducChart);
  rendernumberOfPublications(data.numberOfPublicationsChart);
  renderresearchInvolvement(data.researchInvolvementChart);
  renderfacultyNoYearlybyRank(data.facultyNoYearlybyRankChart);
  renderfacultyNoYearlybyEduc(data.facultyNoYearlybyEducChart);
  rendernumberOfTotalFaculty(data.numberOfTotalFacultyChart); 
}

function renderratioByRank(chartData){
  var labels = chartData.map((item) => item.facultyRank);
  var counts = chartData.map((item) => item.rankCount);
} 

var ctx = document.getElementById("ratioByRankChart");
var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: labels,
        datasets: [{
            label: 'Ratio by Rank',
            data: counts,
            backgroundColor: [
                '#8E1537',
                '#FFB81D',
                '#005740',
                '#8E1537',
                '#' + Math.floor(Math.random()*16777215).toString(16),
                '#' + Math.floor(Math.random()*16777215).toString(16)
            ],
            borderWidth: 5
        }]
    },
    options: {
        responsive: true,
    }
});

function facultyNoYearlybyRank(chartData){

    // Logging the chartData to debug
    console.log("Chart Data:", chartData);
  
    // Extract unique labels (SchoolYear) from the chartData
    var labels = [...new Set(chartData.map((item) => item.SchoolYear))];
  
    // Prepare objects to hold data points for each rank
    var professorData = new Array(labels.length).fill(0);
    var associateProfessorData = new Array(labels.length).fill(0);
    var assistantProfessorData = new Array(labels.length).fill(0);
    var instructorData = new Array(labels.length).fill(0);
  
    // Fill the data arrays with the corresponding values
    chartData.forEach((item) => {
      var index = labels.indexOf(item.SchoolYear);
      switch(item.Rank) {
        case "Professor":
          professorData[index] = item.totalFaculty;
          break;
        case "Associate Professor":
          associateProfessorData[index] = item.totalFaculty;
          break;
        case "Assistant Professor":
          assistantProfessorData[index] = item.totalFaculty;
          break;
        case "Instructor":
          instructorData[index] = item.totalFaculty;
          break;
      }
    });
  
    // Logging the processed data to debug
    console.log("Labels:", labels);
    console.log("Professor Data:", professorData);
    console.log("Associate Professor Data:", associateProfessorData);
    console.log("Assistant Professor Data:", assistantProfessorData);
    console.log("Instructor Data:", instructorData);
  
    var ctx = document.getElementById("facultyNoYearlybyRankChart").getContext("2d");
    new Chart(ctx, {
      type: "line",
      data: {
        labels: labels,
        datasets: [
          {
            label: "NUMBER OF PROFESSORS",
            data: professorData,
            backgroundColor: "#8E1537",
            borderColor: "#8E1537",
            borderWidth: 1,
            fill: false,
          },
          {
            label: "NUMBER OF ASSOCIATE PROFESSORS",
            data: associateProfessorData,
            backgroundColor: "#FFB81D",
            borderColor: "#FFB81D",
            borderWidth: 1,
            fill: false,
          },
          {
            label: "NUMBER OF ASSISTANT PROFESSORS",
            data: assistantProfessorData,
            backgroundColor: "#005740",
            borderColor: "#005740",
            borderWidth: 1,
            fill: false,
          },
          {
            label: "NUMBER OF INSTRUCTORS",
            data: instructorData,
            backgroundColor: '#' + Math.floor(Math.random()*16777215).toString(16), // Random color for demonstration
            borderColor: '#' + Math.floor(Math.random()*16777215).toString(16),
            borderWidth: 1,
            fill: false,
          }
        ],
      },
      options: {
        responsive: true,
        scales: {
          x: {
            title: {
              display: true,
              text: 'School Year',
            },
          },
          y: {
            title: {
              display: true,
              text: 'Number of Faculty',
            },
            beginAtZero: true,
          },
        },
      },
    });
}

function ratioByEduc(chartData){
  var labels = chartData.map((item) => item.educationalAttainment);
  var counts = chartData.map((item) => item.facultyCount);
} 

var ctx = document.getElementById("ratioByEducChart");
var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: labels,
        datasets: [{
            label: 'Ratio by Educational Attainment',
            data: counts,
            backgroundColor: [
                '#8E1537',
                '#FFB81D',
                '#005740',
                '#' + Math.floor(Math.random()*16777215).toString(16),
            ],
            borderWidth: 5
        }]
    },
    options: {
        responsive: true,
    }
});

function renderfacultyNoYearlybyEduc(chartData){

    // Logging the chartData to debug
    console.log("Chart Data:", chartData);
  
    // Extract unique labels (SchoolYear) from the chartData
    var labels = [...new Set(chartData.map((item) => item.SchoolYear))];
  
    // Prepare objects to hold data points for each educational attainment
    var phdData = new Array(labels.length).fill(0);
    var msData = new Array(labels.length).fill(0);
    var mmData = new Array(labels.length).fill(0);
    var mscsData = new Array(labels.length).fill(0);
  
    // Fill the data arrays with the corresponding values
    chartData.forEach((item) => {
      var index = labels.indexOf(item.SchoolYear);
      switch(item.EducationalAttainment) {
        case "Ph.D.":
          phdData[index] = item.totalFaculty;
          break;
        case "M. Sc.":
          msData[index] = item.totalFaculty;
          break;
        case "M. M.":
          mmData[index] = item.totalFaculty;
          break;
        case "MSCS, MICT":
          mscsData[index] = item.totalFaculty;
          break;
      }
    });
  
    // Logging the processed data to debug
    console.log("Labels:", labels);
    console.log("PhD Data:", phdData);
    console.log("M. Sc. Data:", msData);
    console.log("M. M. Data:", mmData);
    console.log("MSCS Data:", mscsData);
  
    var ctx = document.getElementById("facultyNoYearlybyEducChart").getContext("2d");
    new Chart(ctx, {
      type: "line",
      data: {
        labels: labels,
        datasets: [
          {
            label: "NUMBER OF PHD",
            data: phdData,
            backgroundColor: "#8E1537",
            borderColor: "#8E1537",
            borderWidth: 1,
            fill: false,
          },
          {
            label: "NUMBER OF M. SC.",
            data: msData,
            backgroundColor: "#FFB81D",
            borderColor: "#FFB81D",
            borderWidth: 1,
            fill: false,
          },
          {
            label: "NUMBER OF M. M.",
            data: mmData,
            backgroundColor: "#005740",
            borderColor: "#005740",
            borderWidth: 1,
            fill: false,
          },
          {
            label: "NUMBER OF MSCS",
            data: mscsData,
            backgroundColor: '#' + Math.floor(Math.random()*16777215).toString(16), // MSCS color is still random
            borderColor: '#' + Math.floor(Math.random()*16777215).toString(16),
            borderWidth: 1,
            fill: false,
          }
        ],
      },
      options: {
        responsive: true,
        scales: {
          x: {
            title: {
              display: true,
              text: 'School Year',
            },
          },
          y: {
            title: {
              display: true,
              text: 'Number of Faculty',
            },
            beginAtZero: true,
          },
        },
      },
    });
  }

var ctx = document.getElementById('numberOfNewFaculty').getContext("2d");
var myChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ["22-23 1st Semester", "22-23 2nd Semester", "23-24 1st Semester", "23-24 2nd Semester"],
    datasets: [{
      label: 'New Faculty',
      data: [12, 19, 3, 5],
      backgroundColor: [
        '#8E1537',
      ],
      borderColor: [
        '#8E1537'
      ],
      borderWidth: 1
    }
    ]    
  },
  options: {
    responsive: true,
  }
});

function rendernumberOfTotalFaculty(chartData) {
  // Logging the chartData to debug
  console.log("Chart Data:", chartData);

  // Extract unique labels (SchoolYear - Semester) from the chartData
  var labels = [...new Set(chartData.map((item) => item.SchoolYear + " - " + item.semester))];

  // Initialize an array to hold the data points for total faculty
  var totalFacultyData = new Array(labels.length).fill(0);

  // Fill the data array with the corresponding values
  chartData.forEach((item) => {
    var label = item.SchoolYear + " - " + item.semester;
    var index = labels.indexOf(label);
    if (index !== -1) {
      totalFacultyData[index] = item.totalFaculty;
    }
  });

  // Logging the processed data to debug
  console.log("Labels:", labels);
  console.log("Total Faculty Data:", totalFacultyData);

  var ctx = document.getElementById("numberOfTotalFaculty").getContext("2d");
  new Chart(ctx, {
    type: "line",
    data: {
      labels: labels,
      datasets: [
        {
          label: "TOTAL FACULTY",
          data: totalFacultyData,
          backgroundColor: "#8E1537",
          borderColor: "#8E1537",
          borderWidth: 1,
          fill: false,
        }
      ],
    },
    options: {
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
            text: 'Number of Faculty',
          },
          beginAtZero: true,
        },
      },
    },
  });
}

function rendernumberOfPublications(chartData) {
  // Logging the chartData to debug
  console.log("Chart Data:", chartData);

  // Extract unique labels (SchoolYear) from the chartData
  var labels = [...new Set(chartData.map((item) => item.SchoolYear))];

  // Initialize an array to hold the data points for total publications
  var totalPublicationsData = new Array(labels.length).fill(0);

  // Fill the data array with the corresponding values
  chartData.forEach((item) => {
    var index = labels.indexOf(item.SchoolYear);
    if (index !== -1) {
      totalPublicationsData[index] = item.totalPublications;
    }
  });

  // Logging the processed data to debug
  console.log("Labels:", labels);
  console.log("Total Publications Data:", totalPublicationsData);

  var ctx = document.getElementById("numberOfPublicationsChart").getContext("2d");
  new Chart(ctx, {
    type: "line",
    data: {
      labels: labels,
      datasets: [
        {
          label: "TOTAL PUBLICATIONS",
          data: totalPublicationsData,
          backgroundColor: "#8E1537",
          borderColor: "#8E1537",
          borderWidth: 1,
          fill: false,
        }
      ],
    },
    options: {
      responsive: true,
      scales: {
        x: {
          title: {
            display: true,
            text: 'School Year',
          },
        },
        y: {
          title: {
            display: true,
            text: 'Total Publications',
          },
          beginAtZero: true,
        },
      },
    },
  });
}

function renderresearchInvolvement(chartData) {
  // Logging the chartData to debug
  console.log("Chart Data:", chartData);

  // Extract unique labels (SchoolYear - Semester) from the chartData
  var labels = [...new Set(chartData.map((item) => item.SchoolYear + " - " + item.semester))];

  // Initialize an array to hold the data points for total faculty participation
  var totalFacultyParticipationData = new Array(labels.length).fill(0);

  // Fill the data array with the corresponding values
  chartData.forEach((item) => {
    var label = item.SchoolYear + " - " + item.semester;
    var index = labels.indexOf(label);
    if (index !== -1) {
      totalFacultyParticipationData[index] = item.totalFacultyParticipation;
    }
  });

  // Logging the processed data to debug
  console.log("Labels:", labels);
  console.log("Total Faculty Participation Data:", totalFacultyParticipationData);

  var ctx = document.getElementById("researchInvolvementChart").getContext("2d");
  new Chart(ctx, {
    type: "line",
    data: {
      labels: labels,
      datasets: [
        {
          label: "TOTAL FACULTY PARTICIPATION",
          data: totalFacultyParticipationData,
          backgroundColor: "#8E1537",
          borderColor: "#8E1537",
          borderWidth: 1,
          fill: false,
        }
      ],
    },
    options: {
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
            text: 'Total Faculty Participation',
          },
          beginAtZero: true,
        },
      },
    },
  });
}
