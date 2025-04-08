<style>
  /* Global Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.breadcrumb {
    margin: 1.5rem 0;
}

.subheader {
    background-color: #fff;
    padding: 1.5rem;
    border-radius: 8px;
    margin-bottom: 2rem;
}
.page-content{
  padding:0px 2rem; 
}

.subheader-title {
    font-size: 2rem;
    margin: 0;
}

.subheader-block {
    display: flex;
    align-items: center;
}

.subheader-block .d-inline-flex {
    margin-right: 20px;
}

.subheader-block .fw-300 {
    font-weight: 300;
}

.subheader-block .fw-500 {
    font-weight: 500;
}

/* Card Styles */
.card {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-10px);
}

.card .card-body {
    padding: 1.25rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.card .font-weight-bold {
    font-size: 1.25rem;
}

.card-link {
    text-decoration: none;
}

.progress-container {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 5%;
}

.progress-row {
    display: flex;
    justify-content: space-evenly;
    gap: 10px;
}

.progress-item {
    border-radius: 8px;
    padding: 3px;
    text-align: center;
    flex-basis: calc(20% - 10px);
    cursor: pointer;
    user-select: none;
    font-size: 12px;
}

.chart-container {
    position: relative;
    width: 50px;
    height: 50px;
    margin: 0 auto;
    border-radius: 50%;
    background-color: #f4f4f4;
}

.chart {
    position: absolute;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: conic-gradient(#00cab8 0% 0%, #ccc 0% 100%);
    transition: background 0.5s ease;
}

.percentage_Land_LeaseOut {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 12px;
    font-weight: bold;
    text-align: center;
    opacity: 0;
    animation: fadeIn 1s ease-in-out forwards;
}

@keyframes fadeIn {
    0% {
        opacity: 0;
    }
    100% {
        opacity: 1;
    }
}

.label {
    font-size: 12px;
    color: #555;
    margin-top: 10px;
}

.leaseout {
    font-size: 14px;
    font-weight: bold;
    color: #e73047;
    margin-top: 5px;
}

/* Chart Container */
.barChartPG, .FBGraph2 {
    padding: 1rem;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .progress-container {
        flex-direction: column;
    }

    .progress-item {
        flex-basis: 100%;
    }

    .card .font-weight-bold {
        font-size: 1rem;
    }

    .barChartPG, .FBGraph2 {
        margin-bottom: 1rem;
    }
}
.fad.fa-chart-line{
  font-size: 16px;
  margin-left: 5px;
}
</style>




<ol class="breadcrumb page-breadcrumb">

  <li class="position-absolute pos-top pos-right d-none d-sm-block">
    <span style="user-select: none;" id="current-date"></span>
  </li>



</ol>
<div class="subheader" style="user-select: none">
  <h1 class="subheader-title">
      <i class='subheader-icon fal fa-chart-area'></i> Analytics <span class='fw-300'>Dashboard</span>
  </h1>
  <div class="subheader-block d-lg-flex align-items-center">
      <div class="d-inline-flex flex-column justify-content-center mr-3">
          <span class="fw-300 fs-xs d-block opacity-50">
              <small>Last Month</small>
          </span>
          <span class="lm fw-500 fs-xl d-block color-primary-500">
              {{$lastmonthRevenue}} $
          </span>
      </div>
      <span class="js-sparklines-1 hidden-lg-down"></span>
  </div>
  <div class="subheader-block d-lg-flex align-items-center border-faded border-right-0 border-top-0 border-bottom-0 ml-3 pl-3">
      <div class="d-inline-flex flex-column justify-content-center mr-3">
          <span class="fw-300 fs-xs d-block opacity-50">
              <small>This month</small>
          </span>
          <span class="tm fw-500 fs-xl d-block color-danger-500">
            {{ $thismonthrevenue }} $
          </span>
      </div>
      <span class="js-sparklines-2 hidden-lg-down"></span>
  </div>
</div>

<div class="row">
  <div class="col-sm-6 col-xl-3" style="cursor: pointer;user-select: none;">
      <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g">
          <div class="">
              <h3 class="totalcustomer display-4 d-block l-h-n m-0 fw-500">
                  {{ $totalCustomer }}
                  <small class="m-0 l-h-n">Total Customers</small>
              </h3>
          </div>
          <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
      </div>
  </div>
  <div class="col-sm-6 col-xl-3" style="cursor: pointer;user-select: none;">
      <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g">
          <div class="">
              <h3 class="revenue display-4 d-block l-h-n m-0 fw-500">
                  {{ $revenue }} $
                  <small class="m-0 l-h-n">Revenue Figure</small>
              </h3>
          </div>
          <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
      </div>
  </div>
  <div class="col-sm-6 col-xl-3" style="cursor: pointer;user-select: none;">
      <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white mb-g">
          <div class="">
              <h3 class="totalprop display-4 d-block l-h-n m-0 fw-500">
                  {{ $totalProp }}
                  <small class="m-0 l-h-n">Total Property</small>
              </h3>
          </div>
          <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
      </div>
  </div>
  <div class="col-sm-6 col-xl-3" style="cursor: pointer;user-select: none;">
      <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white mb-g">
          <div class="">
              <h3 class="productavg display-4 d-block l-h-n m-0 fw-500">
                  {{ $avgRevenuetolastmonth }}
                  <small class="m-0 l-h-n">Product level increase</small>
              </h3>
          </div>
          <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
      </div>
  </div>
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


<div class="progress-container">

</div>

<div class="row">

  {{-- Market Dashboard --}}


  <div class="col-lg-12">
    <div id="panel-1" class="panel">
        <div class="panel-hdr">
          <h2>Marketing Performance</h2>
        </div>
        <div class="panel-container show">
            <div class="panel-content bg-subtlelight-fade">
                <div id="js-checkbox-toggles" class="d-flex mb-3">
                  
                </div>
                <div id="flot-toggles" class="w-100 mt-4" style="height: 300px"></div>
            </div>
        </div>
    </div>
</div>


  {{-- END Market Dashboard --}}


{{-- Profit Comparation  --}}
<div class="col-lg-12">
  <div id="col-6" class="panel">
      <div class="panel-hdr">
        <h2>Income Comparison</h2>
      </div>
      <div class="panel-container show">
          <div class="panel-content p-0 mb-g">
              <div class="alert alert-success alert-dismissible fade show border-faded border-left-0 border-right-0 border-top-0 rounded-0 m-0" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true"><i class="fal fa-times"></i></span>
                  </button>
                  <span id="curentdate2" class="js-get-date"></span>

              </div>
          </div>
          <div class="panel-content">
            <div class="row mb-g">
              <div class="col-md-6 d-flex align-items-center">
                <div class="w-100" style="height:250px">
                  <canvas id="incomeBarChart" class="w-100" style="height: 250px;"></canvas>
                </div>
              </div>
              <div class="col-md-6 col-lg-5 mr-lg-auto">
                @foreach($LastmonthEstimatedIncome as $item)
                  <!-- Actual Income -->
                  <div class="d-flex justify-content-between mt-2 mb-1 fs-xs text-primary">
                    <span>{{ $item->store_name }} Income</span>
                    <span>${{ number_format($item->final_charge, 2) }}</span> <!-- Display actual income -->
                  </div>
                  <div class="progress progress-xs mb-3">
                    <div class="progress-bar" role="progressbar" 
                         style="width: {{ ($item->final_charge / 5000) * 100 }}%;" 
                         aria-valuenow="{{ $item->final_charge }}" 
                         aria-valuemin="0" 
                         aria-valuemax="5000">
                    </div>
                  </div>
          
                  <!-- Estimated Income -->
                  <div class="d-flex justify-content-between mt-2 mb-1 fs-xs text-info">
                    <span>{{ $item->store_name }} Estimated Income</span>
                    <span>${{ number_format($item->estimated_income, 2) }}</span> <!-- Display estimated income -->
                  </div>
                  <div class="progress progress-xs mb-3">
                    <div class="progress-bar bg-info-500" role="progressbar" 
                         style="width: {{ ($item->estimated_income / 5000) * 100 }}%;" 
                         aria-valuenow="{{ $item->estimated_income }}" 
                         aria-valuemin="0" 
                         aria-valuemax="5000">
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
      </div>
  </div>
</div>
{{-- End Profit Comparation --}}
  
</div>


<div class="row d-flex">
  <!-- Properties Graph Panel -->
  <div class="col-lg-6 d-flex">
    <div class="panel flex-fill">
      <div class="panel-hdr">
        <h2>Properties Graph</h2>
      </div>
      <div class="panel-container flex-fill">
        <div class="barChartPG">
          <canvas id="barChart" width="350" height="200"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- RETAIL F&B Graph Panel -->
  <div class="col-lg-6 d-flex">
    <div class="panel flex-fill">
      <div class="panel-hdr">
        <h2>RETAIL F&B Graph</h2>
      </div>
      <div class="panel-container flex-fill">
        <div class="FBGraph2">
          <canvas id="F&barChart" width="350" height="200"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>
  

@include('users_profile/signatorImgCrop')

<script src="{{ asset('plugin/js/xlsx.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  $(document).ready(function() {
    const lastMonthEstimatedIncome = @json($LastmonthEstimatedIncome);

    // Extract data for the bar chart
    const storeNames = lastMonthEstimatedIncome.map(item => item.store_name);
    const actualIncome = lastMonthEstimatedIncome.map(item => parseFloat(item.final_charge));
    const estimatedIncome = lastMonthEstimatedIncome.map(item => parseFloat(item.estimated_income));

    // Create the bar chart
    const ctx = document.getElementById('incomeBarChart').getContext('2d');
    const incomeBarChart = new Chart(ctx, {
      type: 'bar', // Use 'bar' for a bar chart
      data: {
        labels: storeNames, // Store names on the x-axis
        datasets: [
          {
            label: 'Actual Income',
            data: actualIncome,
            backgroundColor: 'rgba(75, 192, 192, 0.6)', // Light teal color
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1,
          },
          {
            label: 'Estimated Income',
            data: estimatedIncome,
            backgroundColor: 'rgba(255, 99, 132, 0.6)', // Light red color
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1,
          },
        ],
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: true,
            position: 'top',
          },
          tooltip: {
            enabled: true,
            callbacks: {
              label: function (tooltipItem) {
                return `$${tooltipItem.raw.toFixed(2)}`;
              },
            },
          },
        },
        scales: {
          x: {
            beginAtZero: true,
            grid: {
              display: false,
            },
          },
          y: {
            beginAtZero: true,
            ticks: {
              callback: function (value) {
                return `$${value}`; // Format y-axis values as currency
              },
            },
          },
        },
      },
    });
  });
</script>

<script>
  // Add checkboxes dynamically
  $(document).ready(function () {
const profitprop = @json($profitprop);

// Group data by store name
const groupedData = {};
profitprop.forEach((item) => {
    const store = item.store_name;
    const timestamp = new Date(item.payment_date).getTime();
    const charge = parseFloat(item.final_charge);

    if (!groupedData[store]) {
        groupedData[store] = [];
    }

    groupedData[store].push([timestamp, charge]);
});

// Convert to array format and assign colors
const colors = [
    "#007bff", "#ffc107", "#28a745", "#dc3545", "#6610f2", "#fd7e14",
    "#20c997", "#17a2b8", "#6f42c1", "#e83e8c" // Add more if needed
];

const storeSeries = Object.keys(groupedData).map((store, index) => {
    return {
        label: store,
        data: groupedData[store],
        color: colors[index % colors.length],
        lines: { show: true, lineWidth: 2 },
        points: { show: true },
        shadowSize: 0
    };
});


    const checkboxContainer = $("#js-checkbox-toggles");
    storeSeries.forEach((series, index) => {
        const checkboxHTML = `
            <div class="custom-control custom-switch mr-2">
                <input type="checkbox" class="custom-control-input" name="gra-${index}" id="gra-${index}" checked>
                <label class="custom-control-label" for="gra-${index}">${series.label}</label>
            </div>`;
        checkboxContainer.append(checkboxHTML);
    });

    const options = {
        grid: {
            hoverable: true,
            clickable: true,
            tickColor: 'rgba(0,0,0,0.05)',
            borderWidth: 1,
            borderColor: 'rgba(0,0,0,0.05)'
        },
        tooltip: true,
        tooltipOpts: {
            cssClass: 'tooltip-inner',
            defaultTheme: false
        },
        xaxis: {
            mode: "time",
            tickColor: 'rgba(0,0,0,0.05)'
        },
        yaxes: {
            tickColor: 'rgba(0,0,0,0.05)',
            tickFormatter: function (val) {
                return "$" + val;
            }
        }
    };

    let plot = null;

    function plotNow() {
        const selectedData = [];
        checkboxContainer.find(':checkbox').each(function () {
            const idx = parseInt($(this).attr("name").split("-")[1]);
            if ($(this).is(':checked')) {
                selectedData.push(storeSeries[idx]);
            }
        });

        if (selectedData.length > 0) {
            if (plot) {
                plot.setData(selectedData);
                plot.draw();
            } else {
                plot = $.plot($("#flot-toggles"), selectedData, options);
            }
        } else {
            if (plot) {
                plot.setData([]);
                plot.draw();
            }
        }
    }

    checkboxContainer.on('change', ':checkbox', function () {
        plotNow();
    });

    plotNow();
});
</script>
  
<script>

$(document).ready(function () {

  const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const formattedDate = new Intl.DateTimeFormat('en-US', options).format(new Date());
    document.getElementById('current-date').textContent = formattedDate;
    document.getElementById('curentdate2').textContent = formattedDate;
  document.addEventListener("DOMContentLoaded", function () {
    const dateElement = document.querySelector(".js-get-date");
    if (dateElement) {
      const currentDate = new Date().toLocaleDateString("en-US", {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric"
      });
      dateElement.textContent = currentDate;
    }
  });



  



  $(document).ready(function () {
const graphData = @json($GraphData);
const FBGraph = @json($FBGraph);

function createProgressBar(label, total, leased) {
  const percentage = 100-(((total - leased) / total) * 100).toFixed(0); 

  const chartContainer = $('<div>').addClass('chart-container');
  const chartDiv = $('<div>')
    .addClass('chart')
    .attr('data-percent', percentage)
    .append($('<span>').addClass('percentage_Land_LeaseOut').text('0%')); 

  chartContainer.append(chartDiv);

  // Make the chart animate smoothly
  chartDiv.easyPieChart({
    size: 50,
    lineWidth: 10,  
    barColor: '#00cab8', 
    trackColor: '#ccc', 
    scaleColor: false,
    lineCap: 'round',
    animate: 1500,  
    onStep: function (from, to, percent) {
      $(this.el).find('.percentage_Land_LeaseOut').text(Math.round(percent) + '%');
    }
  });

 // Calculate availability
const available = total - leased;
const leasedPercentage = (leased / total) * 100; 

let iconClass = 'fas fa-chart-line-down'; 
let colorClass = 'red';  
let additionalIcon = ''; 

if (leasedPercentage >= 80) {
  iconClass = 'fas fa-chart-line-up'; // Rising arrow
  colorClass = 'green'; 
  additionalIcon = '<i class="fas fa-chart-line"></i>'; 
}

// Create the label div
const labelDiv = $('<div>')
  .addClass('label')
  .html(`<span>${label}</span>`);

const leaseoutDiv = $('<div>')
  .addClass('leaseout')
  .html(`${available} Availables <i class="${iconClass}"></i> ${additionalIcon}`);

leaseoutDiv.css('color', colorClass); 
$('body').append(labelDiv, leaseoutDiv);





  const progressItem = $('<div>').addClass('progress-item');

  // Use Bootstrap grid system
  const row = $('<div>').addClass('row');
  const col = $('<div>').addClass('col');

  col.append(labelDiv, leaseoutDiv);
  row.append(chartContainer, col);
  progressItem.append(row);

  return progressItem;
}



function createProgressRows(data, labels) {
  const container = $('.barChartPG');
  const container2 = $('.FBGraph2');


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
      if (index % 5 === 0) {
      currentRow = $('<div>').addClass('pg progress-row');
      container.append(currentRow);
    }

    currentRow.append(createProgressBar(label, total, leased));
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
      if (index % 5 === 0) {
      currentRow = $('<div>').addClass('F&B progress-row');
        container2.append(currentRow);
    }

    currentRow.append(createProgressBar(label, total, leased));
    }

    
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
        backgroundColor: '#afd6f8'
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
        backgroundColor: '#c0f9f5'
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
        backgroundColor: '#d4cadd'
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
        backgroundColor: '#afd6f8'
      },
      {
        label: 'Lease Out',
        data: [
          parseInt(graphData[0].retail_leaseout),
          parseInt(graphData[0].mjq_leaseout),
          parseInt(graphData[0].land_leaseout),
          parseInt(graphData[0].building_leaseout)
        ],
        backgroundColor: '#c0f9f5'
      },
      {
        label: 'Available',
        data: [
          parseInt(graphData[0].retail) - parseInt(graphData[0].retail_leaseout),
          parseInt(graphData[0].mjq) - parseInt(graphData[0].mjq_leaseout),
          parseInt(graphData[0].land) - parseInt(graphData[0].land_leaseout),
          parseInt(graphData[0].building) - parseInt(graphData[0].building_leaseout)
        ],
        backgroundColor: '#d4cadd'
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
          backgroundColor: '#afd6f8'
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
          backgroundColor: '#c0f9f5'
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
          backgroundColor: '#d4cadd'
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
          backgroundColor: '#afd6f8'
        },
        {
          label: 'Lease Out',
          data: [
            parseInt(graphData[0].retail_leaseout),
            parseInt(graphData[0].mjq_leaseout),
            parseInt(graphData[0].land_leaseout),
            parseInt(graphData[0].building_leaseout)
          ],
          backgroundColor: '#c0f9f5'
        },
        {
          label: 'Available',
          data: [
            parseInt(graphData[0].retail) - parseInt(graphData[0].retail_leaseout),
            parseInt(graphData[0].mjq) - parseInt(graphData[0].mjq_leaseout),
            parseInt(graphData[0].land) - parseInt(graphData[0].land_leaseout),
            parseInt(graphData[0].building) - parseInt(graphData[0].building_leaseout)
          ],
          backgroundColor: '#d4cadd'
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

