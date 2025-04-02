
<h2>Store</h2>
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
</div>

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


    $(document).ready(function() {
        const graphData = @json($GraphData);
        console.log(graphData);
    var Retail_LeaseOut = parseInt(graphData[0].retail_leaseout);
    var Retail_Totall = parseInt(graphData[0].retail);
    var Retail_Available = Retail_Totall - Retail_LeaseOut;

    var MJQE_PLAZA_LeaseOut = parseInt(graphData[0].mjq_leaseout);
    var MJQE_PLAZA_Totall = parseInt(graphData[0].mjq);
    var MJQE_PLAZA_Available = MJQE_PLAZA_Totall - MJQE_PLAZA_LeaseOut;

    var Land_LeaseOut = parseInt(graphData[0].land_leaseout);
    var Land_Totall = parseInt(graphData[0].land);
    var Land_Available = Land_Totall - Land_LeaseOut;

    var Building_LeaseOut = parseInt(graphData[0].building_leaseout);
    var Building_Totall = parseInt(graphData[0].building);
    var Building_Available = Building_Totall - Building_LeaseOut;


        const FBGraph = @json($FBGraph);

        var smls = parseInt(FBGraph[0].Retail_LeaseOut_SM);
        var sm_Totall = parseInt(FBGraph[0].SmartMart);
        var sma = sm_Totall - smls;

        var rcls = parseInt(FBGraph[0].Retail_LeaseOut_RC);
        var rc_PLAZA_Totall = parseInt(FBGraph[0].RC);
        var rca = rc_PLAZA_Totall - rcls;

        var afcls = parseInt(FBGraph[0].Retail_LeaseOut_AFC);
        var af_Totall = parseInt(FBGraph[0].AFC);
        var afca = af_Totall - afcls;

        var ssls = parseInt(FBGraph[0].Retail_LeaseOut_SS);
        var ss_Totall = parseInt(FBGraph[0].SS);
        var ssca = ss_Totall - ssls;

        var osls = parseInt(FBGraph[0].Retail_LeaseOut_OSR);
        var os_Totall = parseInt(FBGraph[0].OSR);
        var osa = os_Totall - osls;


    const ctx = document.getElementById('barChart').getContext('2d');
    const FBctx = document.getElementById('F&barChart').getContext('2d');

    // URL paths corresponding to each label
    const urls = {
    'Smart Mart': '/SM',
    'Rooster Café': '/RC',
    'Alex Food Court': '/AFC',
    'Food Stand': '/SS',
    'Other Space': '/OSR'
};

new Chart(FBctx, {
    type: 'bar',
    data: {
        labels: ['Smart Mart', 'Rooster Café', 'Alex Food Court', 'Food Stand', 'Other Space'],
        datasets: [
            {
                label: 'Total',
                data: [sm_Totall, rc_PLAZA_Totall, af_Totall, ss_Totall, os_Totall],
                backgroundColor: '#4472c4'
            },
            {
                label: 'Lease Out',
                data: [smls, rcls, afcls, ssls, osls],
                backgroundColor: '#00b050'
            },
            {
                label: 'Available',
                data: [sma, rca, afca, ssca, osa],
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
                const element = elements[0];

                const index = element.index;

                const label = this.data.labels[index];

                console.log('Clicked label:', label);

                if (label && urls[label]) {
                    console.log('Redirecting to:', urls[label]); 
                    window.location.href = urls[label];
                } else {
                    console.log('No URL found for:', label);
                    alert('No URL found for: ' + label);
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
                data: [Retail_Totall, MJQE_PLAZA_Totall, Land_Totall, Building_Totall],
                backgroundColor: '#4472c4'
            },
            {
                label: 'Lease Out',
                data: [Retail_LeaseOut, MJQE_PLAZA_LeaseOut, Land_LeaseOut, Building_LeaseOut],
                backgroundColor: '#00b050'
            },
            {
                label: 'Available',
                data: [Retail_Available, MJQE_PLAZA_Available, Land_Available, Building_Available],
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

