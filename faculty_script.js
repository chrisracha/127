var ctx = document.getElementById("ratioByRank");
var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Instructor', 'Assistant Professor', 'Associate Professor', 'Professor', 'Lecturer'],
        datasets: [{
            label: '# of Tomatoes',
            data: [12, 19, 3, 6, 7],
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

var ctx = document.getElementById('facultyNoYearlybyRank').getContext("2d");
var myChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ["22-23 1st Semester", "22-23 2nd Semester", "23-24 1st Semester", "23-24 2nd Semester"],
    datasets: [{
      label: 'Instructor',
      data: [12, 19, 3, 5],
      backgroundColor: [
        '#8E1537',
      ],
      borderColor: [
        '#8E1537'
      ],
      borderWidth: 1
    }, {
        label: 'Assistant Professor',
        data: [25, 32, 11, 12],
        backgroundColor: [
            '#FFB81D',
        ],
        borderColor: [
            '#FFB81D'
        ],
        borderWidth: 1
        },
        {
            label: 'Associate Professor',
            data: [12, 14, 15, 16],
            backgroundColor: [
                '#005740',
            ],
            borderColor: [
                '#005740'
            ],
            borderWidth: 1
        },
        {
            label: 'Professor',
            data: [17, 18, 19, 20],
            backgroundColor: [
                '#8E1537',
            ],
            borderColor: [
                '#8E1537'
            ],
            borderWidth: 1
        },
        {
            label: 'Lecturer',
            data: [13, 13, 14, 16],
            backgroundColor: [
                '#' + Math.floor(Math.random()*16777215).toString(16),
            ],
            borderColor: [
                '#' + Math.floor(Math.random()*16777215).toString(16)
            ],
            borderWidth: 1
        }
    ]    
  },
  options: {
    responsive: true,
  }
});

var ctx = document.getElementById("ratioByEduc");
var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['PhD', 'M. Sc.', 'M. M', 'MSCS'],
        datasets: [{
            label: '# of Tomatoes',
            data: [12, 19, 3, 6],
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

var ctx = document.getElementById('facultyNoYearlybyEduc').getContext("2d");
var myChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ["22-23 1st Semester", "22-23 2nd Semester", "23-24 1st Semester", "23-24 2nd Semester"],
    datasets: [{
      label: 'PhD',
      data: [12, 19, 3, 5],
      backgroundColor: [
        '#8E1537',
      ],
      borderColor: [
        '#8E1537'
      ],
      borderWidth: 1
    }, {
        label: 'M. Sc.',
        data: [25, 32, 11, 12],
        backgroundColor: [
            '#FFB81D',
        ],
        borderColor: [
            '#FFB81D'
        ],
        borderWidth: 1
        },
        {
            label: 'M. M.',
            data: [12, 14, 15, 16],
            backgroundColor: [
                '#005740',
            ],
            borderColor: [
                '#005740'
            ],
            borderWidth: 1
        },
        {
            label: 'MSCS',
            data: [17, 18, 19, 20],
            backgroundColor: [
                '#' + Math.floor(Math.random()*16777215).toString(16),
            ],
            borderColor: [
                '#' + Math.floor(Math.random()*16777215).toString(16)
            ],
            borderWidth: 1
        }
    ]    
  },
  options: {
    responsive: true,
  }
});

var ctx = document.getElementById('numberOfNewFaculty').getContext("2d");
var myChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ["22-23 1st Semester", "22-23 2nd Semester", "23-24 1st Semester", "23-24 2nd Semester"],
    datasets: [{
      label: 'Publications',
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

var ctx = document.getElementById('numberOfPublications').getContext("2d");
var myChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ["22-23 First Semester", "22-23 Second Semester", "23-24 First Semester"],
    datasets: [{
      label: 'New Faculty',
      data: [9, 7, 6],
      backgroundColor: [
        '#005740',
      ],
      borderColor: [
        '#005740'
      ],
      borderWidth: 1
    }
    ]    
  },
  options: {
    responsive: true,
  }
});

var ctx = document.getElementById('researchInvolvement').getContext("2d");
// bar chart data
// publication names
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Publication 1", "Publication 2", "Publication 3", "Publication 4"],
        datasets: [{
        label: 'Research Involvement',
        data: [12, 19, 3, 5],
        backgroundColor: [
            '#8E1537',
            '#FFB81D',
            '#005740',
            '#8E1537',
        ],
        borderColor: [
            '#8E1537',
            '#FFB81D',
            '#005740',
            '#8E1537',
        ],
        borderWidth: 1
        }
        ]    
    },
    options: {
        responsive: true,
    }
    });