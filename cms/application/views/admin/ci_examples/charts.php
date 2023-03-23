<div class="container-fluid">
   <div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="card">
        <div class="header">
          <h2 style="display: inline-block;"> DYNAMIC CHARTS</h2>
        </div>
      </div>
    </div>
  </div>

  <div class="row clearfix">
      <!-- Line Chart -->
      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <div class="card">
              <div class="header">
                  <h2>LINE CHART (USER ACTIVITY DATA)</h2>
                  <ul class="header-dropdown m-r--5">
                      <li class="dropdown">
                          <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                              <i class="material-icons">more_vert</i>
                          </a>
                          <ul class="dropdown-menu pull-right">
                              <li><a href="javascript:void(0);">Action</a></li>
                              <li><a href="javascript:void(0);">Another action</a></li>
                              <li><a href="javascript:void(0);">Something else here</a></li>
                          </ul>
                      </li>
                  </ul>
              </div>
              <div class="body">
                  <div id="line_chart" class="graph"></div>
              </div>
          </div>
      </div>
      <!-- #END# Line Chart -->
      <!-- Bar Chart -->
      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <div class="card">
              <div class="header">
                  <h2>BAR CHART (USER ACTIVITY DATA)</h2>
                  <ul class="header-dropdown m-r--5">
                      <li class="dropdown">
                          <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                              <i class="material-icons">more_vert</i>
                          </a>
                          <ul class="dropdown-menu pull-right">
                              <li><a href="javascript:void(0);">Action</a></li>
                              <li><a href="javascript:void(0);">Another action</a></li>
                              <li><a href="javascript:void(0);">Something else here</a></li>
                          </ul>
                      </li>
                  </ul>
              </div>
              <div class="body">
                  <div id="bar_chart" class="graph"></div>
              </div>
          </div>
      </div>
      <!-- #END# Bar Chart -->
  </div>
  <div class="row clearfix">
      <!-- Area Chart -->
      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <div class="card">
              <div class="header">
                  <h2>AREA CHART (USER REGISTRATION DATA)</h2>
                  <ul class="header-dropdown m-r--5">
                      <li class="dropdown">
                          <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                              <i class="material-icons">more_vert</i>
                          </a>
                          <ul class="dropdown-menu pull-right">
                              <li><a href="javascript:void(0);">Action</a></li>
                              <li><a href="javascript:void(0);">Another action</a></li>
                              <li><a href="javascript:void(0);">Something else here</a></li>
                          </ul>
                      </li>
                  </ul>
              </div>
              <div class="body">
                  <div id="area_chart" class="graph"></div>
              </div>
          </div>
      </div>
      <!-- #END# Area Chart -->
      <!-- Donut Chart -->
      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <div class="card">
              <div class="header">
                  <h2>DONUT CHART (USER GROUPS DATA)</h2>
                  <ul class="header-dropdown m-r--5">
                      <li class="dropdown">
                          <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                              <i class="material-icons">more_vert</i>
                          </a>
                          <ul class="dropdown-menu pull-right">
                              <li><a href="javascript:void(0);">Action</a></li>
                              <li><a href="javascript:void(0);">Another action</a></li>
                              <li><a href="javascript:void(0);">Something else here</a></li>
                          </ul>
                      </li>
                  </ul>
              </div>
              <div class="body">
                  <div id="donut_chart" class="graph"></div>
              </div>
          </div>
      </div>
      <!-- #END# Donut Chart -->
  </div>
</div>



<!-- Morris Plugin Js -->
<script src="<?= base_url()?>public/plugins/raphael/raphael.min.js"></script>
<script src="<?= base_url()?>public/plugins/morrisjs/morris.js"></script>

<!-- Custom Js -->
<script type="text/javascript">
  $(function () {
    getMorris('line', 'line_chart');
    getMorris('bar', 'bar_chart');
    getMorris('area', 'area_chart');
    getMorris('donut', 'donut_chart');
});


function getMorris(type, element) {
    if (type === 'line') {
      var activity = '<?= json_encode($line_chart); ?>';
      activity = JSON.parse(activity);
      var line_data = [];
        Morris.Line({
            element: element,
            data: activity,
            xkey: 'period',
            ykeys: ['activity'],
            labels: ['Activity'],
            lineColors: ['rgb(0, 188, 212)'],
            lineWidth: 3
        });
    } else if (type === 'bar') {
      var activity = '<?= json_encode($bar_chart); ?>';
      activity = JSON.parse(activity);
      Morris.Bar({
          element: element,
          data: activity,
          xkey: 'x',
          ykeys: ['y'],
          labels: ['Activity'],
          barColors: ['rgb(233, 30, 99)'],
      });
    } else if (type === 'area') {

      var users = '<?= json_encode($area_chart); ?>';
      users = JSON.parse(users);
      var line_data = [];
        Morris.Area({
            element: element,
            data: users,
            xkey: 'period',
            ykeys: ['users'],
            labels: ['Users'],
            pointSize: 5,
            hideHover: 'auto',
            lineColors: ['rgb(233, 30, 99)']
        });
    } else if (type === 'donut') {
      var groups = '<?= json_encode($donut_chart); ?>';
      groups = JSON.parse(groups);
      total_groups = 0;
      $.each(groups,function(i,v){
        total_groups += parseInt(v.value);
      });
      Morris.Donut({
          element: element,
          data: groups,
          colors: ['rgb(233, 30, 99)', 'rgb(0, 188, 212)', 'rgb(255, 152, 0)', 'rgb(0, 150, 136)', 'rgb(233, 30, 99)', 'rgb(0, 188, 212)'],
          formatter: function (y) {
              return ((y/total_groups)*100).toFixed(1) + '%'
          }
      });
    }
}
</script>