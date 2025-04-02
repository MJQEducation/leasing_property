<style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
    }
    
    .progress-container {
      display: flex;
      flex-direction: column;
      gap: 20px; /* Gap between rows */
    }
    
    .progress-row {
      display: flex;
      justify-content: space-between; /* Distribute items evenly */
      gap: 20px; /* Gap between progress bars in a row */
      width: 100%; /* Ensure full-width rows */
    }
    
    .progress-item {
      border: 1px solid #eaeaea;
      border-radius: 10px; /* Rounded corners */
      padding: 20px; /* Padding inside the border */
      text-align: center;
      flex-basis: calc(25% - 20px); 
    }
    
    .chart-container {
      position: relative;
      width: 100px;
      height: 100px;
      margin: 0 auto; /* Center the chart horizontally */
    }
    
    .percentage_Land_LeaseOut {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      font-size: 16px;
      font-weight: bold;
      color: #333; 
    }
    
    .label {
      font-size: 14px;
      color: #555;
      margin-top: 10px; 
    }
    
    .leaseout {
      font-size: 18px;
      font-weight: bold;
      color: #333; /* Dark text for leaseout details */
      margin-top: 5px; /* Space between label and leaseout */
    }
    </style>


<div class="progress-container">

</div>
{{-- <h2>Store</h2>
<div class="row">
    @foreach($data as $item)
    <div class="col-lg-4 mb-4">
        <a href="{{ route('abbreviation.index', ['abbreviation' => $item->abbreviation]) }}" class="card-link">
            <div class="card bg-primary text-light shadow-sm rounded p-4">
                <div class="card-body d-flex flex-column justify-content-between">
                    <p class="font-weight-bold text-light mb-1" style="font-size: 1.25rem;">
                        {{ $item->name_en }}
                    </p>
                    <h4 class="font-weight-bold text-dark-75 mb-1">
                        <span contenteditable="false" class="badge badge-light">{{ $item->abbreviation_count }}</span>
                    </h4>
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>


<h2>Sub Store</h2>
<div class="row">
    @foreach($dataSubStore as $item)
    <div class="col-lg-4 mb-4">
        <a href="{{ route('abbreviation.index', ['abbreviation' => $item->abbreviation]) }}" class="card-link">
            <div style="background-color:#c0c0c0 !important" class="card bg-primary text-light shadow-sm rounded p-4">
                <div class="card-body d-flex flex-column justify-content-between">
                    <p class="font-weight-bold text-light mb-1" style="font-size: 1.25rem;">
                        {{ $item->name_en }}
                    </p>
                    <h4 class="font-weight-bold text-dark-75 mb-1">
                        <span contenteditable="false" class="badge badge-light">{{ $item->abbreviation_count }}</span>
                    </h4>
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div> --}}

<div class="row">
    <div class="col-xl-6">
        <h2>Properties Graph</h2>
        <canvas id="barChart" width="350" height="200"></canvas>
    </div>

    <div class="col-xl-6">

        <h2> RETAIL F&B Graph</h2>
        <canvas id="F&barChart" width="350" height="200"></canvas>
    </div>
    
</div>


<div id='fileViewDiv'>

</div>

@include('users_profile/signatorImgCrop')

<script src="{{ asset('plugin/js/xlsx.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

$(document).ready(function () {
    const graphData = @json($GraphData);
    const FBGraph = @json($FBGraph);


    $(document).ready(function () {
  const graphData = @json($GraphData);
  const FBGraph = @json($FBGraph);

  function createProgressBar(label, total, leased) {
    const percentage = ((leased / total) * 100).toFixed(0); 

    const chartContainer = $('<div>').addClass('chart-container');
    const chartDiv = $('<div>')
      .addClass('chart')
      .attr('data-percent', percentage) 
      .append($('<span>').addClass('percentage_Land_LeaseOut').text('0%')); 

    chartContainer.append(chartDiv);

    chartDiv.easyPieChart({
      size: 100,
      lineWidth: 10,
      barColor: '#00c853',
      trackColor: '#ccc',
      scaleColor: false,
      lineCap: 'round',
      animate: 2000,
      onStep: function (from, to, percent) {
        $(this.el).find('.percentage_Land_LeaseOut').text(Math.round(percent) + '%');
      }
    });

    const labelDiv = $('<div>')
      .addClass('label')
      .html(`Total of <span>${label}</span>`); 
    const leaseoutDiv = $('<div>')
      .addClass('leaseout')
      .text(`${total} Leased Out of ${leased}`);

    const progressItem = $('<div>').addClass('progress-item');

    // Use Bootstrap grid system
    const row = $('<div>').addClass('row');
    const col = $('<div>').addClass('col');

    col.append(labelDiv, leaseoutDiv);
    row.append(chartContainer,col);
    progressItem.append(row);

    return progressItem;
  }

  function createProgressRows(data, labels) {
    const container = $('.progress-container');

    let currentRow;

    $.each(labels, function (index, label) {
      let total, leased;

      if (data === 'graphData') {
        switch (label) {
          case 'Retail F&B':
            total = parseInt(graphData[0].retail);
            leased = parseInt(graphData[0].retail_leaseout);
            break;
          case 'MJQE Plaza':
            total = parseInt(graphData[0].mjq);
            leased = parseInt(graphData[0].mjq_leaseout);
            break;
          case 'Land':
            total = parseInt(graphData[0].land);
            leased = parseInt(graphData[0].land_leaseout);
            break;
          case 'Building':
            total = parseInt(graphData[0].building);
            leased = parseInt(graphData[0].building_leaseout);
            break;
        }
      } else if (data === 'FBGraph') {
        switch (label) {
          case 'Smart Mart':
            total = parseInt(FBGraph[0].SmartMart);
            leased = parseInt(FBGraph[0].Retail_LeaseOut_SM);
            break;
          case 'Rooster Café':
            total = parseInt(FBGraph[0].RC);
            leased = parseInt(FBGraph[0].Retail_LeaseOut_RC);
            break;
          case 'Alex Food Court':
            total = parseInt(FBGraph[0].AFC);
            leased = parseInt(FBGraph[0].Retail_LeaseOut_AFC);
            break;
          case 'Food Stand':
            total = parseInt(FBGraph[0].SS);
            leased = parseInt(FBGraph[0].Retail_LeaseOut_SS);
            break;
          case 'Other Space':
            total = parseInt(FBGraph[0].OSR);
            leased = parseInt(FBGraph[0].Retail_LeaseOut_OSR);
            break;
        }
      }

      if (index % 4 === 0) {
        currentRow = $('<div>').addClass('progress-row');
        container.append(currentRow);
      }

      currentRow.append(createProgressBar(label, total, leased));
    });
  }

  const propertyLabels = ['Retail F&B', 'MJQE Plaza', 'Land', 'Building'];
  createProgressRows('graphData', propertyLabels);

  const fbLabels = ['Smart Mart', 'Rooster Café', 'Alex Food Court', 'Food Stand', 'Other Space'];
  createProgressRows('FBGraph', fbLabels);

  const ctx = document.getElementById('barChart').getContext('2d');
  const FBctx = document.getElementById('F&barChart').getContext('2d');

  const urls = {
    'Smart Mart': '/SM',
    'Rooster Café': '/RC',
    'Alex Food Court': '/AFC',
    'Food Stand': '/SS',
    'Other Space': '/OSR'
  };

  if (!graphData || !FBGraph) {
    console.error("Error: Missing or invalid data.");
    return;
  }

  new Chart(FBctx, {
    type: 'bar',
    data: {
      labels: ['Smart Mart', 'Rooster Café', 'Alex Food Court', 'Food Stand', 'Other Space'],
      datasets: [
        {
          label: 'Total',
          data: [
            parseInt(FBGraph[0].SmartMart),
            parseInt(FBGraph[0].RC),
            parseInt(FBGraph[0].AFC),
            parseInt(FBGraph[0].SS),
            parseInt(FBGraph[0].OSR)
          ],
          backgroundColor: '#4472c4'
        },
        {
          label: 'Lease Out',
          data: [
            parseInt(FBGraph[0].Retail_LeaseOut_SM),
            parseInt(FBGraph[0].Retail_LeaseOut_RC),
            parseInt(FBGraph[0].Retail_LeaseOut_AFC),
            parseInt(FBGraph[0].Retail_LeaseOut_SS),
            parseInt(FBGraph[0].Retail_LeaseOut_OSR)
          ],
          backgroundColor: '#00b050'
        },
        {
          label: 'Available',
          data: [
            parseInt(FBGraph[0].SmartMart) - parseInt(FBGraph[0].Retail_LeaseOut_SM),
            parseInt(FBGraph[0].RC) - parseInt(FBGraph[0].Retail_LeaseOut_RC),
            parseInt(FBGraph[0].AFC) - parseInt(FBGraph[0].Retail_LeaseOut_AFC),
            parseInt(FBGraph[0].SS) - parseInt(FBGraph[0].Retail_LeaseOut_SS),
            parseInt(FBGraph[0].OSR) - parseInt(FBGraph[0].Retail_LeaseOut_OSR)
          ],
          backgroundColor: '#ffc000'
        }
      ]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          display: true,
          position: 'top'
        }
      },
      scales: {
        y: {
          beginAtZero: true
        },
        x: {
          stacked: false
        }
      },
      onClick: function (event, elements) {
        if (elements.length > 0) {
          const index = elements[0].index;
          const label = this.data.labels[index];
          if (urls[label]) {
            window.location.href = urls[label];
          } else {
            console.warn(`No URL found for label: ${label}`);
          }
        }
      }
    }
  });

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Retail F&B', 'MJQE Plaza', 'Land', 'Building'],
      datasets: [
        {
          label: 'Total',
          data: [
            parseInt(graphData[0].retail),
            parseInt(graphData[0].mjq),
            parseInt(graphData[0].land),
            parseInt(graphData[0].building)
          ],
          backgroundColor: '#4472c4'
        },
        {
          label: 'Lease Out',
          data: [
            parseInt(graphData[0].retail_leaseout),
            parseInt(graphData[0].mjq_leaseout),
            parseInt(graphData[0].land_leaseout),
            parseInt(graphData[0].building_leaseout)
          ],
          backgroundColor: '#00b050'
        },
        {
          label: 'Available',
          data: [
            parseInt(graphData[0].retail) - parseInt(graphData[0].retail_leaseout),
            parseInt(graphData[0].mjq) - parseInt(graphData[0].mjq_leaseout),
            parseInt(graphData[0].land) - parseInt(graphData[0].land_leaseout),
            parseInt(graphData[0].building) - parseInt(graphData[0].building_leaseout)
          ],
          backgroundColor: '#ffc000'
        }
      ]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          display: true,
          position: 'top'
        }
      },
      scales: {
        y: {
          beginAtZero: true
        },
        x: {
          stacked: false
        }
      }
    }
  });
}); 
    
  
    new Chart(FBctx, {
      type: 'bar',
      data: {
        labels: ['Smart Mart', 'Rooster Café', 'Alex Food Court', 'Food Stand', 'Other Space'],
        datasets: [
          {
            label: 'Total',
            data: [
              parseInt(FBGraph[0].SmartMart),
              parseInt(FBGraph[0].RC),
              parseInt(FBGraph[0].AFC),
              parseInt(FBGraph[0].SS),
              parseInt(FBGraph[0].OSR)
            ],
            backgroundColor: '#4472c4'
          },
          {
            label: 'Lease Out',
            data: [
              parseInt(FBGraph[0].Retail_LeaseOut_SM),
              parseInt(FBGraph[0].Retail_LeaseOut_RC),
              parseInt(FBGraph[0].Retail_LeaseOut_AFC),
              parseInt(FBGraph[0].Retail_LeaseOut_SS),
              parseInt(FBGraph[0].Retail_LeaseOut_OSR)
            ],
            backgroundColor: '#00b050'
          },
          {
            label: 'Available',
            data: [
              parseInt(FBGraph[0].SmartMart) - parseInt(FBGraph[0].Retail_LeaseOut_SM),
              parseInt(FBGraph[0].RC) - parseInt(FBGraph[0].Retail_LeaseOut_RC),
              parseInt(FBGraph[0].AFC) - parseInt(FBGraph[0].Retail_LeaseOut_AFC),
              parseInt(FBGraph[0].SS) - parseInt(FBGraph[0].Retail_LeaseOut_SS),
              parseInt(FBGraph[0].OSR) - parseInt(FBGraph[0].Retail_LeaseOut_OSR)
            ],
            backgroundColor: '#ffc000'
          }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: true,
            position: 'top'
          }
        },
        scales: {
          y: {
            beginAtZero: true
          },
          x: {
            stacked: false
          }
        },
        onClick: function (event, elements) {
          if (elements.length > 0) {
            const index = elements[0].index;
            const label = this.data.labels[index];
            if (urls[label]) {
              window.location.href = urls[label];
            } else {
              console.warn(`No URL found for label: ${label}`);
            }
          }
        }
      }
    });
  
    // Chart.js for Properties Graph
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Retail F&B', 'MJQE Plaza', 'Land', 'Building'],
        datasets: [
          {
            label: 'Total',
            data: [
              parseInt(graphData[0].retail),
              parseInt(graphData[0].mjq),
              parseInt(graphData[0].land),
              parseInt(graphData[0].building)
            ],
            backgroundColor: '#4472c4'
          },
          {
            label: 'Lease Out',
            data: [
              parseInt(graphData[0].retail_leaseout),
              parseInt(graphData[0].mjq_leaseout),
              parseInt(graphData[0].land_leaseout),
              parseInt(graphData[0].building_leaseout)
            ],
            backgroundColor: '#00b050'
          },
          {
            label: 'Available',
            data: [
              parseInt(graphData[0].retail) - parseInt(graphData[0].retail_leaseout),
              parseInt(graphData[0].mjq) - parseInt(graphData[0].mjq_leaseout),
              parseInt(graphData[0].land) - parseInt(graphData[0].land_leaseout),
              parseInt(graphData[0].building) - parseInt(graphData[0].building_leaseout)
            ],
            backgroundColor: '#ffc000'
          }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: true,
            position: 'top'
          }
        },
        scales: {
          y: {
            beginAtZero: true
          },
          x: {
            stacked: false
          }
        }
      }
    });
  });
    
  </script>

