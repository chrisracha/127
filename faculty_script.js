document.addEventListener("DOMContentLoaded", function () {
  fetchChartData("getchart_faculty.php", renderCharts);
});

function fetchChartData(url, callback) {
  fetch(url)
    .then((response) => response.json())
    .then((data) => callback(data))
    .catch((error) => console.error("Error fetching data:", error));
}

function renderCharts(data) {
  renderRatioByRank(data.ratioByRank);
  renderRatioByEduc(data.ratioByEduc);
  renderNumberOfTotalFaculty(data.numberOfTotalFaculty);
  renderNumberOfPublications(data.numberOfPublications);
  renderResearchInvolvement(data.researchInvolvement); 
}

function renderRatioByRank(chartData){
  var labels = chartData.map((item) => item.facultyRank);
  var counts = chartData.map((item) => item.rankCount);
  var customColors = ['#8E1537', '#FFB81D', '#005740', '#8E1537', '#C70039']; // Example custom colors

  var ctx = document.getElementById("ratioByRank");
  var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: labels,
        datasets: [{
            label: 'Ratio by Rank',
            data: counts,
            backgroundColor: customColors,
            borderWidth: 5
        }]
    },
    options: {
        responsive: true,
    }
  });
}

function renderRatioByEduc(chartData) {
  var labels = chartData.map((item) => item.educationalAttainment);
  var counts = chartData.map((item) => item.facultyCount);
  
  // Define your custom color palette
  var customColors = ['#8E1537', '#FFB81D', '#005740', '#808080'];

  var ctx = document.getElementById("ratioByEduc");
  var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: labels,
        datasets: [{
            label: 'Educational Attainment',
            data: counts,
            backgroundColor: customColors,
            borderWidth: 5
        }]
    },
    options: {
        responsive: true
    }
  });
}


function renderNumberOfTotalFaculty(chartData) {
  var labels = chartData.map((item) => item.SchoolYear + " " + item.semester);
  var totalFaculty = chartData.map((item) => item.totalFaculty);
  var customColors = ['#8E1537', '#FFB81D', '#005740', '#808080'];

  var ctx = document.getElementById('numberOfTotalFaculty').getContext("2d");
  var myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [{
        label: 'Total Faculty',
        data: totalFaculty,
        backgroundColor: customColors,
        borderColor: customColors,
        borderWidth: 1
      }]
    },
    options: {
      responsive: true
    }
  });
}

function renderNumberOfPublications(chartData) {
  var years = chartData.map((item) => item.SchoolYear);
  var counts = chartData.map((item) => item.totalPublications);
  var customColors = ['#8E1537', '#FFB81D', '#005740', '#808080'];

  var ctx = document.getElementById('numberOfPublications').getContext("2d");
  var myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: years,
      datasets: [{
        label: 'Publications',
        data: counts,
        backgroundColor: customColors,
        borderColor: customColors,
        borderWidth: 1
      }]
    },
    options: {
      responsive: true
    }
  });
}

function renderResearchInvolvement(chartData) {
  var publicationTitles = chartData.map((item) => item.publicationTitle);
  var totalFacultyParticipation = chartData.map((item) => item.totalFacultyParticipation);
  var customColors = ['#8E1537', '#FFB81D', '#005740', '#808080', '000000'];

  var ctx = document.getElementById('researchInvolvement').getContext("2d");
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: publicationTitles,
        datasets: [{
            label: 'Research Involvement',
            data: totalFacultyParticipation,
            backgroundColor: customColors,
            borderColor: customColors,
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
    }
  });
}
