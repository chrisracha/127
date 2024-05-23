var ctx = document.getElementById("enrolleesCourseChart");
var myChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ['BSCS', 'BSDS', 'BSAM'],
    datasets: [{
      label: '# of Tomatoes',
      data: [12, 19, 3],
      backgroundColor: [
        '#8E1537',
        '#FFB81D',
        '#005740'
      ],
      borderWidth: 5
    }]
  },
  options: {
    responsive: true,

  }
});

var ctx = document.getElementById('enrolleesYearChart').getContext("2d");
var myChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ["2022", "2023", "2024", "2025"],
    datasets: [{
      label: 'NUMBER OF ENROLLEES',
      data: [12, 19, 3, 5],
      backgroundColor: [
        '#8E1537',
      ],
      borderColor: [
        '#8E1537'
      ],
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
  }
});

chart2 = new Chart(document.getElementById('studentsPerYear').getContext('2d'), {
    type: 'bar',
    data: {
        labels: ["1", "2", "3", "4"],
        datasets: [
            {
                label: "BSDS",
                backgroundColor: "#8E1537",
                data: [3,7,4,5]
            },
            {
                label: "BSAM",
                backgroundColor: "#FFB81D",
                data: [4,3,5,7]
            },
            {
                label: "BSCS",
                backgroundColor: "#005740",
                data: [7,2,6,8]
            }
        ]
    },
    options: { 
        barValueSpacing: 20,
        responsive: true
    }
});

var ctx = document.getElementById('scholarsChart').getContext("2d");
var myChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ["22-23 1st", "22-23 2nd", "23-24 1st", "23-24 2nd"],
    datasets: [{
      label: 'NUMBER OF COLLEGE SCHOLARS',
      data: [12, 19, 3, 5],
      backgroundColor: [
        '#8E1537',
      ],
      borderColor: [
        '#8E1537'
      ],
      borderWidth: 1
    },{
      label: 'NUMBER OF UNIVERSITY SCHOLARS',
      data: [10, 5, 4, 10],
      backgroundColor: [
        '#FFB81D',
      ],
      borderColor: [
        '#FFB81D'
      ],
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
  }
});

var ctx = document.getElementById("USperDegProg");
var myChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ['BSCS', 'BSDS', 'BSAM'],
    datasets: [{
      label: '# of Tomatoes',
      data: [16, 15, 12],
      backgroundColor: [
        '#8E1537',
        '#FFB81D',
        '#005740'
      ],
      borderWidth: 5
    }]
  },
  options: {
    //cutoutPercentage: 40,
    responsive: true,
  }});


  var ctx = document.getElementById("CSperDegProg");
  var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['BSCS', 'BSDS', 'BSAM'],
      datasets: [{
        label: '# of Tomatoes',
        data: [14, 12, 3],
        backgroundColor: [
          '#8E1537',
          '#FFB81D',
          '#005740'
        ],
        borderWidth: 5
      }]
    },
    options: {
      //cutoutPercentage: 40,
      responsive: true,
    }});

    var ctx = document.getElementById('PopulationLaudes').getContext("2d");
    var myChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ["2023", "2024", "2025", "2026"],
        datasets: [{
          label: 'NUMBER OF CUM LAUDE',
          data: [12, 19, 3, 5],
          backgroundColor: [
            '#8E1537',
          ],
          borderColor: [
            '#8E1537'
          ],
          borderWidth: 1
        },{
          label: 'NUMBER OF MAGNA CUM LAUDE',
          data: [10, 5, 4, 10],
          backgroundColor: [
            '#FFB81D',
          ],
          borderColor: [
            '#FFB81D'
          ],
          borderWidth: 1
        },{
          label: 'NUMBER OF MAGNA SUMMA CUM LAUDE',
          data: [3, 3, 1, 8],
          backgroundColor: [
            '#005740',
          ],
          borderColor: [
            '#005740'
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
      }
    });

    chart2 = new Chart(document.getElementById('enrollmentData').getContext('2d'), {
      type: 'bar',
      data: {
          labels: ["1st Semester", "2nd Semester"],
          datasets: [
              {
                  label: "BSDS",
                  backgroundColor: "#8E1537",
                  data: [3,7]
              },
              {
                  label: "BSAM",
                  backgroundColor: "#FFB81D",
                  data: [4,3]
              },
              {
                  label: "BSCS",
                  backgroundColor: "#005740",
                  data: [7,2]
              }
          ]
      },
      options: { 
          barValueSpacing: 20,
          responsive: true
      }
  });